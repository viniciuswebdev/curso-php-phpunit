<?php

namespace PaymentBundle\Test\Service;

use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;
use OrderBundle\Entity\Item;
use PaymentBundle\Exception\PaymentErrorException;
use PaymentBundle\Repository\PaymentTransactionRepository;
use PaymentBundle\Service\Gateway;
use PaymentBundle\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    private $gateway;
    private $paymentTransactionRepository;
    private $paymentService;
    private $customer;
    private $item;
    private $creditCard;

    public function setUp()
    {
        $this->gateway = $this->createMock(Gateway::class);
        $this->paymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);
        $this->paymentService = new PaymentService($this->gateway, $this->paymentTransactionRepository);

        $this->customer = $this->createMock(Customer::class);
        $this->item = $this->createMock(Item::class);
        $this->creditCard = $this->createMock(CreditCard::class);
    }

    /**
     * @test
     */
    public function shouldSaveWhenGatewayReturnOkWithRetries()
    {
        $this->gateway
            ->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(
                false, false, true
            ));

        $this->paymentTransactionRepository
            ->expects($this->once())
            ->method('save');

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenGatewayFails()
    {
        $this->gateway
            ->expects($this->atLeast(3))
            ->method('pay')
            ->will($this->onConsecutiveCalls(
                false, false, false
            ));

        $this->paymentTransactionRepository
            ->expects($this->never())
            ->method('save');

        $this->expectException(PaymentErrorException::class);

        $this->paymentService->pay($this->customer, $this->item, $this->creditCard);
    }

    public function tearDown()
    {
        unset($this->gateway);
    }
}