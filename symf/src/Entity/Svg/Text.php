<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 06/09/19
 * Time: 15:16
 */

namespace App\Entity\Svg;

use App\Entity\Svg\Point;

class Text {
    /** @var string $text */
    private $text;
    /** @var int $x */
    private $x;
    /** @var int $y */
    private $y;

    /**
     * Text constructor.
     * @param string $text
     * @param int $x
     * @param int $y
     */
    public function __construct(string $text = '', int $x = 0, int $y = 0) {
        $this->setText($text)
            ->setX($x)
            ->setY($y);
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Text
     */
    public function setText(string $text): Text {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getX(): int {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Text
     */
    public function setX(int $x): Text {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Text
     */
    public function setY(int $y): Text {
        $this->y = $y;
        return $this;
    }

    public function setCoordByPoint(Point $point): self {
        $this->setX($point->getX())
            ->setY($point->getY());
    }
}