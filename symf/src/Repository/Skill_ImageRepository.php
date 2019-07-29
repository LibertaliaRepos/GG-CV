<?php

namespace App\Repository;

use App\Entity\Skill_Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Skill_Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill_Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill_Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Skill_ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Skill_Image::class);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Doctrine\ORM\EntityRepository::findAll()
     */
    public function findAll() {
        return $this->findBy([], ['order' => 'ASC']);
    }
    
    /**
     * 
     */
    public function findAllSkills() {
        $skillImages = $this->findAll();
        $skills = [];
        
        foreach ($skillImages as $skillImage) {
            array_push($skills, $skillImage->getSkill());
        }
        
        return $skills;
    }
    
    /**
     * 
     */
    public function getMaxOrder() {
        $conn = $this->getEntityManager()->getConnection();
        $query = 'SELECT MAX(sorting) FROM skill_image';
        $stmt = $conn->query($query);

        return intval($stmt->fetch()['MAX(sorting)']);
    }
}
