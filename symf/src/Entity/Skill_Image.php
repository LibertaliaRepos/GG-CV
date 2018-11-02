<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill_Image
 * @author libertalia
 *
 * @ORM\Table(name="skill_image")
 * @ORM\Entity(repositoryClass="App\Repository\Skill_ImageRepository")
 */
class Skill_Image {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var App\Entity\Skill
     * 
     * @ORM\OneToOne(targetEntity="App\Entity\Skill", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;
    
    /**
     * @var App\Entity\Image
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}