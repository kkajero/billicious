<?php

namespace Model\MealOrder;

use Money\Money;

class Bill
{
    private $total = 0;
    private $closed = false;

    public function __construct()
    {
        $this->total = Money::GBP($this->total);
    }

    public function total()
    {
        return $this->total;
    }

    public function add(FoodItem $item)
    {
        $this->total = $this->total->add($item->price());
    }

    public function acceptPayment(Payment $payment)
    {
        $this->total = $this->total->subtract($payment->amount());

        if (!$this->closed && ($this->total->lessThanOrEqual(Money::GBP(0)))) {
            $this->closed = true;
        }
    }

    public function isClosed()
    {
        return $this->closed;
    }

    public function tip()
    {
        return $this->total->absolute();
    }
}
