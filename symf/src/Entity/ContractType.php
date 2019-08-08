<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 04/08/19
 * Time: 16:13
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class contractType
 * @package App\Entity
 *
 * @ORM\Table(name="contractType")
 * @ORM\Entity(repositoryClass="App\Repository\contractTypeRepository")
 */
class ContractType {

    /**
     * @var int $id_contractType
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_contractType;

    /**
     * @var string
     * @ORM\Column(name="short_name", type="string", length=255, nullable=false)
     */
    private $shortName;

    /**
     * @var string
     * @ORM\Column(name="long_name", type="string", length=255, nullable=true)
     */
    private $longName;

    /**
     * @var string
     *
     * @ORM\Column(name="svg_href", type="string", length=255, nullable=false)
     */
    private $svgHref;

    /**
     * @var string
     *
     * @ORM\Column(name="png_href", type="string", length=255, nullable=false)
     */
    private $pngHref;

    /**
     * @return int
     */
    public function getIdContractType(): int
    {
        return $this->id_contractType;
    }

    /**
     * @param int $id_contractType
     * @return ContractType
     */
    public function setIdContractType(int $id_contractType): ContractType
    {
        $this->id_contractType = $id_contractType;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return ContractType
     */
    public function setShortName(string $shortName): ContractType
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongName(): string
    {
        return $this->longName;
    }

    /**
     * @param string $longName
     * @return ContractType
     */
    public function setLongName(string $longName): ContractType
    {
        $this->longName = $longName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSvgHref(): string
    {
        return $this->svgHref;
    }

    /**
     * @param string $svgHref
     * @return ContractType
     */
    public function setSvgHref(string $svgHref): ContractType
    {
        $this->svgHref = $svgHref;
        return $this;
    }

    /**
     * @return string
     */
    public function getPngHref(): string
    {
        return $this->pngHref;
    }

    /**
     * @param string $pngHref
     * @return ContractType
     */
    public function setPngHref(string $pngHref): ContractType
    {
        $this->pngHref = $pngHref;
        return $this;
    }
}