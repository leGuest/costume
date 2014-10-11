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
class TipContext extends BehatContext
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
    $this->baseURL = "http://127.0.0.1:8080/costumes/web";
  }
  /**
   * @When /^I click on the "([^"]*)" link of hash id "([^"]*)"$/
   */
  public function iClickOnTheLinkOfHashId($arg1, $arg2)
  {
    $this->crawler = $this->client
      ->request("GET", $this->baseURL );
    $this->hash = $arg2;
    $this->crawler->filter("a")->each(function ($node, $i) {
      if (
        $node->text() === "add a tip" &&
        $node->link()->getUri() === $this->baseURL . "/costume/tip/" . $this->hash
      ) {
        $this->client->click($node->link());
      }
    });
  }
}
