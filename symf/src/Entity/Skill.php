<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
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
}
