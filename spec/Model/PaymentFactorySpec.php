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

    function it_creates_tips()
    {
        self::tip('0')->shouldHaveType('Model\MealOrder\Tip');
    }

    function it_creates_tip_from_amount()
    {
        $amount = '1';
        self::tip($amount)->value()->shouldBe('1');
    }
}
