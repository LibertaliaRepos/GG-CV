<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Skill;
use App\Form\SkillType;
use Symfony\Component\HttpFoundation\Request;



class adminController extends AbstractController {
    /**
     * @Route("/admin/skill", name="GGCV_admin_skill")
     */
    public function skillForm(Request $request) {
        
        $skill = new Skill();
        
        $form = $this->createForm(SkillType::class, $skill);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $skill = $form->getData();
            
            $em->persist($skill);
            $em->flush();
        }
        
        return $this->render('GGCV/skillForm.html.twig', array('form' => $form->createView()));
    }
    
}