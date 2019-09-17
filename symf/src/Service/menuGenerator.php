<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 29/08/19
 * Time: 19:58
 */

namespace App\Service;

use App\Entity\Svg\Link;
use App\Entity\Svg\Point;
use App\Entity\Svg\Polygon;
use App\Entity\Svg\Text;

class menuGenerator
{
    public const FONT_LETTER_PIXEL_UNIT = 11;

    public const MENU_HEIGHT = 25;

    public const GLOBAL_STROKE_WIDTH = 2;

    public const FIRST_POLYGON_WIDTH = 10;

    public const TEXT_Y = 21;

    public const POLYGON_LESS = 5;

    public const TITLE_LENGTH_STEPS = [1 => 60, 2 => 125, 3 => 170, 4 => 225, 5 => 300];

    public const TITLE_LENGTH_QUOTIEN = 5;

    /** @var \Twig_Environment $twig */
    private $twig;
    /** @var array $options */
    private $options;
    /** @var Polygon $firstPolygon */
    private $firstPolygon;
    /** @var array $firstPolygonPoints */
    private $firstPolygonPoints;

    /**
     * menuGenerator constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig) {
        $this->setTwig($twig);
        $this->setFirstPolygon($this->buildFirstPolygon());
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig(): \Twig_Environment {
        return $this->twig;
    }

    /**
     * @param \Twig_Environment $twig
     */
    private function setTwig(\Twig_Environment $twig): void {
        $this->twig = $twig;
    }

    /**
     * @return array
     */
    public function getOptions(): array {
        return $this->options;
    }

    /**
     * @param array $options
     * @return menuGenerator
     */
    public function setOptions(array $options): self {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Polygon
     */
    public function getFirstPolygon(): Polygon {
        return $this->firstPolygon;
    }

    /**
     * @return array
     */
    public function getFirstPolygonPoints(): array {
        return $this->firstPolygonPoints;
    }

    /**
     * @param array $firstPolygonPoints
     */
    private function setFirstPolygonPoints(array $firstPolygonPoints): void {
        $this->firstPolygonPoints = $firstPolygonPoints;
    }

    /**
     * @param Polygon $firstPolygon
     */
    private function setFirstPolygon(Polygon $firstPolygon): void {
        $this->firstPolygon = $firstPolygon;
    }

    /**
     * @param array $titles
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function buildTitleSvg(array $titles): string {
        $this->setOptions($titles);
        $this->buildLinks();

        return $this->render();
    }

    /**
     * @param string $id
     * @return Point
     */
    private function getFirstPointsById(string $id): Point {
        return $this->getFirstPolygonPoints()[$id];
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function render(): string {
        return $this->getTwig()->render('SVG/titlesMenu.html.twig', ['first' => (string) $this->getFirstPolygon(),'links' => $this->getOptions()]);
    }

    /**
     * @return Polygon
     */
    private function buildFirstPolygon() {
        $this->setFirstPolygonPoints([
            'a' => new Point(0, self::GLOBAL_STROKE_WIDTH),
            'b' => new Point(self::FIRST_POLYGON_WIDTH, self::GLOBAL_STROKE_WIDTH),
            'c' => new Point(self::FIRST_POLYGON_WIDTH, self::MENU_HEIGHT),
            'd' => new Point(0, self::MENU_HEIGHT)
        ]);

        $polygon = new Polygon();
        return $polygon->addPoint($this->getFirstPointsById('a'))
            ->addPoint($this->getFirstPointsById('b'))
            ->addPoint($this->getFirstPointsById('c'))
            ->addPoint($this->getFirstPointsById('d'));
    }

    /**
     *
     */
    private function buildLinks(): void {
        $a = $b = $c = $d = null;

        $opts = $this->getOptions();

        for ($i = 0; $i < count($opts); ++$i) {

            $index = 'titles-' . $i;
            $strlen = $this->titleWidth($this->getOptions()[$index]['title']);

            $polygon = new Polygon();

            if ($i == 0) {
                $a = $this->getFirstPointsById('a');
                $d = $this->getFirstPointsById('d');
            } else {
                $a = $b;
                $d = $c;
            }

            $b = new Point($a->getX() + $strlen, self::GLOBAL_STROKE_WIDTH);
            $c = new Point($b->getX() - self::POLYGON_LESS, self::MENU_HEIGHT);

            $polygon->addPoint($a)
            ->addPoint($b)
            ->addPoint($c)
            ->addPoint($d);

            $polygon->setWidth($b->getX() - $d->getX());

//            $textX = $a->getX() + self::FIRST_POLYGON_WIDTH;
//
            $textX = (($c->getX() - $a->getX()) / 2) + $a->getX();

            $text = new Text($this->getOptions()[$index]['title'], $textX, self::TEXT_Y);

            $link = new Link($polygon, $text, $this->getOptions()[$index]['anchor']);

            $opts[$index] = $link;
        }

        $this->setOptions($opts);
    }

    private function titleWidth(string $title): int {
        return self::TITLE_LENGTH_STEPS[ceil(strlen($title) / self::TITLE_LENGTH_QUOTIEN)];
    }

    private function debugTemplate($str) {
        file_put_contents('/var/www/zend-workspace/GG-CV/_DESIGN/debug_menu.html', $str);
    }
}