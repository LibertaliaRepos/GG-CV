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

class contactController extends AbstractController {
    
    /**
     * @param Request $request
     *
     * @Route("/contact/new", name="contact_new")
     */
    public function new(Request $request, JsonResponse $jsonResponse, EmailServ $emailServ) {
        
        if ($request->isXmlHttpRequest()) {

            $params = json_decode($request->getContent(), true);
           
            
            $em = $this->getDoctrine()->getManager();
            
            
            $email = $emailServ->emailFormatTest($params['contact']['email']);
            
            file_put_contents('debug_email', var_export($email, true));
            
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
}