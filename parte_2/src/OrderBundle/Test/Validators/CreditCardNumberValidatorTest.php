<?php

namespace OrderBundle\Validators\Test;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {
        $creditCardNumberValidator = new CreditCardNumberValidator($value);

        $isValid = $creditCardNumberValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider()
    {
        return [
            'shouldBeValidWhenValueIsANumber' => ['value' => 4928148506666302, 'expectedResult' => true],
            'shouldBeValidWhenValueIsACreditCardAsString' => ['value' => '4928148506666302', 'expectedResult' => true],
            'shouldNotBeValidWhenValueIsNotACreditCard' => ['value' => '12738', 'expectedResult' => false],
            'shouldNotBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false]
        ];
    }
}