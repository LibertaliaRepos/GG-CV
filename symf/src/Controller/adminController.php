<?php
namespace App\Controller;

use App\Entity\ContractType;
use App\Entity\Svg\SvgJson;
use App\Repository\SkillRepository;
use App\Service\JsonSerializer;
use App\Service\menuGenerator;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Skill;
use App\Entity\Project;
use App\Entity\Skill_Image;
use App\Entity\Image;
use App\Entity\XpPro_Image;
use App\Entity\XpPro;
use App\Entity\Form\SkillForm;
use App\Entity\Form\ProjectForm;
use App\Entity\Form\XpProForm;
use App\Service\DetectIE;
use App\Form\SkillType;
use App\Form\ProjectType;
use App\Form\XpProType;

class adminController extends AbstractController {

    public const REPOSITORY_STR = 'Repository';

    /** @var menuGenerator $menuGenerator */
    private $menuGenerator;
    /** @var JsonSerializer $jsonSerializer */
    private $jsonSerializer;
    
    public function __construct(DetectIE $detectIE, menuGenerator $mg, JsonSerializer $jsonSerializer) {
        $detectIE->isIE();

        $this->setMenuGenerator($mg);
        $this->setJsonSerializer($jsonSerializer);
    }

    /**
     * @return menuGenerator
     */
    public function getMenuGenerator(): menuGenerator {
        return $this->menuGenerator;
    }

    /**
     * @param menuGenerator $menuGenerator
     */
    private function setMenuGenerator(menuGenerator $menuGenerator): void {
        $this->menuGenerator = $menuGenerator;
    }

    /**
     * @return JsonSerializer
     */
    public function getJsonSerializer(): JsonSerializer {
        return $this->jsonSerializer;
    }

    /**
     * @param JsonSerializer $jsonSerializer
     */
    private function setJsonSerializer(JsonSerializer $jsonSerializer): void {
        $this->jsonSerializer = $jsonSerializer;
    }

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
                $file = $file->move(
                    $this->getParameter('skill_dir_new'),
                    $filename
                    );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            
            Image::convertSVG($this->getParameter('skill_dir_new').'/'.$filename);
            
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

            $this->updateSvgJson(SvgJson::SKILL_TABLE_ID);

            
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
     * @Route("/admin/xppro", name="GGCV_admin_xppro")
     */
    public function adminXP_pro() {
        $xpProImages = $this->getDoctrine()->getRepository(XpPro_Image::class)->findAll();
        
        return $this->render('GGCV/adminXpPro.html.twig', array('xpProImages' => $xpProImages));
    }
    
    /**
     * @Route(
     *  "/admin/xppro/form", 
     *  name="GGCV_admin_xppro_form"
     * )
     */
    public function xpProForm(Request $request) {
        $xpProForm = new XpProForm(); 
        
        $form = $this->createForm(XpProType::class, $xpProForm);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $xpProForm = $form->getData();
            
            /** @var Symfony\Component\HttpFoundation\File\UploadFile $file */
            $file = $xpProForm->getPicture();
            $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file = $file->move(
                    $this->getParameter('xppro_dir'),
                    $filename
                    );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            
            Image::convertSVG($this->getParameter('xppro_dir').'/'.$filename);
            
            $order = $this->getDoctrine()->getRepository(XpPro_Image::class)->getMaxOrder();
            
            $xpProImage = new XpPro_Image();
            
            $xpPro = new XpPro();
            $xpPro->setTitle($xpProForm->getTitle());
            $xpPro->setContractType($em->getRepository(ContractType::class)->find($xpProForm->getContractType()));
            $xpPro->setAnchor($xpProForm->getAnchor());
            $xpPro->setExplanation($xpProForm->getExplanation());
            
            $image = new Image();
            $image->setFilename($filename);
            
            $xpProImage->setXpPro($xpPro);
            $xpProImage->setImage($image);
            $xpProImage->setOrder($order + 1);
            
            
            $em->persist($xpProImage);
            $em->flush();
            
            return $this->redirectToRoute('GGCV_admin_xppro');
        }
        
