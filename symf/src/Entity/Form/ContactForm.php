<?php
namespace App\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactForm
 * @author libertalia
 */
class ContactForm {
    
    //==>> Contact class
    
    /**
     * @var string email
     * 
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Email(
     *      message = "L'adresse de messagerie : {{ value }} est invalide",
     *      mode = "html5"
     * )
     */
    protected $email;
    
    /**
     * @var string subject
     * 
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(
     *      min="10",
     *      max="255",
     *      minMessage = "Le sujet de votre message doit contenir au moins {{ limit }} caractères"
     * )
     */
    protected $subject;
    
    //==>> Author class
    
    /**
     * @var string author
     *
     * @Assert\Type("string")
     * @Assert\Length(
     *      min="2",
     *      max="255",
     *      minMessage = "Votre nom doit contenir au moins {{ limit }} caractères"
     * )
     */
    protected $author;
    
    //==>> Phone class
    
    /**
     * @var string phone
     *
     * @Assert\Type("string")
     * @Assert\Length(
     *      min="10",
     *      max="255",
     *      minMessage = "Votre numéro de téléphone doit contenir au moins {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *      pattern="/\D+/",
     *      match=true,
     *      message="Votre numéro de téléphone ne doit pas contenir de lettre"
     * )
     */
    protected $phone;
    
    //==>> Society class
    
    /**
     * @var string society
     *
     * @Assert\Type("string")
     * @Assert\Length(
     *      min="2",
     *      max="255",
     *      minMessage = "Votre nom doit contenir au moins {{ limit }} caractères"
     * )
     */
    protected $society;
    
    
    public function __construct() {
        $this->author = '';
        $this->email = '';
        $this->phone = '';
        $this->society = '';
        $this->subject = '';
    }
    
    /**
     * @return the $email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return the $subject
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return the $author
     */
    public function getAuthor():string
    {
        return $this->author;
    }

    /**
     * @return the $phone
     */
    public function getPhone():string
    {
        return $this->phone;
    }

    /**
     * @return the $society
     */
    public function getSociety():string
    {
        return $this->society;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author = null)
    {
        $this->author = $author;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $society
     */
    public function setSociety($society = null)
    {
        $this->society = $society;
    }

}