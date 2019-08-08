<?php

namespace App\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * XpPro
 */
class XpProForm
{

    /**
     * @var string
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
     *
     */
    private $contractType;

    /**
     * @var string
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
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 20,
     * minMessage = "La description doit faire au moins {{ limit }} caractères."
     * )
     */
    private $explanation;
    
    /**
     * @var string
     * 
     * @Assert\File(
     * mimeTypes={ "image/png", "image/jpeg", "image/svg+xml" },
     * mimeTypesMessage = "Seule les extensions {{ types }} sont autorisées"
     * )
     */
    private $picture;
    
    /**
     * @var string
     *
     */
    private $oldPicture;

    public function __construct() {
        $this->anchor = '';
        $this->title = '';
        $this->explanation = '';
        $this->oldPicture = '';
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

    /**
     * @return mixed
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * @param mixed $contractType
     */
    public function setContractType($contractType): void
    {
        $this->contractType = $contractType;
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture = null)
    {
        $this->picture = $picture;

        return $this;
    }
    
    
    /**
     * @return the $oldPicture
     */
    public function getOldPicture()
    {
        return $this->oldPicture;
    }

    /**
     * @param string $oldPicture
     */
    public function setOldPicture($oldPicture)
    {
        $this->oldPicture = $oldPicture;
    }
}
