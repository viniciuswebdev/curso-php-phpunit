<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Repository\PointsRepositoryInterface;

class PointsRepositorySpy implements PointsRepositoryInterface
{
    private $called;

    public function save($points)
    {
        $this->called = true;
    }

    public function called()
    {
        return $this->called;
    }
}