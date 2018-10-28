<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;
use App\Entity\Project;


class GGCVController extends AbstractController {
    
    /**
     * @Route("/", name="GGCV_index")
     */
    public function index() {
        
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();
        
        return $this->render('GGCV/index.html.twig', array('skills' => $skills));
    }
    
    /**
     * @Route("/projects", name="GGCV_projects")
     */
    public function projects() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        
        return $this->render('GGCV/projects.html.twig', array('projects' => $projects));
    }
    
}