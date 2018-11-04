<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Project
 *
 * @ORM\Table(name="project", uniqueConstraints={@ORM\UniqueConstraint(name="project_anchor_IDX", columns={"anchor"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="explanation", type="text", nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 20,
     * minMessage = "La description doit faire au moins {{ limit }} caractères."
     * )
     */
    private $explanation;

//     /**
//      * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="project")
//      */
//     private $images;

    public function __construct() {
        $this->anchor = '';
        $this->explanation = '';
        $this->title = '';
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
    
    public function getImages(ObjectRepository $repository) {
        return $repository->findBy(['project' => $this]);
    }

//     /**
//      * @return Collection|Image[]
//      */
//     public function getImages(): Collection
//     {
//         return $this->images;
//     }

//     public function addImage(Image $image): self
//     {
//         if (!$this->images->contains($image)) {
//             $this->images[] = $image;
//             $image->setProject($this);
//         }

//         return $this;
//     }

//     public function removeImage(Image $image): self
//     {
//         if ($this->images->contains($image)) {
//             $this->images->removeElement($image);
//             // set the owning side to null (unless already changed)
//             if ($image->getProject() === $this) {
//                 $image->setProject(null);
//             }
//         }

//         return $this;
//     }

}
