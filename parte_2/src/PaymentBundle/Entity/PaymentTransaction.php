<?php

namespace PaymentBundle\Entity;

use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;

class PaymentTransaction
{
    private $customer;
    private $item;
    private $value;

    public function __construct(Customer $customer, Item $item, $value)
    {
        $this->customer = $customer;
        $this->item = $item;
        $this->value = $value;
    }
}