Feature: Test my symfony project

  @javascript
Scenario: I'm looking for an article
Given I am on "/"
    And I follow "Recherche développpeur Symfony2"
    Then I should see "Lyon. Blabla…"
