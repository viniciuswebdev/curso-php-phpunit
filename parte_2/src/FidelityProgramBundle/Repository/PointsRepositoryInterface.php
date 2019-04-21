<?php

namespace FidelityProgramBundle\Repository;

use MyFramework\DataBase\ORM;

interface PointsRepositoryInterface
{
    public function save($points);
}