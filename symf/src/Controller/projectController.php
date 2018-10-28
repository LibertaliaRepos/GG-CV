<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Response;

class projectController extends AbstractController {
    
    /**
     * @Route("project/add", name="project_add")
     */
    public function addProject() {
        
        $em = $this->getDoctrine()->getManager();
        
        $proj1 = new Project();
        $proj1->setTitle('HTML5 / CSS3 / Javascript');
        $proj1->setAnchor('anchor1');
        $proj1->setExplanation("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.");
        
        $proj2 = new Project();
        $proj2->setTitle('Javascript');
        $proj2->setAnchor('anchor2');
        $proj2->setExplanation("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.");
        
        $em->persist($proj1);
        $em->persist($proj2);
        
        $em->flush();
        
        return new Response('Projects added');
    }
}