Feature: admin
  Scenario: have the admin rights
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    Then I should see "table" like:
      | name                    | preview               | tokens | status  | actions   | admin              |
      | Sailor Moon update name | no image update image | 100    | pending | add a tip | approve disapprove |
    And I Should see a "transaction list" link that should go to "/transaction"

  Scenario: transaction list
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    Then I should see "table" like:
      | costume                 | tokens              | tipper | status  | actions            |
      | Sailor Moon update name | 100 update amount   | John   | pending | approve disapprove |

  Scenario: approve a transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    And I click on the "approve" link
    Then I should see "table" like:
      | costume                 | tokens              | tipper | status     | actions            |
      | Sailor Moon update name | 100   update amount | John   | approved   | approve disapprove |
      | Sailor Moon update name | 200   update amount | John   | pending    | approve disapprove |
      | Sailor Moon update name | 250   update amount | James  | pending    | approve disapprove |

  Scenario: disapprove a transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    And I click on the "2" "disapprove" link
    Then I should see "table" like:
      | costume                 | tokens             | tipper | status   | actions            |
      | Sailor Moon update name | 100  update amount | John   | approved | approve disapprove |
      | Sailor Moon update name | 200  update amount | John   | denied   | approve disapprove |
      | Sailor Moon update name | 250  update amount | James  | pending  | approve disapprove |

  Scenario: wants to update a costume on transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    And I am on "/transaction"
    When I click on the "1" "update name" link
    Then I should be redirected to "/transaction/update/name/1"

  Scenario: update a costume on transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction/update/name/1"
    And I fill the "update the costume name" form like:
      | transaction-update-costumename        |
      | Hulk                                  |
    Then I Should see a notification "The costume name for the transaction have been added."

  Scenario: wants to update a costume on transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    And I am on "/transaction"
    When I click on the "1" "update tokens" link
    Then I should be redirected to "/transaction/update/tokens/1"

  Scenario: update tokens amount on transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction/update/tokens/1"
    And I fill the "update the costume name" form like:
      | transaction-update-tokensamount         |
      | 400                                     |
    Then I Should see a notification "The tokens amount for the transaction have been added."

  Scenario: approve a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "approve" link
    Then I should see "table" like:
      | name                    | preview               | tokens | status    | actions   | admin              |
      | Sailor Moon update name | no image update image | 200    | published | add a tip | unpublish          |

  Scenario: disapprove a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "costume--disapprove" link of id "/costume/disapprove/3ef6990e" marked as "disapprove"
    Then I should see "table" like:
      | name                    | preview               | tokens | status    | actions     | admin     |
      | Sailor Moon update name | no image update image | 200    | published | add a tip   | unpublish |
      | Hulk        update name | no image update image | 100    | pending   | add a tip   | no action |

  Scenario: unpublish a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "unpublish" link
    Then I should see "table" like:
      | name                    | preview               | tokens | status    | actions   | admin              |
      | Sailor Moon update name |no image update image  | 200    | pending   | add a tip | approve disapprove |

  Scenario: wants to update a costume name
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "costume--update--name" link of id "/costume/update/name/shgbvb35" marked as "update name"
    Then I should be redirected to "/costume/update/name/shgbvb35"

  Scenario: update a costume name
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    And I am on "/costume/update/name/shgbvb35"
    When I fill the "update the costume name" form like:
      | costume-update-name         |
      | Sailor Moon                 |
    Then I Should see a notification "The costume name have been updated."

  Scenario: wants to update a costume image
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "costume--update--image" link of id "/costume/update/image/shgbvb35" marked as "update image"
    Then I should be redirected to "/costume/update/image/shgbvb35"

  Scenario: update a costume image
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    And I am on "/costume/update/image/shgbvb35"
    When I fill the "update the costume image" form like:
      | costume-update-image |
      | kameha        |
    Then I Should see a notification "The costume image have been updated."

