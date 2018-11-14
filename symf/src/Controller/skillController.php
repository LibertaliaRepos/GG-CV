<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;
use App\Entity\Skill_Image;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Annotations\Annotation\Target;


class skillController extends AbstractController {
    
    /**
     * @Route(
     *      "/admin/skill/del/{id}",
     *      name="GGCV_admin_skill_del",
     *      requirements={"id"="\d+"}
     * )
     */
    public function delete($id) {
        
        $em = $this->getDoctrine()->getManager();
        $skillImage = $this->getDoctrine()->getRepository(Skill_Image::class)->find($id);
        
        $filename = $skillImage->getImage()->getFilename();
        
        Image::deleteSVGRelatedFile($this->getParameter('skill_dir').'/'. $filename);
        
        
        $filename = $this->getParameter('skill_dir').'/'. $filename;
        
        $em->remove($skillImage);
        
        try {
            $em->flush();
        } catch (\Exception $e) {
           
            return $this->json(
                    array('deleted' => false, 'error' => $e->getMessage()),
                    Response::HTTP_CONFLICT
                );
        }
        
        unlink($filename);
        
        return $this->json(array('deleted' => true), Response::HTTP_OK);
    }
    
    /**
     * @Route(
     *      "/admin/skill/order",
     *      name="GGCV_admin_skill_order"
     * )
     */
    public function updateOrder(Request $request) {
        
        if($request->isXmlHttpRequest()) {
            $params = json_decode($request->getContent(), true);
            
            $em = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository(Skill_Image::class);
            
            $target = $repo->find($params['target']['id']);
            $selected = $repo->find($params['selected']['id']);
            
            $em->persist($target);
            $em->persist($selected);
            
            $target->setOrder($params['target']['order']);
            $selected->setOrder($params['selected']['order']);
            
            $em->flush();
            
            return $this->json(json_encode([$target, $selected]));
        }
    }
}