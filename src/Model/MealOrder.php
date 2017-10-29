<?php

namespace Model;

use Model\MealOrder\FoodItem;
use Model\MealOrder\Bill;

class MealOrder
{
    private $items = [];
    private $bill;

    public function add(FoodItem $item)
    {
        $this->items[] = $item;
        $this->updateBill($item);
    }

    public function items()
    {
        return $this->items;
    }

    public function bill()
    {
        return $this->bill;
    }

    private function updateBill(FoodItem $item)
    {
        if (!$this->bill) {
            $this->bill = new Bill;
        }

        $this->bill->add($item);
    }
}
