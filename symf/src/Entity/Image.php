<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Image
 * @author libertalia
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image {
    
    const ALLOWED_MIME_TYPE = array('image/png', 'image/jpeg', 'image/svg+xml');
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project")
     */
    private $project;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }
    
    public function getProject(): ?Project
    {
        return $this->project;
    }
    
    public function setProject(?Project $project): self
    {
        $this->project = $project;
        
        return $this;
    }
    
    public function getFile($folder) {
        return new File($folder .'/'. $this->filename, true);
    }
    
    public function unlink($folder) {
        $filename = $folder .'/'. $this->filename;
        
        return unlink($filename);
    }
}