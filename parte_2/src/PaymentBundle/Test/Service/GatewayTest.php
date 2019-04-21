<?php

namespace PaymentBundle\Test\Service;

use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PaymentBundle\Service\Gateway;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotPayWhenAuthenticationFail()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'invalid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                null
            ]
        ];
        $httpClient
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            'Vinicius Oliveira',
            5555444488882222,
            new \DateTime('now'),
            100
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldNotPayWhenFailOnGateway()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $token = 'meu-token';
        $httpClient
            ->expects($this->at(0))
            ->method('send')
            ->willReturn($token);

        $httpClient
            ->expects($this->at(1))
            ->method('send')
            ->willReturn(['paid' => false]);

        $logger
            ->expects($this->once())
            ->method('log')
            ->with('Payment failed');

        $name = 'Vinicius Oliveira';
        $creditCardNumber = 5555444488882222;
        $value = 100;
        $validity = new \DateTime('now');
        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $validity,
            $value
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldSuccessfullyPayWhenGatewayReturnOk()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $name = 'Vinicius Oliveira';
        $creditCardNumber = 9999999999999999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'meu-token';
        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password
                ],
                'meu-token'
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCardNumber,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $token
                ],
                ['paid' => true]
            ]
        ];
        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCardNumber,
            $validity,
            $value
        );

        $this->assertEquals(true, $paid);
    }
}