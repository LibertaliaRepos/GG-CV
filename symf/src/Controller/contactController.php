<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Author;
use App\Entity\Phone;
use App\Entity\Society;
use App\Service\JsonResponse;
use App\Service\EmailServ;
use App\Service\SmtpTransport;
use App\Service\Debug\DebugAjax;
use App\Service\FileUploader;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class contactController extends AbstractController {
    
    private $uploadedImagePackage;
    private $uploadedPdfPackage;
    
    public function __construct() {
        $this->uploadedImagePackage = new PathPackage('/uploads/contact/images', new EmptyVersionStrategy());
        $this->uploadedPdfPackage = new PathPackage('/uploads/contact/pdf', new EmptyVersionStrategy());
    }
    
    /**
     * @param Request $request
     *
     * @Route("/contact/new", name="contact_new")
     */
    public function new(Request $request, JsonResponse $jsonResponse, EmailServ $emailServ, SmtpTransport $st, DebugAjax $debug) {
        
        if ($request->isXmlHttpRequest()) {

            $params = json_decode($request->getContent(), true);
           
            
            $em = $this->getDoctrine()->getManager();
            
            if (!$emailServ->emailFormatTest($params['contact']['email'])) {
                return $this->json(
                        array(
                            'response' => '<h3>Erreur :</h3><p>Email incorrect</p>',
                            'status'   => false
                        ),
                        Response::HTTP_FORBIDDEN
                    );
            }
            
            $contact = new Contact();
            $contact->setEmail($params['contact']['email']);
            $contact->setSubject($params['contact']['subject']);
            $contact->setMessage($params['contact']['message']);
            
            $em->persist($contact);
            $author = new Author();
            
            if (isset($params['author']) && !empty($params['author'])) {
                
                $author->setName($params['author']);
                $author->setContact($contact);
                
                $em->persist($author);
            }
            
            if (isset($params['phone']) && !empty($params['phone'])) {
                $phone = new Phone();
                $phone->setPhoneNumber($params['phone']);
                $phone->setContact($contact);
                
                $em->persist($phone);
            }
            
            if (isset($params['society']) && !empty($params['society'])) {
                $society = new Society();
                $society->setSocietyName($params['society']);
                $society->setContact($contact);
                
                $em->persist($society);
            }
            
            $em->flush();
            
            $params['contact']['date'] = new \DateTime();
            
            $this->sendEmailToFranceserv($params, $st, $debug);
            
            return $this->json(array(
                'status'    =>  true,
                'response'  =>  $jsonResponse->mailResponse($author)
            ));
        }
        
        
        return $this->json(
            array('params' => 'error'), 
            Response::HTTP_BAD_REQUEST, 
            array('Content-type' => 'application/json')
        );
    }
    
    /**
     * @Route(
     *  "contact/email"
     * )
     */
    public function designEmail() {
        $params = [
          'contact' => [
              'email' => 'email.du@client.com',
              'subject' => 'Sujet de l\'email',
              'message' => 'Message du client, de l\'utilisateur',
              'date'    =>  new \DateTime()
          ],
           'author' => 'nom de l\'utilisateur',
           'phone' => '01.23.45.67.89',
           'society' => 'nom de la sociétée' 
        ];
        
        return $this->render('emails/toFranceserv.html.twig', ['params' => $params]);
    }
    
    private function sendEmailToFranceserv(array $params, SmtpTransport $st, DebugAjax $debug) {
        $mailer = new \Swift_Mailer($st->getSwiftTransport()); 
        
        $message = (new \Swift_Message($params['contact']['subject']))
        ->setFrom($this->getParameter('my_email'))
        ->setTo($this->getParameter('my_email'))
        ->setBody(
            $this->renderView(
                'emails/toFranceserv.html.twig', 
                ['params' => $params]
                ),
            'text/html'
            );
        
        $result = $mailer->send($message);
        
        $debug->debug('debug_swift_send', $result);
    }
    
    /**
     * @Route(
     *  "contact/upload/file"
     * )
     */
    public function upload(Request $request, FileUploader $fu) {
        
        $file = $request->files->get('file');
        
        $mime = $file->getMimeType();
        
        switch (true) {
            case (in_array($mime, FileUploader::ALLOWED_IMG_MIME)):
                $targetDirectory = $this->getParameter('froala_uploads_images');
                $folder = 'images';
                break;
            
            case (in_array($mime, FileUploader::ALLOWED_FILE_MIME)):
                $targetDirectory = $this->getParameter('froala_uploads_pdf');
                $folder = 'pdf';
                break;
        }
        
        $file = $fu->upload($targetDirectory ,$file);
        
        $ext = $file->guessExtension();
        $filename = $fu->guessFileNameNoExt($file);
        
        $url = $this->generateUrl(
                'contact_get_froala_files',
                [
                    'folder' => $folder,
                    'filename' => $filename,
                    '_format' => $ext
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
        
       return $this->json(['link' => $url]); 
    }
    
    /**
     * @Route(
     *  "/uploads/contact/{folder}/{filename}.{_format}",
     *  name="contact_get_froala_files",
     *  requirements={
     *      "folder":"images|pdf",
     *      "_format":"jpeg|jpg|png|gif|pdf"
     *  }
     * )
     */
    public function getImageRealUrl(string $filename, string $_format) {
        
        switch (true) {
            case (in_array($_format, FileUploader::ALLOWED_IMG_EXT)):   $package = $this->uploadedImagePackage; break;
            case (in_array($_format, FileUploader::ALLOWED_FILE_EXT)):  $package = $this->uploadedPdfPackage; break;
        }
        
        $file = new File($package->getUrl($filename .'.'. $_format));
        
        return $this->file($file);
    }
}