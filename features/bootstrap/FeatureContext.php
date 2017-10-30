<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Webmozart\Assert\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given /^([\w,\s]+) visits? a restaurant$/
     */
    public function customersVisitARestaurant($names)
    {
        $this->setUpCustomers($names);
    }

    /**
     * @Given they order the following items:
     */
    public function theyOrderTheFollowingItems(TableNode $table)
    {
        $this->setUpMealOrder($table);
    }

    /**
     * @When :customer pays :amount toward the bill
     */
    public function customerPaysTowardTheBill($amount)
    {
        $payment = Model\PaymentFactory::payment($this->toPence($amount));

        $this->order->bill()->acceptPayment($payment);
    }

    /**
     * @Then the bill should be closed
     */
    public function theBillShouldBeClosed()
    {
        Assert::true($this->order->bill()->isClosed());
    }

    /**
     * @Then the tip should be :amount
     */
    public function theTipShouldBe($amount)
    {
        $tip = $this->order->bill()->tip();

        Assert::eq($tip->getAmount(), $this->toPence($amount));
    }

    /**
     * @When they try to order an unavailable item
     */
    public function theyTryToOrderAnUnavailableItem()
    {
        $this->order = new Model\MealOrder;
        $this->item = Model\FoodItemFactory::create(['available' => false]);
    }

    /**
     * @Then the order should be rejected
     */
    public function theOrderShouldBeRejected()
    {
        Assert::throws(function () {
            $this->order->add($this->item);
        }, \InvalidArgumentException::class);
    }

    /**
     * @When they cancel item ":name"
     */
    public function theyCancelItem($name)
    {
        $item = $this->extractFoodItem($name, $this->table);

        $this->order->cancel($item);
    }

    /**
     * @Then the bill total should be :amount
     */
    public function theBillTotalShouldBe($amount)
    {
        $total = $this->order->bill()->total();

        Assert::eq($total->getAmount(), $this->toPence($amount));
    }

    /**
     * @When Mike tries to cancel item ":name"
     */
    public function theyTryToCancelItem($name)
    {
        $this->item = $this->extractFoodItem($name, $this->table);
    }

    /**
     * @Then the cancellation should be rejected
     */
    public function theCancellationShouldBeRejected()
    {
        Assert::throws(function () {
            $this->order->cancel($this->item);
        }, \InvalidArgumentException::class);
    }

    private function setUpCustomers($names)
    {
        $this->customers = [];
        foreach (explode(',', $names) as $index => $name) {
            $id = $index + 1;
            $this->customers[] = new \Model\Customer($id, $name);
        }
    }

    private function setUpMealOrder(TableNode $table)
    {
        $this->table = $table;
        $this->order = new Model\MealOrder;

        foreach ($table as $row) {
            $row['price'] = $this->toPence($row['price']);
            $item = Model\FoodItemFactory::create($row);

            $count = 0;
            while ($count < $row['quantity']) {
                $this->order->add($item);
                $count++;
            }
        }
    }

    private function extractFoodItem($name, TableNode $table)
    {
        foreach ($this->table as $row) {
            if ($name == $row['name']) {
                $row['price'] = $this->toPence($row['price']);
                return Model\FoodItemFactory::create($row);
            }
        }
    }

    private function toPence($amount)
    {
        return str_replace('.', '', $amount);
    }
}
