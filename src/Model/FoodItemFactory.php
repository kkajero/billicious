<?php

namespace Model;

use Model\MealOrder\FoodItem;

class FoodItemFactory
{
    private static $dataDefaults = [
        'name' => FoodItem::NAME_DEFAULT,
        'price' => FoodItem::PRICE_DEFAULT,
        'available' => FoodItem::AVAILABLE_DEFAULT
    ];

    public static function create(array $data = [])
    {
        $data = array_merge(self::$dataDefaults, $data);

        return new FoodItem($data);
    }
}
