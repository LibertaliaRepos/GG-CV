<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository implements FetchTitles
{

    /** @var Serializer $serializer */
    private $serializer;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Skill::class);

        $this->setSerializer(new Serializer([new ObjectNormalizer()],[new JsonEncoder()]));
    }

    /**
     * @return Serializer
     */
    public function getSerializer() {
        return $this->serializer;
    }

    /**
     * @param Serializer $serializer
     */
    private function setSerializer(Serializer $serializer): void {
        $this->serializer = $serializer;
    }

    /**
     * @return string|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAllTitles(): ?string {

        $conn = $this->getEntityManager()->getConnection();
        $query = 'SELECT title FROM skill';
        $stmt = $conn->query($query);

        $titles = [];

        foreach ($stmt->fetchAll() as $key => $value) {
            $titles['titles-' . $key] = $value['title'];
        }

        return $this->getSerializer()->serialize($titles, self::JSON_SERIALIZATION);
    }
}
