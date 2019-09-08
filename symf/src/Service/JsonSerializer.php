<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 04/09/19
 * Time: 19:12
 */

namespace App\Service;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonSerializer
{
    private const JSON_SERIALIZATION = 'json';

    /** @var Serializer */
    private $serializer;

    public function __construct() {
        $this->setSerializer(new Serializer([new ObjectNormalizer()], [new JsonEncoder()]));
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
     * @param array $data
     * @return string
     */
    public function serialize(array $data): string {
        return $this->getSerializer()->serialize($data, self::JSON_SERIALIZATION);
    }

    /**
     * @param string $json
     * @return array
     */
    public function deserialize(string $json): array {
        return json_decode($json, true);
    }
}