<?php

namespace OrderBundle\Test\Service;

use OrderBundle\Entity\Customer;
use OrderBundle\Service\CustomerCategoryService;
use OrderBundle\Service\LightUserCategory;
use OrderBundle\Service\HeavyUserCategory;
use OrderBundle\Service\MediumUserCategory;
use OrderBundle\Service\NewUserCategory;
use PHPUnit\Framework\TestCase;

class CustomerCategoryServiceTest extends TestCase
{
    private $customerCategoryService;

    public function setup()
    {
        $this->customerCategoryService = new CustomerCategoryService();
        $this->customerCategoryService->addCategory(new HeavyUserCategory());
        $this->customerCategoryService->addCategory(new MediumUserCategory());
        $this->customerCategoryService->addCategory(new LightUserCategory());
        $this->customerCategoryService->addCategory(new NewUserCategory());
    }

    /**
     * @test
     */
    public function customerShouldBeNewUser()
    {
        $customer = new Customer();
        $usageCategory = $this->customerCategoryService->getUsageCategory($customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_NEW_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeLightUser()
    {
        $customer = new Customer();
        $customer->setTotalOrders(5);
        $customer->setTotalRatings(1);

        $usageCategory = $this->customerCategoryService->getUsageCategory($customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_LIGHT_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldBeMediumUser()
    {
        $customer = new Customer();
        $customer->setTotalOrders(20);
        $customer->setTotalRatings(5);
        $customer->setTotalRecommendations(1);

        $usageCategory = $this->customerCategoryService->getUsageCategory($customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_MEDIUM_USER, $usageCategory);
    }

    /**
     * @test
     */
    public function customerShouldHeavyUser()
    {
        $customer = new Customer();
        $customer->setTotalOrders(50);
        $customer->setTotalRatings(10);
        $customer->setTotalRecommendations(5);

        $usageCategory = $this->customerCategoryService->getUsageCategory($customer);

        $this->assertEquals(CustomerCategoryService::CATEGORY_HEAVY_USER, $usageCategory);
    }
}
