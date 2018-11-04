<?php
namespace App\Entity\Form;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class ProjectForm {
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
     * @var File[]
     * 
     */
    private $images;

//     /**
//      * @var ArrayCollection
//      *
//      * @Assert\Collection(
//      *  flieds = {
//      *      "image" = @Assert\File
//      *  }
//      * )
//      */
//     private $images;
    
    public function __construct() {
        $this->title = '';
        $this->anchor = '';
        $this->explanation = '';
        $this->images = new ArrayCollection();
    }
    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return the $anchor
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @return the $explanation
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * @return the $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $anchor
     */
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
    }

    /**
     * @param string $explanation
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $images
     */
    public function setImages($images)
    {
        $this->images[] = $images;
    }

    
    

    
    
}