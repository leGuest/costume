Feature: tipper
  Scenario: tipper wants to register
    Given I am on "/"
    When I click on the "register" link
    Then I should be redirected to "/account/register"

  Scenario: tipper register
    Given I am on "/account/register"
    When I fill the "create account" form like:
        | register-name | register-mfcname | register-mail | register-password |
        | Martin        | James            | James@doe.org | james123          |
    Then I Should see a notification "You have been registered as Martin"

  Scenario: tipper wants to login
    Given I am on "/"
    When I click on the "login" link
    Then I should be redirected to "/account/login"

  Scenario: tipper login
    Given I am on "/account/login"
    When I fill the "login" form like:
      | login-name | login-password |
      | Martin     | james123       |
    Then I Should see a notification "Welcome back, Martin"

  Scenario: tipper logout
    Given I am on "/"
    When I click on the "logout" link
    Then I Should see a notification "You have successfully logged out"
