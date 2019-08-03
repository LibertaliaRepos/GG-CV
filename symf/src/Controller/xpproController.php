<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 03/08/19
 * Time: 11:38
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\XpPro_Image;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class xpproController extends AbstractController
{
    /**
     * @Route(
     *      "/admin/xppro/del/{id}",
     *      name="GGCV_admin_xppro_del",
     *      requirements={"id"="\d+"}
     * )
     */
    public function delete($id) {

        $em = $this->getDoctrine()->getManager();
        $xpproImage = $this->getDoctrine()->getRepository(XpPro_Image::class)->find($id);

        $filename = $xpproImage->getImage()->getFilename();

        Image::deleteSVGRelatedFile($this->getParameter('xppro_dir').'/'. $filename);


        $filename = $this->getParameter('xppro_dir').'/'. $filename;

        $em->remove($xpproImage);

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
     *      "/admin/xppro/order",
     *      name="GGCV_admin_xppro_order"
     * )
     */
    public function updateOrder(Request $request) {

        if($request->isXmlHttpRequest()) {
            $params = json_decode($request->getContent(), true);

            $em = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository(XpPro_Image::class);

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