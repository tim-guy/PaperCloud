<?php

require_once "vendor/autoload.php";
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
	public $driver;
	public $session;
	
	public $page;

	public $artistSearchBar;
	public $artistSearchTextField;
    public $searchButton;

	/**
	* Initializes context.
	*
	* Every scenario gets its own context instance.
	* You can also pass arbitrary arguments to the
	* context constructor through behat.yml.
	*/
	public function __construct()
	{
		$this->driver = new \Behat\Mink\Driver\Selenium2Driver();
		$this->session = new \Behat\Mink\Session($this->driver);

		$this->session->start();

		$this->session->visit('http://localhost:80/LyricsCloud/');
		$this->page = $this->session->getPage();

		$this->artistSearchBar = $this->page->find("css", "#artistSearchBar");
		$this->artistSearchTextField = $this->artistSearchBar->find("css", "#artistSearchTextField");

        $this->searchButton = $this->page->find("css", "#search");
	}

	public function __destruct()
	{
		$this->session->stop();
	}

	/**
	* @Given X is set to 10 before searching
	*/
	public function XSetTo10BeforeSearching()
	{

	}

	/**
	* @Then number of items in the word cloud is 10
	*/
	public function numberItemsInWordCloud10()
	{

	}

	/**
	* @Given that the user searches for a valid last name
	*/
	public function searchForValidLastName()
	{

	}

	/**
	* @Then the appropriate top papers in the ACM and IEEE libraries are shown in the word cloud
	*/
	public function topPapersShownInWordCloud()
	{

	}

	/**
	* @And there are no papers in the word cloud that do not belong to a user with that last name
	*/
	public function allPapersInWordCloudBelongToThatLastName()
	{

	}

	/**
	* @Given that the user searches for an invalid last name
	*/
	public function searchForInvalidLastName()
	{

	}

	/**
	* @Then a label is shown where the word cloud would be that there are no papers for this user
	*/
	public function errosMessageLabelShown()
	{

	}

}