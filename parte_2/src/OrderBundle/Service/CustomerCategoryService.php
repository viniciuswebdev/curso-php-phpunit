<?php

namespace OrderBundle\Service;

use OrderBundle\Entity\Customer;

class CustomerCategoryService
{
    const CATEGORY_NEW_USER = 'new-user';
    const CATEGORY_LIGHT_USER = 'light-user';
    const CATEGORY_MEDIUM_USER = 'medium-user';
    const CATEGORY_HEAVY_USER = 'heavy-user';

    private $categories;

    public function addCategory(CustomerCategoryInterface $category)
    {
        $this->categories[] = $category;
    }

    public function getUsageCategory(Customer $customer)
    {
        foreach ($this->categories as $category) {
            if ($category->isEligible($customer)) {
                return $category->getCategoryName();
            }
        }
    }
}