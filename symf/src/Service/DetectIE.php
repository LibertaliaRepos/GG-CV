<?php
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DeviceDetector\DeviceDetector;

class DetectIE extends AbstractController {
    
    public const IE_CLIENT = 'Internet Explorer';
    public const SARAFI_CLIENT = 'Safari';
    
    private $browserDetector;
    
    public function __construct() {
        $this->browserDetector = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
    }
    
    public function isIE() {
        $this->browserDetector->parse();
        
        $this->get('twig')->addGlobal('IE', ($this->browserDetector->getClient('name') == self::IE_CLIENT));
    }
    
}