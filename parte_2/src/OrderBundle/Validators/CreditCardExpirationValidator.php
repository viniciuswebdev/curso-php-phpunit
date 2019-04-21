<?php

namespace OrderBundle\Validators;

class CreditCardExpirationValidator
{
    private $value;

    public function __construct(\DateTime $value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        $now = new \DateTime('now');
        return $this->value > $now;
    }
}