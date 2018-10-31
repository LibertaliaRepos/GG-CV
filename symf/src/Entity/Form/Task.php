<?php
namespace App\Entity\Form;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task
 * @author libertalia
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task {
    
    /**
     * @var integer task
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $id;
    
    /**
     * @var string task
     * 
     * @ORM\Column(name="task", type="string", length=255, nullable=false)
     * 
     * @Assert\NotBlank()
     */
    protected $task;
    
    /**
     * @var \DateTime due date
     * 
     * @ORM\Column(name="dueDate", type="datetime", nullable=true)
     * 
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    protected $dueDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate = null): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }
    
}