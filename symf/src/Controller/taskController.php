<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Form\Task;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;

class taskController extends AbstractController {
    
    /**
     * @Route("/task/form", name="task_form") 
     */
    public function taskForm(Request $request) {
        
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        
        $form = $this->createForm(TaskType::class, $task);
        
                
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $task = $form->getData();
            
            $em->persist($task);
            $em->flush();
            
            
            return $this->redirectToRoute('GGCV_index');
        }
        
        return $this->render('draft/task.html.twig', array('form' => $form->createView()));
    }
}