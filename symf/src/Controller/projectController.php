<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;

class projectController extends AbstractController {
    
    /**
     * @Route(
     *      "admin/project/del/{id}",
     *      name="GGCV_admin_project_del",
     *      requirements={"id"="\d+"}
     *  )
     */
    public function delete($id) {
        $em = $this->getDoctrine()->getManager();
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
        $images = $project->getImages($this->getDoctrine()->getRepository(Image::class));
        
        $em->remove($project);
        foreach ($images as $image) {
            $em->remove($image);
        }
        
        try {
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(
                array('deleted' => false, 'error' => $e->getMessage()),
                Response::HTTP_CONFLICT
                );
        }
        
        foreach ($images as $image) {
            $image->unlink($this->getParameter('project_dir'));
        }
        
        return $this->json(array('deleted' => true), Response::HTTP_OK);
    }
}