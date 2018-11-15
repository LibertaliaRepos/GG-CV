<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
    
    /**
     * @Route(
     *      "admin/project/order",
     *      name="GGCV_admin_project_order"
     *  )
     */
    public function updateOrder(Request $request) {
        
        if($request->isXmlHttpRequest()) {
            $params = json_decode($request->getContent(), true);
            
            $em = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository(Project::class);
            
            $target = $repo->find($params['target']['id']);
            $selected = $repo->find($params['selected']['id']);
            
            $em->persist($target);
            $em->persist($selected);
            
            $target->setOrder($params['target']['order']);
            $selected->setOrder($params['selected']['order']);
            
            $em->flush();
            
            return $this->json(json_encode($params));
        }
        
    }
}