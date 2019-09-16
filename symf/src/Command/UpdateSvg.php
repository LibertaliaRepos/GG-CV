<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 08/09/19
 * Time: 19:11
 */

namespace App\Command;

use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Svg\SvgJson;
use App\Entity\XpPro;
use App\Service\JsonSerializer;
use App\Service\menuGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSvg extends Command {

    protected static $defaultName = 'app:update:svg';

    /** @var JsonSerializer $serializer */
    private $serializer;
    /** @var menuGenerator $menuGenerator */
    private $menuGenerator;
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * UpdateSvg constructor.
     * @param JsonSerializer $jsonSerializer
     * @param menuGenerator $menuGenerator
     * @param EntityManagerInterface $em
     */
    public function __construct(JsonSerializer $jsonSerializer, menuGenerator $menuGenerator, EntityManagerInterface $em) {
        parent::__construct('menuGenerator');

        $this->setSerializer($jsonSerializer);
        $this->setMenuGenerator($menuGenerator);
        $this->setEm($em);
    }

    /**
     * @return JsonSerializer
     */
    private function getSerializer(): JsonSerializer {
        return $this->serializer;
    }

    /**
     * @param JsonSerializer $serializer
     */
    private function setSerializer(JsonSerializer $serializer): void {
        $this->serializer = $serializer;
    }

    /**
     * @return menuGenerator
     */
    private function getMenuGenerator(): menuGenerator {
        return $this->menuGenerator;
    }

    /**
     * @param menuGenerator $menuGenerator
     */
    private function setMenuGenerator(menuGenerator $menuGenerator): void {
        $this->menuGenerator = $menuGenerator;
    }

    /**
     * @return EntityManagerInterface
     */
    private function getEm(): EntityManagerInterface {
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    private function setEm(EntityManagerInterface $em): void {
        $this->em = $em;
    }

    /**
     *
     */
    protected function configure() {
        $this->setDescription('Update/Regenerate pageMenu svg');
        $this->addOption('table_id', 't',InputOption::VALUE_REQUIRED, 'Which table_id (1 => skill, 2 => project, 3 => xppro) would you want to update/Regenerate ?');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function execute(InputInterface $input, OutputInterface $output): void {
        if (empty(($id = $input->getOption('table_id'))))
            throw new \Exception('L\'id_table spécifié est vide');

        if(preg_match('/D/', $id) || ! in_array($id,SvgJson::ALLOWED_TABLE_ID))
            throw new \Exception("L'id_table doit être un entier. Les id autorisés sont :\n1 => skill, 2 => project, 3 => xppro");

        $output->write($this->updateSvgJson($id));
    }

    /**
     * @param int $id_table
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function updateSvgJson(int $id_table): string {

        if (! in_array($id_table, SvgJson::ALLOWED_TABLE_ID))
            throw new \Exception('La table d\'id ' . $id_table . ' n\'existe pas');

        switch ($id_table) {
            case SvgJson::SKILL_TABLE_ID:       $model = Skill::class;      break;
            case SvgJson::PROJECT_TABLE_ID:     $model = Project::class;    break;
            case SvgJson::XPPRO_TABLE_ID:       $model = XpPro::class;      break;
        }

        /** @var SvgJson $titlesSVG_table */
        $titlesSVG_table = $this->getEm()->getRepository(SvgJson::class)->findOneBy(['id_svg_json' => $id_table]);

        if (empty($titlesSVG_table))
            throw new \Exception("La table d'id => $id_table est vide");

        $this->getEm()->persist($titlesSVG_table);

        $titlesSVG_table->setScript($result = $this->getMenuGenerator()->buildTitleSvg($this->getSerializer()->deserialize($titlesSVG_table->getJson())));

        $this->getEm()->flush();

        return $result;
    }
}