<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\Debug\DebugAjax;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader {
    
    private $targetDirectory;
    private $debug;
    
    /**
     * 
     * @param string $targetDirectory
     * @param DebugAjax $debug
     */
    public function __construct(string $targetDirectory, DebugAjax $debug) {
        $this->targetDirectory = $targetDirectory;
        $this->debug = $debug;
    }
    
    /**
     * 
     * @return string
     */
    public function getTargetDirectory() : string {
        return $this->targetDirectory;
    }
    
    /**
     * 
     * @param UploadedFile $uploadedFile
     * @throws FileException
     * @return File
     */
    public function upload(UploadedFile $uploadedFile) : File {
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        
        
        try {
            $file = $uploadedFile->move($this->targetDirectory, $filename);
        } catch (FileException $e) {
            throw new FileException($e->getMessage());
        }
        
        return $file;
    }
    
    public function guessFileNameNoExt(File $file) : string {
        $regex = '#(\w+)\.#';
        $filename = $file->getFilename();
        $matches = [];
        
        preg_match($regex, $filename, $matches);
        
        return array_pop($matches);
    }
}