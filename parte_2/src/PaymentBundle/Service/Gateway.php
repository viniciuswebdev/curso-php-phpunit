<?php

namespace PaymentBundle\Service;

use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;

class Gateway
{
    const BASE_URL = 'https://paymentgateway.ex';

    private $httpClient;
    private $logger;
    private $user;
    private $password;

    public function __construct(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        $user,
        $password
    )
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->user = $user;
        $this->password = $password;
    }

    public function pay($name, $creditCardNumber, \DateTime $validity = null, $value) {

        $token = $this->httpClient->send('POST', self::BASE_URL . '/authenticate', [
            'user' => $this->user,
            'password' => $this->password
        ]);

        if (!$token) {
            $this->logger->log('Authentication failed');
            return false;
        }

        $response = $this->httpClient->send('POST', self::BASE_URL . '/pay', [
            'name' => $name,
            'credit_card_number' => $creditCardNumber,
            'validity' => $validity,
            'value' => $value,
            'token' => $token
        ]);

        if (!$response['paid'] === true) {
            $this->logger->log('Payment failed');
            return false;
        }

        return true;
    }
}