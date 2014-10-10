Feature: tips
  Scenario: visitor wants to tip on a costume
    Given I am on "/"
    And I should see a list of costumes
    When I click on the "costume--tip" link of hash id "shgbvb35"
    Then I should be redirected to "/costume/tip/shgbvb35"

  Scenario: vistor tip a costume
    Given I am on "/costume/tip/shgbvb35"
    When I fill the form like:
      | costume-name | costume-tokens | customer-tippername |
      | Sailor Moon  | 250            | James               |
    Then I should see a notification
    And the "costume tokens" of the "costume name" should be updated

