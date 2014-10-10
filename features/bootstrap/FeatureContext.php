<?php

use Behat\Behat\Context\ClosuredContextInterface,
Behat\Behat\Context\TranslatedContextInterface,
Behat\Behat\Context\BehatContext,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
  Behat\Gherkin\Node\TableNode;
use Behat\Behat\Exception\BehaviorException;
use Goutte\Client;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends BehatContext
{
  private $client;
  private $baseURL;
  private $crawler;
  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct(array $parameters)
  {
    $this->client = new Client();
    $this->baseURL = "http://127.0.0.1:8080/costumes/web";
    $this->useContext('TipContext', new TipContext($parameters));
  }

  /**
   * @When /^I am on "([^"]*)"$/
   */
  public function iAmOn($arg1)
  {
    $this->crawler = $this->client->request("GET", $this->baseURL . $arg1);
    $response = $this->client->getResponse()->getStatus() === "200";
    if (!$response) {
      throw new BehaviorException($arg1 . " did not respond with a 200 status");
    }
  }

  /**
   * @Then I should see a list of costumes
   */
  public function iShouldSeeAListOfCostumes()
  {
    $name = $this->crawler->filter("body > table > tr > td");
    $first = $name->first();
    if (!isset($first)) {
      throw new BehaviorException("No costume name to display");
    }
  }
  /**
   * @Given /^I Should see a "([^"]*)" link that should go to "([^"]*)"$/
   */
  public function iShouldSeeALinkThatShouldGoTo($arg1, $arg2)
  {
    $link = $this->crawler->selectLink($arg1)->link();
    if($link->getUri() !== $this->baseURL . $arg2) {
      throw new BehaviorException(
        "No link with content " . $arg1 . " and
        that redirects to " . $arg2 . " were found"
      );
    }
  }
  /**
   * @When /^I click on the "([^"]*)" link$/
   */
  public function iClickOnTheLink($arg1)
  {
    $link = $this->crawler->selectLink($arg1)->link();
    $this->crawler = $this->client->click($link);
  }
  /**
   * @Then /^I should be redirected to "([^"]*)"$/
   */
  public function iShouldBeRedirectedTo($arg1)
  {
    $this->crawler = $this->client ->request("GET", $this->baseURL . $arg1);
    $response = $this->client->getResponse()->getStatus() === "200";
    if (!$response) {
      throw new BehaviorException($this->baseURL . $arg1 . " did not respond with a 200 status");
    }
  }

  /**
   * @When /^I fill the form like:$/
   */
  public function iFillTheFormLike(TableNode $table)
  {
    $assertIsNotEmpty = true;
    $this->table = $table;
    foreach($table->getHash() as $row) {
      $assertIsNotEmpty = !empty($row["costume-name"]) ||
        !empty($row["costume-tokens"]) ||
        !empty($row["costume-tippername"])
        ;
    }
    if (!$assertIsNotEmpty) {
        return new BehaviorException("A field is empty");
    }
  }
  /**
   * @Then /^I Should see a notification$/
   */
  public function iShouldSeeANotification()
  {
    foreach($this->table->getHash() as $row) {
    $form = $this->crawler->selectButton("add a costume")
        ->form([
          "costume-name"        => $row["costume-name"],
          "costume-tokens"      => $row["costume-tokens"],
          "costume-tippername"  => $row["costume-tippername"]
        ]);
    }
    $this->crawler    = $this->client->submit($form);
    $notification     = $this->crawler->filter("body > div.notification");
    if (trim($notification->text()) !== "The costume have been added.") {
      throw new BehaviorException("the costume have not been added.");
    }
    if($notification->text() === "Could not create the costume. Please try again later.") {
      throw new BehaviorException("Nor the submit post have not been reached, or the sql query had an error");
    }
  }
}
