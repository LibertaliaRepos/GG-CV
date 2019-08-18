<?php
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DeviceDetector\DeviceDetector;

class DetectIE extends AbstractController {

    /** @var string  */
    public const IE_CLIENT = 'Internet Explorer';
    /** @var string  */
    public const SARAFI_CLIENT = 'Safari';

    /** @var DeviceDetector $browserDetector */
    private $browserDetector;

    /**
     * DetectIE constructor.
     */
    public function __construct() {
        $this->browserDetector = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @return void
     */
    public function isIE() : void {
        $this->browserDetector->parse();
        
        $this->get('twig')->addGlobal('IE', ($this->browserDetector->getClient('name') == self::IE_CLIENT));
    }
}