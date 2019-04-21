<?php

namespace FidelityProgramBundle\Service;

use FidelityProgramBundle\Entity\Points;
use FidelityProgramBundle\Repository\PointsRepositoryInterface;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;

class FidelityProgramService
{
    private $pointsRepository;
    private $pointsCalculator;
    private $logger;

    public function __construct(
        PointsRepositoryInterface $pointsRepository,
        PointsCalculator $pointsCalculator,
        LoggerInterface $logger
    )
    {
        $this->pointsRepository = $pointsRepository;
        $this->pointsCalculator = $pointsCalculator;
        $this->logger = $logger;
    }

    public function addPoints(Customer $customer, $value)
    {
        $this->logger->log('Checking points for customer');
        $pointsToAdd = $this->pointsCalculator->calculatePointsToReceive($value);

        if ($pointsToAdd > 0) {
            $points = new Points($customer, $pointsToAdd);
            $this->pointsRepository->save($points);
            $this->logger->log('Customer received points');
        }
    }
}