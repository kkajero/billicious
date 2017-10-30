<?php

namespace Model;

use Model\MealOrder\Payment;
use Model\MealOrder\Tip;

class PaymentFactory
{
    public static function payment($amount)
    {
        return new Payment($amount);
    }

    public static function tip($amount)
    {
        return new Tip($amount);
    }
}
