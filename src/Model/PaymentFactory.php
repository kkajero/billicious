<?php

namespace Model;

use Model\MealOrder\Payment;

class PaymentFactory
{
    public static function payment($amount)
    {
        return new Payment($amount);
    }
}
