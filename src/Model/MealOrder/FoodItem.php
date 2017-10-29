<?php

namespace Model\MealOrder;

use Money\Money;

class FoodItem
{
    const NAME_DEFAULT = 'food-item';
    const PRICE_DEFAULT = '0';
    const AVAILABLE_DEFAULT = true;

    private $name;
    private $price;
    private $available;

    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        $this->setPrice();
    }

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->price;
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
