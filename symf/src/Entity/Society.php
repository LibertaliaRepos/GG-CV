<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Society
 * @author libertalia
 *
 * @ORM\Table(name="Society")
 * @ORM\Entity(repositoryClass="App\Repository\SocietyRepository")
 */
class Society {
    
    /**
     * @var integer society id
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_society;
    
    /**
     * @var sting society name
     * 
     * @ORM\Column(name="society_name", type="string", length=255, nullable=false)
     */
    private $societyName;
    
    /**
     * @var Contact
     * 
     *  @ORM\OneToOne(targetEntity="App\Entity\Contact", cascade={"persist", "remove"})
     *  @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    public function getIdSociety(): ?int
    {
        return $this->id_society;
    }

    public function getSocietyName(): ?string
    {
        return $this->societyName;
    }

    public function setSocietyName(string $societyName): self
    {
        $this->societyName = $societyName;

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