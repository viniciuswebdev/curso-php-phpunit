<?php

namespace OrderBundle\Entity;

class Restaurant
{
    private $name;
    private $open;

    public function __construct($name, $open)
    {
        $this->name = $name;
        $this->open = $open;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isOpen()
    {
        return $this->open;
    }
}