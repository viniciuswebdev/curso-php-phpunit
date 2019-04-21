<?php

namespace PaymentBundle\Repository;

use MyFramework\Controller\HttpClientInterface;
use MyFramework\DataBase\ORM;
use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Item;
use PaymentBundle\Entity\PaymentTransaction;

class PaymentTransactionRepository extends ORM
{
    public function save(PaymentTransaction $paymentTransaction)
    {
        $this->persist($paymentTransaction);
    }
}