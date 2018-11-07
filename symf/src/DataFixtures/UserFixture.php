<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager) {
        
        $user = new User();
        
        $roles = $user->getRoles();
        $roles[] = 'ROLE_ADMIN';
        
        $user->setRoles($roles);
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '1491Js93@655957'));
        
        $user2 = new User();
        $user2->setUsername('libertalia');
        $user2->setRoles($user2->getRoles());
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, '987654321'));

        $manager->persist($user);
        $manager->persist($user2);
        
        $manager->flush();
    }
    
    
    
}
