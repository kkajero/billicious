<?php

namespace Model\MealOrder;

use Money\Money;

class Bill
{
    private $total = 0;
    private $closed = false;
    private $payments = [];

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
        if ($this->closed && !$this->isTip($payment)) {
            throw new \InvalidArgumentException('Cannot accept payment; bill is closed');
        }

        $this->total = $this->total->subtract($payment->amount());

        if (!$this->closed && ($this->total->lessThanOrEqual(Money::GBP(0)))) {
            $this->closed = true;
        }

        $this->payments[] = $payment;
    }

    public function isClosed()
    {
        return $this->closed;
    }

    public function tip()
    {
        return $this->total->absolute();
    }

    public function remove(FoodItem $item)
    {
        $this->total = $this->total->subtract($item->price());
    }

    public function hasPayments()
    {
        return (!empty($this->payments));
    }

    private function isTip(Payment $payment)
    {
        return ($payment instanceof Tip);
    }
}
