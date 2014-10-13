Feature: admin
  Scenario: have the admin rights
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    Then I should see "table" like:
      | name        | preview  | tokens | status  | actions   | admin              |
      | Sailor Moon | no image | 100    | pending | add a tip | approve disapprove |



