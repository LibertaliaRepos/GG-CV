<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Entity\Skill_Image;


class GGCVController extends AbstractController {
    
    /**
     * @Route("/", name="GGCV_index")
     */
    public function index() {
        
        $skillsImages = $this->getDoctrine()->getRepository(Skill_Image::class)->findAll();
        
        return $this->render('GGCV/index.html.twig', array('skillImages' => $skillsImages));
    }
    
    /**
     * @Route("/projects", name="GGCV_projects")
     */
    public function projects() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        
        return $this->render('GGCV/projects.html.twig', array('projects' => $projects));
    }
    
    /**
     * @Route("/contact", name="GGCV_contact")
     */
    public function contactForm() {
        
        return $this->render('GGCV/contact.html.twig');
    }
    
}