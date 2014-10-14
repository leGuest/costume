Feature: tips
  Scenario: visitor wants to tip on a costume
    Given I am on "/"
    And I should see a list of costumes
    When I click on the "costume--tip" link of id "/costume/tip/shgbvb35" marked as "add a tip"
    Then I should be redirected to "/costume/tip/shgbvb35"

  Scenario: vistor tip a costume
    Given I am on "/costume/tip/shgbvb35"
    When I fill the "tip the costume" form like:
      | costume-add-tokens  | costume-add-tippername  |
      | 250                 | James               |
    Then I Should see a notification "The tip have been added."

