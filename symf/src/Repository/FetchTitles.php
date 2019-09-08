<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 03/09/19
 * Time: 18:27
 */

namespace App\Repository;

use App\Service\JsonSerializer;
use Symfony\Bridge\Doctrine\RegistryInterface;

interface FetchTitles
{
    /**
     * FetchTitles constructor.
     * @param RegistryInterface $registry
     * @param JsonSerializer $serializer
     */
    public function __construct(RegistryInterface $registry, JsonSerializer $serializer);

    /**
     * @return string|null
     */
    public function getAllTitles(): ?string;

}