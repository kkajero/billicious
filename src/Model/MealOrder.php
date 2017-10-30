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
        if (!$item->available()) {
            throw new \InvalidArgumentException('Cannot order unavailable food item');
        }

        $this->items[] = $item;
        $this->addToBill($item);
    }

    public function items()
    {
        return $this->items;
    }

    public function bill()
    {
        return $this->bill;
    }

    public function cancel(FoodItem $item)
    {
        foreach ($this->items as $index => $foodItem) {
            if ($item == $foodItem) {
                unset($this->items[$index]);
                $this->removeFromBill($item);
                break;
            }
        }
    }

    private function addToBill(FoodItem $item)
    {
        if (!$this->bill) {
            $this->bill = new Bill;
        }

        $this->bill->add($item);
    }

    private function removeFromBill(FoodItem $item)
    {
        if ($this->bill) {
            $this->bill->remove($item);
        }
    }
}
