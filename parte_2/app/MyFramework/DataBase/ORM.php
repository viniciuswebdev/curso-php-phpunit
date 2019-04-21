<?php

namespace MyFramework\DataBase;

use MyFramework\DataBase;

class ORM {

    private $db;

    public function __construct(DataBase\DataBase $dataBase)
    {
        $this->db = $dataBase;
    }

    public function findAll()
    {
        // find implementation
    }

    public function findByID($id)
    {
        // find implementation
    }

    public function persist($object)
    {
        // persist implementation
    }

}