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
   * @When /^I fill the "([^"]*)" form like:$/
   */
  public function iFillTheFormLike($arg1, TableNode $table)
  {
    $assertIsNotEmpty = true;
    foreach($table->getHash() as $row ) {
      $assertIsNotEmpty = !empty($row);
    }
    if (!$assertIsNotEmpty) {
      throw new BehaviorException("A field is empty");
    }
    $form = $this->crawler
      ->selectButton("$arg1")
      ->form($table->getHash()[0]);
    $this->crawler    = $this->client->submit($form);
  }
  /**
   * @Then /^I Should see a notification "([^"]*)"$/
   */
  public function iShouldSeeANotification($arg1)
  {
    $notification     = $this->crawler->filter("body > div.notification");
    if (trim($notification->text()) !== $arg1) {
      throw new BehaviorException("the notification have not been shown.
        Seen instead : ". trim($notification->text()));
    }
  }
  /**
   * @Then /^I should see "([^"]*)" like:$/
   */
  public function iShouldSeeLike($arg1, TableNode $table)
  {
    $tableDom     = $this->crawler->filter("body > " . $arg1)->children()->filter("td");
    $tempArr      = [];
    $counter      = 0;
    foreach($table->getHash()[0] as $val) {
      $tempArr[] = $val;
    }
    $tablehash = $tempArr;
    while($tableDom->eq($counter)->text() !== $tableDom->last()->text())
    {
      if (isset($tablehash[$counter])) {
        if (trim($tableDom->eq($counter)->text()) !== $tablehash[$counter]) {
            throw new BehaviorException("the row data " . $tableDom->eq($counter)->text() ." cannot be found.");
        }
      }
      $counter++;
    }
  }
}
