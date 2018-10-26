<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;


class leftMenuController extends AbstractController {
    
    /**
     * @Route("/leftMenu/index", name="leftMenu_index")
     */
    public function indexLeftMenu() {
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();
        
        return $this->render('menu/leftMenu.html.twig', array('skills' => $skills));
    }
    
}