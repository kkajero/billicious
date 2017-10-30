<?php

namespace spec\Model\MealOrder;

use Model\FoodItemFactory;
use Model\PaymentFactory;
use Model\MealOrder\Bill;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BillSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Bill::class);
    }

    function it_starts_with_total_of_zero()
    {
        $this->total()->isZero()->shouldBe(true);
    }

    function it_updates_total_with_price_of_items_added()
    {
        $this->add_item_priced_at('2');
        $this->add_item_priced_at('3');

        $this->total()->getAmount()->shouldBe('5');
    }

    function it_updates_total_with_price_of_items_removed()
    {
        $item = $this->add_item_priced_at('3');
        $this->add_item_priced_at('2');

        $this->remove($item);

        $this->total()->getAmount()->shouldBe('2');
    }

    function it_accepts_payments_to_reduce_total()
    {
        $this->add_item_priced_at('7');
        $this->acceptPayment(PaymentFactory::payment('4'));
        $this->acceptPayment(PaymentFactory::payment('4'));

        $this->total()->getAmount()->shouldBe('-1');
    }

    function it_becomes_closed_when_fully_paid()
    {
        $this->add_item_priced_at('5');
        $this->acceptPayment(PaymentFactory::payment('5'));

        $this->shouldBeClosed();
    }

    function it_applies_payments_above_total_to_tip()
    {
        $this->add_item_priced_at('3');
        $this->acceptPayment(PaymentFactory::payment('5'));

        $this->tip()->getAmount()->shouldBe('2');
    }

    function it_has_payments_after_accepting_them()
    {
        $this->shouldNotHavePayments();

        $this->acceptPayment(PaymentFactory::payment('10'));

        $this->shouldHavePayments();
    }

    private function add_item_priced_at($value)
    {
        $item = FoodItemFactory::create(['price' => $value]);
        $this->add($item);

        return $item;
    }
}
