Feature: tipper
  Scenario: visitor wants to register
    Given I am on "/"
    When I click on the "register" link
    Then I should be redirected to "/account/register"

  Scenario: visitor register
    Given I am on "/account/register"
    When I fill the "create account" form like:
        | register-name | register-mfcname | register-mail | register-password |
        | Martin        | James            | James@doe.org | james123          |
    Then I Should see a notification "You have been registered as Martin"

