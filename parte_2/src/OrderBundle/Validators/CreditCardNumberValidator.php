<?php

namespace OrderBundle\Validators;

class CreditCardNumberValidator
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        return strlen($this->value) == 16 && is_numeric($this->value);
    }
}