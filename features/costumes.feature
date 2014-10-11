Feature: costumes
  Scenario: list of costumes
  When I am on "/"
  Then I should see a list of costumes
  And I Should see a "add costume" link that should go to "/costume/add"

  Scenario: visitor wants to add a costume
    Given I am on "/"
    When I click on the "add costume" link
    Then I should be redirected to "/costume/add"

  Scenario: visitor add a costume
    Given I am on "/costume/add"
    When I fill the "add a costume" form like:
      | costume-name | costume-tokens | costume-tippername |
      | Sailor Moon  | 100            | John               |
    Then I Should see a notification

