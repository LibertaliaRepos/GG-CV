<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 17/08/19
 * Time: 15:32
 */

namespace App\Service;


use Twig\Environment;

class DetectDevice
{
    /** @var \Mobile_Detect */
    private $mobileDetect;
    /** @var Environment */
    private $twigEnv;

    public function __construct(Environment $twigEnv) {
        $this->setMobileDetect(new \Mobile_Detect());
        $this->setTwigEnv($twigEnv);
    }

    /**
     * @return \Mobile_Detect
     */
    public function getMobileDetect(): \Mobile_Detect {
        return $this->mobileDetect;
    }

    /**
     * @param \Mobile_Detect $mobileDetect
     */
    private function setMobileDetect(\Mobile_Detect $mobileDetect): void {
        $this->mobileDetect = $mobileDetect;
    }

    /**
     * @return Environment
     */
    public function getTwigEnv(): Environment {
        return $this->twigEnv;
    }

    /**
     * @param Environment $twigEnv
     */
    public function setTwigEnv(Environment $twigEnv): void {
        $this->twigEnv = $twigEnv;
    }

    /**
     *
     */
    public function isDesktop(): void {
        $this->getTwigEnv()->addGlobal('desktop', !($this->getMobileDetect()->isMobile() || $this->getMobileDetect()->isTablet()));
    }
}