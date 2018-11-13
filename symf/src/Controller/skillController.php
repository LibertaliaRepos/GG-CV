<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Skill;
use App\Entity\Skill_Image;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Response;


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
    
}