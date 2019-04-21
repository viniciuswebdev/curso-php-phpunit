<?php

namespace PaymentBundle\Service;

use MyFramework\Controller\HttpClientInterface;
use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use PaymentBundle\Entity\PaymentTransaction;
use PaymentBundle\Exception\PaymentErrorException;
use PaymentBundle\Repository\PaymentTransactionRepository;

class PaymentService
{
    private $gateway;
    private $paymentTransactionRepository;

    public function __construct(
        Gateway $gateway,
        PaymentTransactionRepository $paymentTransactionRepository
    )
    {
        $this->gateway = $gateway;
        $this->paymentTransactionRepository = $paymentTransactionRepository;
    }

    public function pay(Customer $customer, Item $item, CreditCard $creditCard)
    {
        for ($i = 0; $i < 3; $i++) {
            $paid = $this->gateway->pay(
                $customer->getName(),
                $creditCard->getNumber(),
                $creditCard->getValidity(),
                $item->getValue()
            );

            if ($paid === true) {
                break;
            }
        }

        if (!$paid) {
            throw new PaymentErrorException();
        }

        $paymentTransaction = new PaymentTransaction(
            $customer,
            $item,
            $item->getValue()
        );

        $this->paymentTransactionRepository->save($paymentTransaction);

        return $paymentTransaction;
    }
}