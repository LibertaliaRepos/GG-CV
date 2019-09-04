<?php

namespace App\Repository;

use App\Entity\Svg\SvgJson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SvgJson|null find($id, $lockMode = null, $lockVersion = null)
 * @method SvgJson|null findOneBy(array $criteria, array $orderBy = null)
 * @method SvgJson[]    findAll()
 * @method SvgJson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SvgJsonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SvgJson::class);
    }

    // /**
    //  * @return SvgJson[] Returns an array of SvgJson objects
    //  */
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
    public function findOneBySomeField($value): ?SvgJson
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
