<?php

namespace FidelityProgramBundle\Service;

class PointsCalculator
{
    public function calculatePointsToReceive($value)
    {
        if ($value > 100) {
            return $this->calculate($value, 5);
        }

        if ($value > 70) {
            return $this->calculate($value, 3);
        }

        if ($value > 50) {
            return $this->calculate($value, 2);
        }

        return 0;
    }

    private function calculate($value, $multiply)
    {
        return ($value * $multiply) * 10;
    }
}