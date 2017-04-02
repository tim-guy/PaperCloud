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
	* @Given that the user opens the webpage with a web browser
	*/
	public function thereIsAnArtistSearchBar()
	{
		assertNotEquals(null, $this->artistSearchBar);
	}
	/**
	* @When the artist search bar should be empty
	*/
	public function theArtistSearchBarShouldBeEmpty()
	{
		assertEquals("", $this->artistSearchTextField->getValue());
	}
	/**
	* @Then the search button is not clickable
	*/
	public function theSearchButtonIsNotClickable()
    {
        assertNotEquals(null, $this->searchButton->getAttribute('disabled'));
    }
	/**
    * @Given there are three characters in the textbox
    */
    public function thereAreMoreThanThreeCharactersInTheTextbox()
    {
    	$this->artistSearchTextField->setValue('Leo');
        sleep(3);
    }
    /**
     * @Then the search button is clickable
     */
    public function theSearchButtonIsClickable()
    {
        assertEquals(null, $this->searchButton->getAttribute('disabled'));
    }
}