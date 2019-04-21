<?php

namespace OrderBundle\Repository;

use MyFramework\DataBase;
use MyFramework\DataBase\ORM;

class BadWordsRepository extends ORM implements BadWordsRepositoryInterface
{
    public function findAllAsArray()
    {
        return parent::findAll();
    }
}