<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 * @author libertalia
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact {
    
    /**
     * @var integer contact id
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_contact;
    
    /**
     * @var string email
     * 
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;
    
    /**
     * @var string subject
     * 
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;
    
    
    /**
     * @var string message
     * 
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;

    /**
     * @ORM\Column(name="datetime", type="datetime", nullable=false)
     */
    private $datetime;

    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    protected function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
    
    public function __construct() {
        $this->datetime = new \DateTime();
    }
}