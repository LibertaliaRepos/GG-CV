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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\Convertion;

class contactController extends AbstractController {
    
    private $uploadedImagePackage;
    private $uploadedPdfPackage;
    private $session;
    
    public function __construct() {
        $this->uploadedImagePackage = new PathPackage('/uploads/contact/images', new EmptyVersionStrategy());
        $this->uploadedPdfPackage = new PathPackage('/uploads/contact/pdf', new EmptyVersionStrategy());
        $this->session = new Session(new NativeSessionStorage(), new AttributeBag());
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
            
            $attachmentFolder = $this->session->get('attachmentFolder', null);
            $toSend = [];
            
            if ($attachmentFolder) {
                $path = $this->getParameter('contact_pdf_tmp') .'/'. $attachmentFolder;
            
                $files = scandir($path);
                foreach ($files as $key => $file) {
                    if ($file != '.' && $file != '..') {
                        $toSend[$key] = $path . '/' . $file;
                    }
                }
            }
            
            $em->flush();
            
            $params['contact']['date'] = new \DateTime();
            
            $test = $this->sendEmailToFranceserv($params, $st, $debug, $toSend);
            $fileSystem = new Filesystem();
            
            if($test == 0) {
                try {
                    $fileSystem->remove($path);
                } catch (IOExceptionInterface $e) {
                    throw new IOException($e->getPath());
                }
            } else {
                try {
                    $target = $this->getParameter('froala_uploads_pdf') .'/'. $attachmentFolder;
                    $fileSystem->mirror($path, $target);
                    $fileSystem->remove($path);
                } catch (IOExceptionInterface $e) {
                    throw new IOException($e->getPath());
                }
            }
            
            $this->session->set('attachmentFolder', self::guessAttachmentDir());
            
            
            return $this->json(array(
                'status'    =>  true,
                'response'  =>  $jsonResponse->mailResponse($author),
                'attchment' => $this->session->get('attachmentFolder')
            ));
        }
        
        
        return $this->json(
            array('params' => 'error'), 
            Response::HTTP_BAD_REQUEST, 
            array('Content-type' => 'application/json')
        );
    }
    
    
    private function sendEmailToFranceserv(array $params, SmtpTransport $st, DebugAjax $debug, array $attachments = []) {
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
        
        if(!empty($attachments)) {
            foreach ($attachments as $attach) {
                $message->attach(\Swift_Attachment::fromPath($attach));
            }
        }
        
        return $mailer->send($message);
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
    
    /**
     * @Route(
     *  "/contact/init/attachment",
     *  name="contact_init_attachment"
     * )
     */
    public function uploadAttachmentInit(Request $request, Convertion $conv, FileUploader $fu) : Response {
        
        if ($request->isXmlHttpRequest()) {
            $attachmentFolderTmp = $request->get('attachmentFolder');
            $attachmentFolderTmpPath = $this->getParameter('contact_pdf_tmp') . '/' . $attachmentFolderTmp;
            $this->session->set('attachmentFolder', $attachmentFolderTmp);
            
            $fileSystem = new Filesystem();
            $file = $request->files->get('file');
            
            try {
                $fileSystem->mkdir($attachmentFolderTmpPath);
            } catch (IOExceptionInterface $e) {
                throw new IOException('An error occurred while creating your directory at ' . $e->getPath());
            }
            
            $originalFilename = htmlspecialchars($file->getClientOriginalName());
            $size = $conv->bytes2Mo($request->request->get('fileSize'), true);
            
            $file = $fu->upload($attachmentFolderTmpPath, $file);
            
            $viewFile = [
                'id' => $fu->guessFileNameNoExt($file),
                'name'  =>  $originalFilename,
                'size'  =>  $size,
                'ext'   => $file->guessExtension(),
                'attachmentFolder' => $attachmentFolderTmp
            ];
            
            return new Response(
                    $this->renderView(
                        'contactAttachment/contactAttachment.html.twig',
                        ['file' => $viewFile]
                    )
                );
        }
        
        throw new BadRequestHttpException();
    }
    
    /**
     * @Route(
     *  "/contact/tmp/attchment/del",
     *  name="contact_tmp_del"
     * )
     */
    public function delTmpAttachment(Request $request) {
        if ($request->isXmlHttpRequest()) {
            
            $response = new Response();
            
            $filename = $request->get('id') .'.'. $request->get('ext');
            $filename = str_replace('#', '', $filename);
            $filename = $this->getParameter('contact_pdf_tmp') .'/'. $request->get('folderAttachment'). '/' . $filename;
            
            $fileSystem = new Filesystem();
            
            try {
                $fileSystem->remove($filename);
            } catch (IOExceptionInterface $e) {
                throw new IOException($e->getPath());
            }
            
            return $this->json(['id' => str_replace('#', '', $request->get('id'))]);
        }
        
        return $response->setContent(false);
    }
    
    /**
     * @Route(
     *  "/contact/clear/tmp",
     *  name="contact_clear_tmp"
     * )
     * 
     * @param Request $request
     * @return Response
     */
    public function clearTmp(Request $request, Filesystem $fs) : Response {
        if($request->isXmlHttpRequest()) {
            $folder = $this->getParameter('contact_pdf_tmp') .'/'. $this->session->get('attachmentFolder');
            
            try {
                $fs->remove($folder);
            } catch (IOExceptionInterface $e) {
                throw new IOException('contact_clear_tmp => ' . $e->getPath());
            }
            $this->session->clear();
            
            return $this->json(['remove' => true]);
        }
        
        $this->session->clear();
    }
    
    /**
     * 
     * @return string
     */
    public static function guessAttachmentDir() : string {
        return 'contact-'.uniqid();
    }
}