<?php

namespace OrderBundle\Entity;

use PaymentBundle\Entity\PaymentTransaction;

class Order
{
    private $customer;

    private $paymentTransaction;

    private $item;

    private $description;

    private $guid;

    public function __construct(
        Customer $customer,
        PaymentTransaction $paymentTransaction,
        Item $item,
        $description
    )
    {
        $this->customer = $customer;
        $this->paymentTransaction = $paymentTransaction;
        $this->item = $item;
        $this->description = $description;
    }

    public function getOrderGUID()
    {
        return $this->guid;
    }

    public function getPaymentTransaction()
    {
        return $this->paymentTransaction;
    }
}