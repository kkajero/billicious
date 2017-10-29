<?php

namespace spec\Model;

use Model\FoodItemFactory;
use Model\MealOrder\FoodItem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FoodItemFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FoodItemFactory::class);
    }

    function it_creates_food_items()
    {
        self::create()->shouldHaveType('Model\MealOrder\FoodItem');
    }

    function it_creates_food_items_from_defaults()
    {
        $foodItem = self::create();

        $foodItem->name()->shouldEqual(FoodItem::NAME_DEFAULT);
        $foodItem->price()->shouldEqual(FoodItem::PRICE_DEFAULT);
        $foodItem->available()->shouldEqual(FoodItem::AVAILABLE_DEFAULT);
    }

    function it_creates_food_items_from_data_argument_and_defaults()
    {
        $data = [
            'name' => 'A yummy food item',
            'available' => false
        ];

        $foodItem = self::create($data);

        $foodItem->name()->shouldEqual($data['name']);
        $foodItem->price()->shouldEqual(FoodItem::PRICE_DEFAULT);
        $foodItem->available()->shouldEqual($data['available']);
    }
}
