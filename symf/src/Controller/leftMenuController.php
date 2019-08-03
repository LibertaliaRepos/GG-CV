<?php

namespace App\Controller;

use App\Entity\XpPro_Image;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Entity\Skill_Image;


class leftMenuController extends AbstractController {
    
    /**
     * @Route("/leftMenu/skills", name="leftMenu_index")
     */
    public function skillsLeftMenu() {
        $skills = $this->getDoctrine()->getRepository(Skill_Image::class)->findAllSkills();
        
        return $this->render('menu/leftMenu.html.twig', array('skills' => $skills));
    }
    
    /**
     * @Route("/leftMenu/projects", name="leftMenu_projects")
     */
    public function projectsLeftMenu() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        
        return $this->render('menu/leftMenu.html.twig', array('projects' => $projects));
    }

    /**
     * @Route("/leftMenu/projects", name="leftMenu_xppros")
     */
    public function xpprosLeftMenu() {
        $xppros = $this->getDoctrine()->getRepository(XpPro_Image::class)->findAllXP_Pros();

        return $this->render('menu/leftMenu.html.twig', array('xppros' => $xppros));
    }
}