<?php

namespace App\Repository;

use App\Entity\XpPro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method XpPro|null find($id, $lockMode = null, $lockVersion = null)
 * @method XpPro|null findOneBy(array $criteria, array $orderBy = null)
 * @method XpPro[]    findAll()
 * @method XpPro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XpProRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, XpPro::class);
    }

    // /**
    //  * @return XpPro[] Returns an array of XpPro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?XpPro
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
