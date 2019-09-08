<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 06/09/19
 * Time: 12:07
 */

namespace App\Entity\Svg;

class Polygon {

    /** @var array $points */
    private $points;

    public function __construct() {
        $this->setPoints([]);
    }

    /**
     * @return array
     */
    public function getPoints(): array {
        return $this->points;
    }

    /**
     * @param array $points
     * @return Polygon
     */
    private function setPoints(array $points): self {
        $this->points = $points;
        return $this;
    }

    public function addPoint(Point $point): self {
        $points = $this->getPoints();
        array_push($points, $point);
        $this->setPoints($points);

        return $this;
    }

    public function removePoint(Point $point): self {
        $index = null;
        $points = $this->getPoints();

        foreach ($points as $key => $value) {
            /** @var $value Point */
            if($point->getId() === $value->getId()) {
                $index = $key;
            }
        }

        if (empty($index)) {
            trigger_error('Le point d\'id ' . $point->getId() . 'n\'existe pas dans ce polygone', E_NOTICE);
        } else {
            unset($points[$index]);
            $this->setPoints($points);
        }

        return $this;
    }

    public function __toString(): string {
        $toStr = '';

        foreach ($this->getPoints() as $point) {
            /** @var $point Point */
            $toStr .= "{$point->getX()},{$point->getY()} ";
        };

        return $toStr;
    }
}