<?php

namespace App\Repository;

use App\Entity\XpPro_Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method XpPro_Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method XpPro_Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method XpPro_Image[]    findAll()
 * @method XpPro_Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XpPro_ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, XpPro_Image::class);
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
    public function getMaxOrder() {
        $conn = $this->getEntityManager()->getConnection();
        $query = 'SELECT MAX(sorting) FROM xppro_image';
        $stmt = $conn->query($query);

        return intval($stmt->fetch()['MAX(sorting)']);
    }
}
