<?php

namespace FidelityProgramBundle\Repository;

use MyFramework\DataBase\ORM;

class PointsRepository extends ORM implements PointsRepositoryInterface
{
    public function save($points)
    {
        return parent::persist($points);
    }
}