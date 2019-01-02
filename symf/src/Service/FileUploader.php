<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\Debug\DebugAjax;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader {
    
    public const ALLOWED_IMG_EXT = ['jpg', 'jpeg', 'png', 'gif'];
    public const ALLOWED_IMG_MIME = ['image/jpeg', 'image/png', 'image/gif'];
    public const ALLOWED_FILE_EXT = ['pdf'];
    public const ALLOWED_FILE_MIME = ['application/pdf'];
    
    private $debug;
    
    /**
     * 
     * @param DebugAjax $debug
     */
    public function __construct(DebugAjax $debug) {
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
    public function upload(string $targetDirectory, UploadedFile $uploadedFile) : File {
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        
        
        try {
            $file = $uploadedFile->move($targetDirectory, $filename);
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