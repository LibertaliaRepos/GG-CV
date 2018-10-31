<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('email', EmailType::class)
                ->add('subject', TextType::class)
                ->add('author', TextType::class)
                ->add('phone', TextType::class)
                ->add('society', TextType::class);
    }
    
}