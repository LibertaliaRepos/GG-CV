<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Skill;
use App\Form\SkillType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Skill_Image;
use App\Entity\Image;
use App\Entity\Form\SkillForm;
use Symfony\Component\HttpFoundation\File\File;



class adminController extends AbstractController {
    
    /**
     * @Route("/admin/skill", name="GGCV_admin_skill")
     */
    public function adminSkill() {
        
        $skillImages = $this->getDoctrine()->getRepository(Skill_Image::class)->findAll();
        
        return $this->render('GGCV/adminSkill.html.twig', array('skillsImages' => $skillImages));
    }
    
    /**
     * @Route(
     *  "/admin/skill/form", 
     *  name="GGCV_admin_skill_form"
     * )
     */
    public function skillForm(Request $request) {
        $skillForm = new SkillForm(); 
        
        
        $form = $this->createForm(SkillType::class, $skillForm);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $skillForm = $form->getData();
            
            /** @var Symfony\Component\HttpFoundation\File\UploadFile $file */
            $file = $skillForm->getPicture();
            $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();
            
            try {
                $file->move(
                    $this->getParameter('skill_dir'),
                    $filename
                    );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            
            $skillImage = new Skill_Image();
            
            $skill = new Skill();
            $skill->setTitle($skillForm->getTitle());
            $skill->setAnchor($skillForm->getAnchor());
            $skill->setExplanation($skillForm->getExplanation());
            
            $image = new Image();
            $image->setFilename($filename);
            
            $skillImage->setSkill($skill);
            $skillImage->setImage($image);
            
            $em->persist($skillImage);
            $em->flush();
        }
        
        return $this->render('GGCV/skillForm.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route(
     *  "/admin/skill/form/{id}",
     *  name="GGCV_admin_skill_update",
     *  requirements={"id"="\d+"}
     * )
     */
    public function updateSkill(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $skillImage = $this->getDoctrine()->getRepository(Skill_Image::class)->find($id);
        
        $em->persist($skillImage);
        
        $skillForm = new SkillForm();
        $skillForm->setTitle($skillImage->getSkill()->getTitle());
        $skillForm->setAnchor($skillImage->getSkill()->getAnchor());
        $skillForm->setExplanation($skillImage->getSkill()->getExplanation());
        $skillForm->setOldPicture($skillImage->getImage()->getFilename());
        $skillForm->setPicture($skillImage->getImage()->getFile($this->getParameter('skill_dir')));
        
        $form = $this->createForm(SkillType::class, $skillForm);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $skillForm = $form->getData();
            
            if ($skillForm->getPicture() != null) {
            
                $file = $skillForm->getPicture();
                $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();
                
                try {
                    $file->move(
                        $this->getParameter('skill_dir'),
                        $filename
                        );
                } catch (FileException $e) {
                    throw new \Exception($e->getMessage());
                }
                
                $skillImage->getImage()->setFilename($filename);
            }
                        
            $skillImage->getSkill()->setTitle($skillForm->getTitle());
            $skillImage->getSkill()->setAnchor($skillForm->getAnchor());
            $skillImage->getSkill()->setExplanation($skillForm->getExplanation());
            
            
            $em->flush();
            
            unlink($this->getParameter('skill_dir').'/'.$skillForm->getOldPicture());
            
            return $this->redirectToRoute('GGCV_admin_skill');
        }
        
        return $this->render('GGCV/skillForm.html.twig', array('form' => $form->createView()));
        
    }
    
    /**
     * @Route("/admin/project", name="GGCV_admin_project")
     */
    public function projectForm(Request $request) {
        
        $project = new Project();
        
        $form = $this->createForm(ProjectType::class, $project);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $project = $form->getData();
            
            $em->persist($project);
            $em->flush();
        }
        
        return $this->render('GGCV/projectForm.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @return string
     */
    private function generateUniqueFileName() {
        return md5(uniqid());
    }
    
    
}