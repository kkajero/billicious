<?php

namespace spec\Model;

use Model\PaymentFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PaymentFactory::class);
    }

    function it_creates_payments()
    {
        self::payment('0')->shouldHaveType('Model\MealOrder\Payment');
    }

    function it_creates_payment_from_amount()
    {
        $amount = '5';
        self::payment($amount)->value()->shouldBe('5');
    }
}
