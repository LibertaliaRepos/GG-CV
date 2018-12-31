<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader {
    
    private $targetDirectory;
    
    public function __construct(string $targetDirectory) {
        $this->targetDirectory = $targetDirectory;
    }
    
    public function upload(UploadedFile $uploadedFile) : string {
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        
        try {
            $uploadedFile->move($this->targetDirectory .'/'. $filename);
        } catch (FileException $e) {
            throw new FileException($e->getMessage());
        }
        
        return $filename;
    }
    
    public function getTargetDirectory() : string {
        return $this->targetDirectory;
    }
}