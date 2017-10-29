<?php

namespace Model\MealOrder;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class FoodItem
{
    const NAME_DEFAULT = 'food-item';
    const PRICE_DEFAULT = '0.00';
    const AVAILABLE_DEFAULT = true;

    private $name;
    private $price;
    private $available;
    private $decimalMoneyFormatter;

    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        $this->setPrice();
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies);
    }

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->decimalMoneyFormatter->format($this->price);
    }

    public function available()
    {
        return $this->available;
    }

    private function setPrice()
    {
        $this->price = Money::GBP($this->price);
    }
}
