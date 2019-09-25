<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 28/08/19
 * Time: 18:54
 */

namespace App\Controller;

use App\Entity\Skill_Image;
use App\Entity\Project;
use App\Entity\Image;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class newGGCVController extends AbstractController
{

    /**
     * @Route("/new/", name="new_GGCV_index")
     */
    public function index() {
        return $this->render('_new/index.html.twig', ['objs' => $this->getDoctrine()->getRepository(Skill_Image::class)->findAll(), 'type' => 'skill']);
    }

    /**
     * @Route("/new/projects", name="new_GGCV_projects")
     */
    public function projects() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        $imageRepo = $this->getDoctrine()->getRepository(Image::class);

        foreach ($projects as $key => $project) {
            $projects[$key] = ['project' => $project, 'images' => $project->getImages($imageRepo)];
        }

        return $this->render('_new/projects.html.twig', array('objs' => $projects, 'type' => 'project'));
    }

}