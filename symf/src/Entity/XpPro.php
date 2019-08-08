<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Skill
 *
 * @ORM\Table(name="xppro")
 * @ORM\Entity(repositoryClass="App\Repository\XpProRepository")
 */
class XpPro
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 4,
     * max = 255,
     * minMessage = "Le titre doit faire au moins {{ limit }} caractères.",
     * maxMessage = "Le titre doit faire moins de {{ limit }} caractères."
     * )
     */
    private $title;

    /**
     * @var ContractType;
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ContractType", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contractType;

    /**
     * @var string
     *
     * @ORM\Column(name="anchor", type="string", length=255, nullable=false, unique=true)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 4,
     * max = 255,
     * minMessage = "L'ancre doit faire au moins {{ limit }} caractères.",
     * maxMessage = "L'ancre doit faire moins de {{ limit }} caractères."
     * )
     * @Assert\Regex(
     *  pattern="/[\s\.#]/",
     *  match=false,
     *  message="L'ancre ne doit pas contenir d'espace [ ], de point [.] et de dièze [#]"
     * )
     */
    private $anchor;

    /**
     * @var string
     *
     * @ORM\Column(name="explanation", type="text", length=0, nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 20,
     * minMessage = "La description doit faire au moins {{ limit }} caractères."
     * )
     */
    private $explanation;
    
    public function __construct() {
        $this->anchor = '';
        $this->title = '';
        $this->explanation='';
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAnchor(): ?string
    {
        return $this->anchor;
    }

    public function setAnchor(string $anchor): self
    {
        $this->anchor = $anchor;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * @return ContractType
     */
    public function getContractType(): ContractType
    {
        return $this->contractType;
    }

    /**
     * @param ContractType $contractType
     * @return XpPro
     */
    public function setContractType(ContractType $contractType): XpPro
    {
        $this->contractType = $contractType;
        return $this;
    }
}
