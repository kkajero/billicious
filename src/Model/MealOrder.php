<?php

namespace Model;

use Model\MealOrder\FoodItem;

class MealOrder
{
    private $items = [];

    public function add(FoodItem $item)
    {
        $this->items[] = $item;
    }

    public function items()
    {
        return $this->items;
    }
}
