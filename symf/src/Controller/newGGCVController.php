<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 28/08/19
 * Time: 18:54
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class newGGCVController extends AbstractController
{

    /**
     * @Route("/new/", name="new_GGCV_index")
     */
    public function index() {


        return $this->render('_new/index.html.twig');
    }

}