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

        $cdd = new ContractType();
        $cdd->setShortName('CDD');
        $cdd->setLongName('Contrat à Durée Déterminé');
        $cdd->setSvgHref('cdd.svg');
        $cdd->setPngHref('cdd.png');

        $cdi = new ContractType();
        $cdi->setShortName('CDI');
        $cdi->setLongName('Contrat à Durée Indéterminé');
        $cdi->setSvgHref('cdi.svg');
        $cdi->setPngHref('cdd.png');

        $stage = new ContractType();
        $stage->setShortName('Stage');
        $stage->setLongName('Stage');
        $stage->setSvgHref('stage.svg');
        $stage->setPngHref('stage.png');

        $manager->persist($cdd);
        $manager->persist($cdi);
        $manager->persist($stage);

        $manager->flush();
    }
    
    
    
}
