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
use App\Entity\Form\ProjectForm;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Service\DetectIE;



class adminController extends AbstractController {
    
    public function __construct(DetectIE $detectIE) {
        $detectIE->isIE();
    }
    
    /**
     * @Route("/admin/skill", name="GGCV_admin_skill")
     */
    public function adminSkill() {
        
        $skillImages = $this->getDoctrine()->getRepository(Skill_Image::class)->findby([], ['order' => 'ASC']);
        
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
                $file = $file->move(
                    $this->getParameter('skill_dir'),
                    $filename
                    );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            
            Image::convertSVG($this->getParameter('skill_dir').'/'.$filename);
            
            $order = $this->getDoctrine()->getRepository(Skill_Image::class)->getMaxOrder();
            
            
            $skillImage = new Skill_Image();
            
            $skill = new Skill();
            $skill->setTitle($skillForm->getTitle());
            $skill->setAnchor($skillForm->getAnchor());
            $skill->setExplanation($skillForm->getExplanation());
            
            $image = new Image();
            $image->setFilename($filename);
            
            $skillImage->setSkill($skill);
            $skillImage->setImage($image);
            $skillImage->setOrder($order + 1);
            
            
            $em->persist($skillImage);
            $em->flush();
            
            return $this->redirectToRoute('GGCV_admin_skill');
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
                    $file = $file->move(
                        $this->getParameter('skill_dir'),
                        $filename
                        );
                } catch (FileException $e) {
                    throw new \Exception($e->getMessage());
                }
                
                $skillImage->getImage()->setFilename($filename);
                
