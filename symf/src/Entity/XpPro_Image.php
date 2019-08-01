<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XpPro_Image
 * @author libertalia
 *
 * @ORM\Table(name="xppro_image")
 * @ORM\Entity(repositoryClass="App\Repository\XpPro_ImageRepository")
 */
class XpPro_Image {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var XpPro
     * 
     * @ORM\OneToOne(targetEntity="App\Entity\XpPro", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $xpPro;
    
    /**
     * @var App\Entity\Image
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sorting", type="integer", nullable=false)
     */
    private $order;

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

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getXpPro(): ?XpPro
    {
        return $this->xpPro;
    }

    public function setXpPro(XpPro $xpPro): self
    {
        $this->xpPro = $xpPro;

        return $this;
    }
}