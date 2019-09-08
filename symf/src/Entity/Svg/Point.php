<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 06/09/19
 * Time: 12:02
 */

namespace App\Entity\Svg;


class Point
{
    private const ID_PREFIX = 'point-';

    /** @var string */
    private $id;
    /** @var int $x */
    private $x;
    /** @var int $y */
    private $y;

    /**
     * Point constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y) {
        $this->setId(uniqid(self::ID_PREFIX));
        $this->setX($x);
        $this->setY($y);
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Point
     */
    private function setId(string $id): Point {
        $this->id = $id;
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
     * @return Point
     */
    public function setX(int $x): Point {
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
     * @return Point
     */
    public function setY(int $y): Point {
        $this->y = $y;
        return $this;
    }

    public function __toString(): string {
        return "{$this->getX()},{$this->getY()}";
    }
}