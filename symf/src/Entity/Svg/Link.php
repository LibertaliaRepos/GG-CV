<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 06/09/19
 * Time: 15:51
 */

namespace App\Entity\Svg;


class Link
{
    /** @var Polygon $polygon */
    private $polygon;
    /** @var Text $text */
    private $text;
    /** @var string $href */
    private $href;

    public function __construct(Polygon $polygon, Text $text, string $href = '') {
        $this->setPolygon($polygon);
        $this->setText($text);
        $this->setHref($href);
    }

    /**
     * @return Polygon
     */
    public function getPolygon(): Polygon {
        return $this->polygon;
    }

    /**
     * @param Polygon $polygon
     */
    public function setPolygon(Polygon $polygon): void {
        $this->polygon = $polygon;
    }

    /**
     * @return Text
     */
    public function getText(): Text {
        return $this->text;
    }

    /**
     * @param Text $text
     */
    public function setText(Text $text): void {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getHref(): string {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref(string $href): void {
        $this->href = $href;
    }


}