        return $this->render('GGCV/xpproForm.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(
     *  "/admin/xppro/form/{id}",
     *  name="GGCV_admin_skill_update",
     *  requirements={"id"="\d+"}
     * )
     */
    public function updateXPPro(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        /** @var XpPro_Image $xpproImage */
        $xpproImage = $this->getDoctrine()->getRepository(XpPro_Image::class)->find($id);

        $em->persist($xpproImage);

        $xpproForm = new XpProForm();
        $xpproForm->setTitle($xpproImage->getXpPro()->getTitle());
        $xpproForm->setContractType($xpproImage->getXpPro()->getContractType()->getIdContractType());
        $xpproForm->setAnchor($xpproImage->getXpPro()->getAnchor());
        $xpproForm->setExplanation($xpproImage->getXpPro()->getExplanation());
        $xpproForm->setOldPicture($xpproImage->getImage()->getFilename());
        $xpproForm->setPicture($xpproImage->getImage()->getFile($this->getParameter('xppro_dir')));

        $form = $this->createForm(XpProType::class, $xpproForm);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $xpproForm = $form->getData();

            if ($xpproForm->getPicture() != null) {

                $file = $xpproForm->getPicture();
                $filename = $this->generateUniqueFileName().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('xppro_dir'),
                        $filename
                    );
                } catch (FileException $e) {
                    throw new \Exception($e->getMessage());
                }

                $xpproImage->getImage()->setFilename($filename);

                Image::convertSVG($this->getParameter('xppro_dir').'/'.$filename);
                Image::deleteSVGRelatedFile($this->getParameter('xppro_dir').'/'.$xpproForm->getOldPicture());
                unlink($this->getParameter('xppro_dir').'/'.$xpproForm->getOldPicture());
            }

            if ($xpproForm->getContractType() != null) {
                $contractType = $em->getRepository(ContractType::class)->find($xpproForm->getContractType());

                $xpproImage->getXpPro()->setContractType($contractType);
            }

            $xpproImage->getXpPro()->setTitle($xpproForm->getTitle());
            $xpproImage->getXpPro()->setAnchor($xpproForm->getAnchor());
            $xpproImage->getXpPro()->setExplanation($xpproForm->getExplanation());

            $em->flush();

            return $this->redirectToRoute('GGCV_admin_xppro');
        }

        return $this->render('GGCV/xpproForm.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @return string
     */
    private function generateUniqueFileName() {
        return md5(uniqid());
    }

    /**
     * @param array $files
     * @param array $mimeTypes
     * @return bool
     */
    private function testMimeType(array $files, array $mimeTypes) {
        foreach ($files as $file) {
            if (!in_array($file->getMimeType(), $mimeTypes)) {
                return false;
            }
        }
        
        return true;
    }

    private function updateSvgJson(int $id_table) {

        if (! in_array($id_table, SvgJson::ALLOWED_TABLE_ID))
            throw new \Exception('La table d\'id ' . $id_table . ' n\'existe pas');

        switch ($id_table) {
            case SvgJson::SKILL_TABLE_ID:       $model = Skill::class;      break;
            case SvgJson::PROJECT_TABLE_ID:     $model = Project::class;    break;
            case SvgJson::XPPRO_TABLE_ID:       $model = XpPro::class;      break;
        }

        $em = $this->getDoctrine()->getManager();
        $currentTitles = $this->getDoctrine()->getRepository($model)->getAllTitles();

        /** @var SvgJson $titlesSVG_table */
        $titlesSVG_table = (empty($titles = $em->getRepository(SvgJson::class)->findOneBy(['id_svg_json' => $id_table]))) ? new SvgJson() : $titles;


        $em->persist($titlesSVG_table);

        if ($titlesSVG_table !== $currentTitles) {
            $titlesSVG_table->setIdSvgJson($id_table);
            $titlesSVG_table->setJsonStr($currentTitles);
            $titlesSVG_table->setScript($this->menuGenerator->buildTitleSvg($this->getJsonSerializer()->deserialize($currentTitles)));

            $em->flush();
        }
    }

    
}