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
    And I Should see a "transaction list" link that should go to "/transaction"

  Scenario: transaction list
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    Then I should see "table" like:
      | costume     | tokens | tipper | status  | actions            |
      | Sailor Moon | 100    | John   | pending | approve disapprove |

  Scenario: approve a transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    And I click on the "approve" link
    Then I should see "table" like:
      | costume     | tokens | tipper | status     | actions            |
      | Sailor Moon | 100    | John   | approved   | approve disapprove |
      | Sailor Moon | 200    | John   | pending    | approve disapprove |
      | Sailor Moon | 250    | James  | pending    | approve disapprove |

  Scenario: disapprove a transaction
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/transaction"
    And I click on the "2" "disapprove" link
    Then I should see "table" like:
      | costume     | tokens | tipper | status        | actions            |
      | Sailor Moon | 100    | John   | approved      | approve disapprove |
      | Sailor Moon | 200    | John   | denied        | approve disapprove |
      | Sailor Moon | 250    | James  | pending       | approve disapprove |

  Scenario: approve a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "approve" link
    Then I should see "table" like:
      | name        | preview  | tokens | status    | actions   | admin              |
      | Sailor Moon | no image | 100    | published | add a tip | unpublish          |

  Scenario: disapprove a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "costume--disapprove" link of id "/costume/disapprove/3ef6990e" marked as "disapprove"
    Then I should see "table" like:
      | name        | preview  | tokens | status    | actions     | admin     |
      | Sailor Moon | no image | 100    | published | add a tip   | unpublish |
      | Hulk        | no image | 100    | pending   | add a tip   | no action |

  Scenario: Unpublish a costume
    Given I am on "/account/login"
    And I fill the "login" form like:
      | login-name  | login-password |
      | admin       | admin123       |
    When I am on "/"
    And I click on the "unpublish" link
    Then I should see "table" like:
      | name        | preview  | tokens | status    | actions   | admin              |
      | Sailor Moon | no image | 100    | pending   | add a tip | approve disapprove |

