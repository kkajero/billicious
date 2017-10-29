<?php

namespace Model\MealOrder;

use Money\Money;

class Payment
{
    private $money;

    public function __construct($amount)
    {
        $this->money = Money::GBP($amount);
    }

    public function amount()
    {
        return $this->money;
    }

    public function value()
    {
        return $this->money->getAmount();
    }
}
