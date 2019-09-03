<?php

namespace App\Repository;

use App\Entity\Csv\CsvJson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CsvJson|null find($id, $lockMode = null, $lockVersion = null)
 * @method CsvJson|null findOneBy(array $criteria, array $orderBy = null)
 * @method CsvJson[]    findAll()
 * @method CsvJson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CsvJsonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CsvJson::class);
    }

    // /**
    //  * @return CsvJson[] Returns an array of CsvJson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CsvJson
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
