<?php

namespace App\Repository;

use App\Entity\Skill_Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Skill_Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill_Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill_Image[]    findAll()
 * @method Skill_Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Skill_ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Skill_Image::class);
    }

//    /**
//     * @return Skill_Image[] Returns an array of Skill_Image objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Skill_Image
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function getMaxOrder() {
        $conn = $this->getEntityManager()->getConnection();
        $query = 'SELECT MAX(sorting) FROM skill_image';
        $stmt = $conn->query($query);

        return intval($stmt->fetch()['MAX(sorting)']);
    }
}
