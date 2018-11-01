<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillType extends AbstractType {
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('title', TextType::class)
                ->add('anchor', TextType::class)
                ->add('explanation', TextareaType::class)
                ->add('annuler', ResetType::class)
                ->add('ajouter', SubmitType::class);
        
    }
    
}