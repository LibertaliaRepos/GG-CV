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
    
    const PNG_MIME = 'image/png';
    const JPEG_MIME = 'image/jpeg';
    const SVG_MIME = 'image/svg+xml';
    const ALLOWED_MIME_TYPE = array(self::PNG_MIME, self::JPEG_MIME, self::SVG_MIME);
    
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
    
    static function imageInfo($path) {
        
        $uri = explode('/', $path);
        $filename = array_pop($uri);
        $folder = implode('/', $uri);
        $file = new File("$folder/$filename");
        
        return array(
            'filename' => $filename,
            'folder'   => $folder,
            'path' => "$folder/$filename",
            'File'     => $file
        );
    }
    
    static function convertSVG(string $path) {
        
        $imageInfo = self::imageInfo($path);
        
        if($imageInfo['File']->getMimeType() == self::SVG_MIME) {
            $pngFilename = preg_replace('#(.*)\.\D+#', '$1.png', $imageInfo['filename']);
            
            $origin = new \Imagick($path);
            $origin->setformat('png');
            $origin->writeimage($imageInfo['folder'].'/converted/'.$pngFilename);
        }
    }
    
    static function deleteSVGRelatedFile(string $path) {
        $imageInfo = self::imageInfo($path);
        
        if($imageInfo['File']->getMimeType() == self::SVG_MIME) {
            $pngFilename = preg_replace('#(.*)\.\D+#', '$1.png', $imageInfo['filename']);
            
            unlink($imageInfo['folder'].'/converted/'.$pngFilename);
        }
    }

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