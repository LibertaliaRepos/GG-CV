<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;


class GGCVController extends AbstractController {
    
    /**
     * @Route("/", name="GGCV_index")
     */
    public function index() {
        
        $skills = $this->getDoctrine()->getRepository(Skill::class)->findAll();
        
        return $this->render('GGCV/index.html.twig', array('skills' => $skills));
    }
    
}