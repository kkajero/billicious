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

    function it_opens_the_bill_on_first_item()
    {
        $this->bill()->shouldBe(null);

        $item = FoodItemFactory::create();
        $this->add($item);

        $this->bill()->shouldHaveType('\Model\MealOrder\Bill');
    }

    function it_adds_items_to_the_bill()
    {
        $this->add(FoodItemFactory::create(['price' => '5']));
        $this->add(FoodItemFactory::create(['price' => '5']));

        $this->bill()->total()->getAmount()->shouldBe('10');
    }
}
