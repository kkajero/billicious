Feature: Meal order
    In order to have a pleasurable experience at the end of my meal
    As a restaurant customer
    I would like to pay the bill smoothly and swiftly

    Scenario: Order available items, split the bill
        Given Jane, Petra, Maya visit a restaurant:
        And they order the following items:
        | name  | price | available | quantity |
        | Chips | 2.50  | true      | 3        |
        | Fish  | 4.00  | true      | 2        |
        When Jane pays 7.00 toward the bill
        And Petra pays 6.00 toward the bill
        And Maya pays 5.00 toward the bill
        Then the bill should be closed
        And the tip should be 2.50
