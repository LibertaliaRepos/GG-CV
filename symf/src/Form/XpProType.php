<?php
namespace App\Form;

use App\Entity\ContractType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Form\XpProForm;

class XpProType extends AbstractType {


    protected $em;

    /**
     * XpProType constructor.
     */
    public function __construct(EntityManager $em) {
        $this->setEm($em);
    }

    /**
     * @return mixed
     */
    public function getEm(): EntityManager {
        return $this->em;
    }

    /**
     * @param mixed $em
     * @return XpProType
     */
    private function setEm(EntityManager $em): self {
        $this->em = $em;

        return $this;
    }



    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('title', TextType::class)
                ->add('contractType', ChoiceType::class, [
                    'choices'       => $this->requestChoices(),
                    'placeholder'   => 'Choisir un type de contrat',
                    'required'      => true
                ])
                ->add('anchor', TextType::class)
                ->add('explanation', TextareaType::class)
                ->add('picture', FileType::class, array('required' => false))
                ->add('oldPicture', HiddenType::class)
                ->add('annuler', ResetType::class)
                ->add('ajouter', SubmitType::class);
        
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => XpProForm::class));
    }

    private function requestChoices(): array
    {

        foreach ($this->getEm()->getRepository(ContractType::class)->findAll() as $contractType) {
            $contractTypeAll[$contractType->getShortName()] = $contractType->getIdContractType();
        }

        return $contractTypeAll;
    }
}