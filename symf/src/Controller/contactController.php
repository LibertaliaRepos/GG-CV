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

class contactController extends AbstractController {
    
    /**
     * @param Request $request
     * 
     * @Route("/contact/new", name="contact_new")
     */
    public function new(Request $request) {
        
        $params = $request->request;
        $em = $this->getDoctrine()->getManager();
        
//         var_dump($params);
        
        $contact = new Contact();
        $contact->setEmail($params->get('EMAIL'));
        $contact->setSubject($params->get('SUBJECT'));
        $contact->setMessage($params->get('MESSAGE'));
        
        $em->persist($contact);
        
        if (!empty($params->get('AUTHOR'))) {
            $author = new Author();
            $author->setName($params->get('AUTHOR'));
            $author->setContact($contact);
            
            $em->persist($author);
        }
        
        if (!empty($params->get('PHONE'))) {
            $phone = new Phone();
            $phone->setPhoneNumber($params->get('PHONE'));
            $phone->setContact($contact);
            
            $em->persist($phone);
        }
        
        if (!empty($params->get('SOCIETY'))) {
            $society = new Society();
            $society->setSocietyName($params->get('SOCIETY'));
            $society->setContact($contact);
            
            $em->persist($society);
        }
        
        $em->flush();
        
        return new Response('');
    }
}