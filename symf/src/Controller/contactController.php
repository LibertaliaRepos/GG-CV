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

class contactController extends AbstractController {
    
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
     *  "contact/upload/image"
     * )
     */
    public function uploadImage(Request $request, FileUploader $fu,DebugAjax $debug) {
        
        $file = $request->files->get('file');
        
        $debug->debug('debug_upload_image', $file);
        
        $fu->upload($file);
        
       return new Response('ok'); 
    }
}