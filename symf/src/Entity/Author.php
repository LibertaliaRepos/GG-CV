<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 * @author libertalia
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author {
    
    /**
     * @var int id_auhtor.
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_author;
    
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @var string name.
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    public function getIdAuthor(): ?int
    {
        return $this->id_author;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}