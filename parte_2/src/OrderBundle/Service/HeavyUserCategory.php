<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class HeavyUserCategory implements CustomerCategoryInterface
{
    public function isEligible(Customer $customer)
    {
        return (
            $customer->getTotalOrders() >= 50 &&
            $customer->getTotalRatings() >= 10 &&
            $customer->getTotalRecommendations() >= 5
        );
    }

    public function getCategoryName()
    {
        return CustomerCategoryService::CATEGORY_HEAVY_USER;
    }
}