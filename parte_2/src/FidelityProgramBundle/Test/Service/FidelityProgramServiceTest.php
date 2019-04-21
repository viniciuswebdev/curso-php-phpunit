<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class FidelityProgramServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSaveWhenReceivePoints()
    {
        $pointsRepository = $this->createMock(PointsRepository::class);
        $pointsRepository->expects($this->once())
            ->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')
            ->willReturn(100);

        $allMessages = [];
        $logger = $this->createMock(LoggerInterface::class);
        $logger->method('log')
            ->will($this->returnCallback(
                function ($message) use (&$allMessages) {
                    $allMessages[] = $message;
                }
            ));

        $fidelityProgramService = new FidelityProgramService(
            $pointsRepository,
            $pointsCalculator,
            $logger
        );

        $customer = $this->createMock(Customer::class);
        $value = 50;
        $fidelityProgramService->addPoints($customer, $value);

        $expectedMessages = [
            'Checking points for customer',
            'Customer received points'
        ];
        $this->assertEquals($expectedMessages, $allMessages);
    }

    /**
     * @test
     */
    public function shouldNotSaveWhenReceiveZeroPoints()
    {
        $pointsRepository = $this->createMock(PointsRepository::class);
        $pointsRepository->expects($this->never())
            ->method('save');

        $pointsCalculator = $this->createMock(PointsCalculator::class);
        $pointsCalculator->method('calculatePointsToReceive')
            ->willReturn(0);

        $logger = $this->createMock(LoggerInterface::class);

        $fidelityProgramService = new FidelityProgramService(
            $pointsRepository,
            $pointsCalculator,
            $logger
        );

        $customer = $this->createMock(Customer::class);
        $value = 20;
        $fidelityProgramService->addPoints($customer, $value);
    }
}