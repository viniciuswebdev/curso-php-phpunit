<?php

namespace OrderBundle\Validators;

class NotEmptyValidator
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        return !empty($this->value);
    }
}