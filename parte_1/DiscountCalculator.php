<?php

class DiscountCalculator {

    const MINIMUM_VALUE = 100;

    const DISCOUNT_VALUE = 20;

    public function apply($value) {

        if ($value > self::MINIMUM_VALUE) {
            return $value - self::DISCOUNT_VALUE;
        }

        return $value;
    }

}