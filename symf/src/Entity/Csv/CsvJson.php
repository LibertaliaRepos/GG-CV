<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 03/09/19
 * Time: 17:30
 */

namespace App\Entity\Csv;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CsvJson
 * @package App\Entity\Csv
 *
 * @ORM\Table(name="csv_json")
 * @ORM\Entity(repositoryClass="App\Repository\CsvJsonRepository")
 */
class CsvJson {

    /**
     * @var int $id_csv_json
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id_csv_json", type="integer", nullable=false)
     */
    private $id_csv_json;

    /**
     * @var string $json
     *
     * @ORM\Column(name="json", type="json")
     */
    private $json;

    /**
     * @return int|null
     */
    public function getIdCsvJson(): ?int
    {
        return $this->id_csv_json;
    }

    /**
     * @return array|null
     */
    public function getJson(): ?array
    {
        return $this->json;
    }

    /**
     * @param array $json
     * @return CsvJson
     */
    public function setJson(array $json): self
    {
        $this->json = $json;

        return $this;
    }
}