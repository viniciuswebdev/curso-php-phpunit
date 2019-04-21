<?php

namespace OrderBundle\Entity;

class CreditCard
{
    private $number;

    private $validity;

    public function __construct($number, \DateTime $validity)
    {
        $this->number = $number;
        $this->validity = $validity;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getValidity()
    {
        return $this->validity;
    }
}