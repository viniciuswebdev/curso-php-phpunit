<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

interface CustomerCategoryInterface
{
    public function isEligible(Customer $customer);
    public function getCategoryName();
}