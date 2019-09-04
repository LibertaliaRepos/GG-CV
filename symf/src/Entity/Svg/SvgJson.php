<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 03/09/19
 * Time: 17:30
 */

namespace App\Entity\Svg;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SvgJson
 * @package App\Entity\Svg
 *
 * @ORM\Table(name="svg_json")
 * @ORM\Entity(repositoryClass="App\Repository\SvgJsonRepository")
 */
class SvgJson {

    public const SKILL_TABLE_ID = 1;
    public const PROJECT_TABLE_ID = 2;
    public const XPPRO_TABLE_ID = 3;

    public const ALLOWED_TABLE_ID = [self::SKILL_TABLE_ID, self::PROJECT_TABLE_ID, self::XPPRO_TABLE_ID];

    /**
     * @var int $id_svg_json
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id_svg_json", type="integer", nullable=false)
     */
    private $id_svg_json;

    /**
     * @var string|array $json
     *
     * @ORM\Column(name="json", type="json")
     */
    private $json;

    /**
     * @return int|null
     */
    public function getIdSvgJson(): ?int
    {
        return $this->id_svg_json;
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
     * @return SvgJson
     */
    public function setJson(array $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function setJsonStr(string $json): self {
        $this->json = $json;

        return $this;
    }
}