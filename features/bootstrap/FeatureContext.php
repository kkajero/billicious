<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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
     * @Given /^(Jane, Petra, Maya) visit a restaurant$/
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
     * @When :customer pays :payment toward the bill
     */
    public function customerPaysTowardTheBill($payment)
    {
        throw new PendingException();
    }

    /**
     * @Then the bill should be closed
     */
    public function theBillShouldBeClosed()
    {
        throw new PendingException();
    }

    /**
     * @Then the tip should be :amount
     */
    public function theTipShouldBe($amount)
    {
        throw new PendingException();
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
        $this->order = new Model\MealOrder;

        foreach ($table as $row) {
            $row['price'] = str_replace('.', '', $row['price']);
            $item = Model\FoodItemFactory::create($row);

            $count = 0;
            while ($count < $row['quantity']) {
                $this->order->add($item);
                $count++;
            }
        }
    }
}
