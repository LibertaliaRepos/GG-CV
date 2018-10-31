<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TaskType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $option) {
        
        $builder->add('task')
                ->add('dueDate', DateType::class)
                ->add('save', SubmitType::class);
    }
}