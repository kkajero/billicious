<?php

namespace spec\Model;

use Model\MealOrder;
use Model\FoodItemFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MealOrderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MealOrder::class);
    }

    function it_adds_food_items()
    {
        $item = FoodItemFactory::create();
        $this->add($item);

        $this->items()->shouldBe([$item]);
    }
}
