<?php

namespace App\Repository;

use App\Entity\Skill;
use App\Service\JsonSerializer;
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

    /** @var JsonSerializer $serializer */
    private $serializer;

    /**
     * SkillRepository constructor.
     * @param RegistryInterface $registry
     * @param JsonSerializer $serializer
     */
    public function __construct(RegistryInterface $registry, JsonSerializer $serializer)
    {
        parent::__construct($registry, Skill::class);

        $this->setSerializer($serializer);
    }

    /**
     * @return JsonSerializer
     */
    public function getSerializer() {
        return $this->serializer;
    }

    /**
     * @param JsonSerializer $serializer
     */
    private function setSerializer(JsonSerializer $serializer): void {
        $this->serializer = $serializer;
    }

    /**
     * @return string|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAllTitles(): ?string {

        $conn = $this->getEntityManager()->getConnection();
        $query = 'SELECT title, anchor FROM skill';
        $stmt = $conn->query($query);

        $titles = [];

        foreach ($stmt->fetchAll() as $key => $value) {
            $index = 'titles-' . $key;
            $titles[$index] = $value;
        }

        return $this->getSerializer()->serialize($titles);
    }
}
