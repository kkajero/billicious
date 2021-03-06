Feature: Meal order
    In order to have a pleasurable experience at the end of my meal
    As a restaurant customer
    I would like to pay the bill smoothly and swiftly

    Scenario: Order available items, split the bill
        Given Jane, Petra, Maya visit a restaurant
        And they order the following items:
        | name  | price | available | quantity |
        | Chips | 2.50  | true      | 3        |
        | Fish  | 4.00  | true      | 2        |
        When Jane pays 7.00 toward the bill
        And Petra pays 6.00 toward the bill
        And Maya pays 5.00 toward the bill
        Then the bill should be closed
        And the tip should be 2.50

    Scenario: Order unavailable item
        Given Jane visits a restaurant
        When they try to order an unavailable item
        Then the order should be rejected

    Scenario: Cancel ordered item
        Given John visits a restaurant
        And they order the following items:
        | name  | price | available | quantity |
        | Chips | 2.50  | true      | 1        |
        | Fish  | 4.00  | true      | 2        |
        When they cancel item "Chips"
        Then the bill total should be 8.00

    Scenario: Cancel ordered item, after payment
        Given Peter, Mike visit a restaurant
        And they order the following items:
        | name  | price | available | quantity |
        | Chips | 2.50  | true      | 2        |
        | Fish  | 4.00  | true      | 2        |
        And Peter pays 7.00 toward the bill
        When Mike tries to cancel item "Chips"
        Then the cancellation should be rejected
