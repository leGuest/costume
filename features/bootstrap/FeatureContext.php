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
  public function __construct()
  {
    $this->client = new Client();
    $this->baseURL = "http://127.0.0.1/costumes/web";
  }

  /**
   * @When /^I am on "([^"]*)"$/
   */
  public function iAmOn($arg1)
  {
    $this->crawler = $this->client ->request("GET", $this->baseURL . $arg1);
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
   * @Then /^I should redirect to "([^"]*)"$/
   */
  public function iShouldRedirectTo($arg1)
  {
    throw new PendingException();
  }

  /**
   * @When /^I fill the "([^"]*)" input$/
   */
  public function iFillTheInput($arg1)
  {
    throw new PendingException();
  }

  /**
   * @Given /^I push the "([^"]*)" button$/
   */
  public function iPushTheButton($arg1)
  {
    throw new PendingException();
  }

  /**
   * @Then /^I Should see a notification$/
   */
  public function iShouldSeeANotification()
  {
    throw new PendingException();
  }
}
