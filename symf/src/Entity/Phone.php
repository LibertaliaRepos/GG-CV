<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 * @author libertalia
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 */
class Phone {
    
    /**
     * @var integer id_phone
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_phone;
    
    /**
     * @var integer phone number
     * 
     * @ORM\Column(name="number", type="string", length=255, nullable=false)
     */
    private $phoneNumber;
    
    /**
     * @var Contact
     * 
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    public function getIdPhone(): ?int
    {
        return $this->id_phone;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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