                Image::convertSVG($this->getParameter('skill_dir').'/'.$filename);
                Image::deleteSVGRelatedFile($this->getParameter('skill_dir').'/'.$skillForm->getOldPicture());
                unlink($this->getParameter('skill_dir').'/'.$skillForm->getOldPicture());
            }
            
            $skillImage->getSkill()->setTitle($skillForm->getTitle());
            $skillImage->getSkill()->setAnchor($skillForm->getAnchor());
            $skillImage->getSkill()->setExplanation($skillForm->getExplanation());
            
            $em->flush();

            return $this->redirectToRoute('GGCV_admin_skill');
        }
        
        return $this->render('GGCV/skillForm.html.twig', array('form' => $form->createView()));
        
    }
    
    
    /**
     * @Route("/admin/project", name="GGCV_admin_project")
     */
    public function projectList() {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        
        
        return $this->render('GGCV/adminProject.html.twig', array('projects' => $projects));
    }
    
    /**
     * @Route("/admin/project/form", name="GGCV_admin_project_form")
     */
    public function projectForm(Request $request) {
        
        $projectForm = new ProjectForm();
        
        $fileError = array();
        $allowedTypes = array(Image::JPEG_MIME, Image::PNG_MIME);
        
        $form = $this->createForm(ProjectType::class, $projectForm);
        $form->add('images', FileType::class, array(
            'multiple'      => true,
            'data_class'    => null,
            'required'      => true,
            'attr'          => array(
                'accept' => 'image/png, image/jpeg'
            )
        ));
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $projectForm = $form->getData();
            
            $files = $projectForm->getImages()->toArray()[0];
            
            if ($this->testMimeType($files, $allowedTypes)) {
                
                $repo = $this->getDoctrine()->getRepository(Project::class);
            
                $project = new Project();
                $project->setTitle($projectForm->getTitle());
                $project->setAnchor($projectForm->getAnchor());
                $project->setExplanation($projectForm->getExplanation());
                $project->setOrder($repo->getMaxOrder() + 1);
                
                foreach ($files as $file) {
                    $filename = $this->generateUniqueFileName() .'.'. $file->guessExtension();
                    try {
                        
                        $file->move(
                            $this->getParameter('project_dir'),
                            $filename
                            );
                        
                    } catch (FileException $e) {
                        throw new \Exception($e->getMessage());
                    }
                    
                    $image = new Image();
                    $image->setFilename($filename);
                    $image->setProject($project);
                    
                    
                    
                    $em->persist($image);
                }
                
                
                
                $em->persist($project);
                $em->flush();
                
                return $this->redirectToRoute('GGCV_admin_project');
            } else {
                $allowedStr = implode(', ', $allowedTypes);
                
                $fileError['message'] = 'Les images autorisés doivent au format: <strong>'. $allowedStr .'</strong>.';
            }
        }
        
        return $this->render(
                'GGCV/projectForm.html.twig', 
                array(
                    'form' => $form->createView(), 
                    'fileError' => $fileError,
                    'images' => array()
                )
            );
    }
    
    /**
     * @Route(
     *  "/admin/project/form/{id}",
     *  name="GGCV_admin_project_update",
     *  requirements={"id"="\d+"}
     * )
     */
    public function updateProject($id, Request $request) {
        
        $allowedTypes = array(Image::JPEG_MIME, Image::PNG_MIME);
        
        $em = $this->getDoctrine()->getManager();
        $doc = $this->getDoctrine();
        $project = $doc->getRepository(Project::class)->find($id);
        
        $images = $project->getImages($doc->getRepository(Image::class));
        
        
        for($i = 0; $i < count($images); ++$i) {
            if ($i < count($images) - 1) {
                $em->persist($images[$i]);
            } elseif ($i == count($images) - 1) {
                $ref = $images[$i];
                $em->persist($ref);
            }
        }
        
        $project = $ref->getProject();
        
        
        $fileError = array();
        
        $projectForm = new ProjectForm();
        $projectForm->setTitle($project->getTitle());
        $projectForm->setAnchor($project->getAnchor());
        $projectForm->setExplanation($project->getExplanation());
        
        $form = $this->createForm(ProjectType::class, $projectForm);
        $form->add('images', FileType::class, array(
            'multiple'      => true,
            'data_class'    => null,
            'required'      => false,
            'attr'          => array(
                'accept' => 'image/png, image/jpeg'
            )
        ));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            $formImages = $data->getImages()->toArray()[0];
            
            if (!empty($formImages) && $this->testMimeType($formImages, array(Image::JPEG_MIME, Image::PNG_MIME))) {
                foreach ($images as $image) {
                    $em->remove($image);
                    unlink($this->getParameter('project_dir') .'/'. $image->getFilename());
                }
                
                foreach ($formImages as $formImage) {
                    $filename = $this->generateUniqueFileName() .'.'. $formImage->guessExtension();
                    try {
                        
                        $formImage->move(
                            $this->getParameter('project_dir'),
                            $filename
                            );
                        
                    } catch (FileException $e) {
                        throw new \Exception($e->getMessage());
                    }
                    
                    $image = new Image();
                    $image->setFilename($filename);
                    $image->setProject($project);
                    
                    $em->persist($image);
                }
                
                $project->setTitle($data->getTitle());
                $project->setAnchor($data->getAnchor());
                $project->setExplanation($data->getExplanation());
                
                
                $em->flush();
                
                return $this->redirectToRoute('GGCV_admin_project');
            } else {
                $allowedStr = implode(', ', $allowedTypes);
                
                $fileError['message'] = 'Les images autorisés doivent au format: <strong>'. $allowedStr .'</strong>.';
            }
        }
        
        return $this->render(
                'GGCV/projectForm.html.twig', 
                array(
                    'form' => $form->createView(), 
                    'fileError' => $fileError,
                    'images' => $images
                )
            );
    }
    
    /**
     * @return string
     */
    private function generateUniqueFileName() {
        return md5(uniqid());
    }
    
    private function testMimeType(array $files, array $mimeTypes) {
        foreach ($files as $file) {
            if (!in_array($file->getMimeType(), $mimeTypes)) {
                return false;
            }
        }
        
        return true;
    }
    
}