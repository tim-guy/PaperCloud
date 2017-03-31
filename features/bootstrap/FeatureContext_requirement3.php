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

    // added for requirement_3 black-box testing
    public $paperListPage;
    public $paperListTable;
    public $titleColmunHeader;
    public $authorColumnHeader;
    public $conferenceColumnHeader;
    public $frequencyColumnHeader;
    public $tableData;

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

        // added for requirement_3 black-box testing
       	$this->paperListPage; // TODO
       	$this->paperListTable = $this->paperListPage->find("css", "#paperList");
       	$this->titleColmunHeader = $this->paperListPage->find("css", "#titleColmunHeader");
       	$this->authorColumnHeader = $this->paperListPage->find("css", "#authorColumnHeader");
       	$this->conferenceColumnHeader = $this->paperListPage->find("css", "#conferenceColumnHeader");
       	$this->frequencyColumnHeader = $this->paperListPage->find("css", "#frequencyColumnHeader");
	}

	public function __destruct()
	{
		$this->session->stop();
	}

	/**
	* @Given the Paper Cloud is generated
	*/
	public function thePaperCloudGenerated()
	{

	}

	/**
	* @When a word in the Paper Cloud is clicked
	*/
	public function wordInThePaperCloudClicked()
	{

	}

	/**
	* @Then the paper list is displayed, and ranked by the word frequency
	*/
	public function paperListDisplayedAndRankedByWordFrequency()
	{

	}

	/**
	* @Given the paper list is generated
	*/
	public function thePaperListGenerated()
	{

	}

	/**
	* @When the "Title" column header is clicked
	*/
	public function titleColumnHeaderClicked()
	{
		$this->titleColmunHeader->click();
	}

	/**
	* @Then the paper list is sorted in the ascending order of the "Title" column
	*/
	public function paperListsortInAscendingOrderOfTitleColumn()
	{
		
	}

	/**
	* @Given the paper list is generated
	*/
	public function thePaperListGenerated()
	{

	}

	/**
	* @When the "Author" column header is clicked
	*/
	public function authorColumnHeaderClicked()
	{

	}

	/**
	* @Then the paper list is sorted in the ascending order of the "Author" column
	*/
	public function paperListsortInAscendingOrderOfAuthorColumn()
	{

	}

	/**
	* @Given the paper list is generated
	*/
	public function thePaperListGenerated()
	{

	}

	/**
	* @When the "Conference" column header is clicked
	*/
	public function conferenceColumnHeaderClicked()
	{

	}

	/**
	* @Then the paper list is sorted in the ascending order of the "Conference" column
	*/
	public function paperListsortInAscendingOrderOfConferenceColumn()
	{

	}

	/**
	* @Given the paper list is generated
	*/
	public function thePaperListGenerated()
	{

	}

	/**
	* @When the "Frequency" column header is clicked
	*/
	public function frequencyColumnHeaderClicked()
	{

	}

	/**
	* @Then the paper list is sorted in the descending order of the "Frequency" column
	*/
	public function paperListsortInDescendingOrderOfFrequencyColumn()
	{

	}
	
}	