<?php

namespace MyFramework;

use OrderBundle\Entity\CreditCard;
use OrderBundle\Entity\Customer;

interface HttpClientInterface
{
    public function send($method, $location, $data);
}