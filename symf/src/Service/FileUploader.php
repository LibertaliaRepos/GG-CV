<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\Debug\DebugAjax;

class FileUploader {
    
    private $targetDirectory;
    private $debug;
    
    public function __construct(string $targetDirectory, DebugAjax $debug) {
        $this->targetDirectory = $targetDirectory;
        $this->debug = $debug;
    }
    
    public function upload(UploadedFile $uploadedFile) : string {
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        
        
        try {
            $uploadedFile->move($this->targetDirectory, $filename);
        } catch (FileException $e) {
            throw new FileException($e->getMessage());
        }
        
        return $filename;
    }
    
    public function getTargetDirectory() : string {
        return $this->targetDirectory;
    }
}