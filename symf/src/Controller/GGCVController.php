<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Entity\Skill_Image;
use App\Entity\Image;
use App\Service\DetectIE;


class GGCVController extends AbstractController {
    
    
    
    public function __construct(DetectIE $detectIE) {
        $detectIE->isIE();
    }
    
    /**
     * @Route("/", name="GGCV_index")
     */
    public function index() {
                
        $skillsImages = $this->getDoctrine()->getRepository(Skill_Image::class)->findAll();
        
        return $this->render(
            'GGCV/index.html.twig', 
            array(
                    'skillImages' => $skillsImages, 
                    'active'      => 'accueil'
                )
            );
    }
    
    /**
     * @Route("/projects", name="GGCV_projects")
     */
    public function projects() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        $imageRepo = $this->getDoctrine()->getRepository(Image::class);
        
        foreach ($projects as $key => $project) {
            $projects[$key] = ['project' => $project, 'images' => $project->getImages($imageRepo)];
        }
        
        return $this->render('GGCV/projects.html.twig', array('projects' => $projects, 'active' => 'projet'));
    }
    
    /**
     * @Route("/contact", name="GGCV_contact")
     */
    public function contactForm() {
        
        return $this->render('GGCV/contact.html.twig', array('active' => 'contact'));
    }
    
}