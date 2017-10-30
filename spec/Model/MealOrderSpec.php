<?php

namespace spec\Model;

use Model\MealOrder;
use Model\FoodItemFactory;
use Model\PaymentFactory;
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

    function it_adds_food_items_to_the_bill()
    {
        $this->add(FoodItemFactory::create(['price' => '5']));
        $this->add(FoodItemFactory::create(['price' => '5']));

        $this->bill()->total()->getAmount()->shouldBe('10');
    }

    function it_rejects_unavailable_food_items()
    {
        $unavailableItem = FoodItemFactory::create(['available' => false]);

        $this->shouldThrow('\InvalidArgumentException')->duringAdd($unavailableItem);
    }

    function it_cancels_food_items()
    {
        $item1 = FoodItemFactory::create(['price' => '10']);
        $item2 = FoodItemFactory::create(['price' => '20']);
        $this->add($item1);
        $this->add($item2);

        $this->cancel($item1);

        $this->bill()->total()->getAmount()->shouldBe('20');
    }

    function it_cancels_food_items_only_if_no_payments_on_bill()
    {
        $item = FoodItemFactory::create(['price' => '10']);
        $this->add($item);
        $this->bill()->acceptPayment(PaymentFactory::payment('5'));

        $this->shouldThrow('\InvalidArgumentException')->duringCancel($item);
    }
}
