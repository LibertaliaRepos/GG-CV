<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class ContractTypesFixture extends Fixture
{
    public function load(ObjectManager $manager) {

        $contract1 = new ContractType();
        $contract1->setShortName('CDD');
        $contract1->setLongName('Contrat à Durée Déterminé');
        $contract1->setSvgHref('cdd.svg');
        $contract1->setPngHref('cdd.png');

        $contract2 = new ContractType();
        $contract2->setShortName('CDI');
        $contract2->setLongName('Contrat à Durée Indéterminé');
        $contract2->setSvgHref('cdi.svg');
        $contract2->setPngHref('cdd.png');

        $manager->persist($contract1);
        $manager->persist($contract2);
        
        $manager->flush();
    }
    
    
    
}
