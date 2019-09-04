<?php
/**
 * Created by PhpStorm.
 * User: libertalia
 * Date: 03/09/19
 * Time: 18:27
 */

namespace App\Repository;


interface FetchTitles
{
    public const JSON_SERIALIZATION = 'json';

    public function getAllTitles(): ?string;

}