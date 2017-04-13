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

	// added for requirement_1 black-box testing
    public $searchBar;
    public $searchField;
    public $sizeField;
    public $searchButton;
    public $wordCloud;
    public $g;
    public $words;

    // added for requirement_3 black-box testing
    //public $paperListPage;
    public $paperListTable;
    public $titleColmunHeader;
    public $authorColumnHeader;
    public $conferenceColumnHeader;
    public $frequencyColumnHeader;

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

        $this->session->visit('http://localhost:80/PaperCloud');
        $this->page = $this->session->getPage();

       	// added for requirement_1 black-box testing, reference: searchPage.html
        $this->searchBar = $this->page->find("css", "#searchBar");
        $this->searchField = $this->page->find("css", "#searchTextField");
        $this->sizeField = $this->page->find("css", "#limitTextField");
        $this->searchButton = $this->page->find("css", "#search");

        // added for requirement_3 black-box testing, reference: paperListPage.html
        // $this->paperListPage = $this->page->find("css", "#paperListPage");
        // $this->paperListTable = $this->page->find("css", "#paperList");
        // $this->titleColmunHeader = $this->paperListTable->find("css", "#titleColumnHeader");
        // $this->authorColumnHeader = $this->paperListTable->find("css", "#authorColumnHeader");
        // $this->conferenceColumnHeader = $this->paperListTable->find("css", "#conferenceColumnHeader");
        // $this->frequencyColumnHeader = $this->paperListTable->find("css", "#frequencyColumnHeader");
	}

	public function __destruct()
	{
		$this->session->stop();
	}

	/**
	* @Given the paper list is already generated for clicking conference
	*/
	public function givenPaperListGeneratedForClickingConference()
	{
		$this->sizeField->setValue('10');
        $this->searchField->setValue('Halfond');
        $this->searchButton->click();
        sleep(10);

        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(3);
	}

	/**
	* @When a conference is clicked
	*/
	public function whenConferenceClicked()
	{
		
	}

	/**
	* @Then a new word cloud is displayed based on that conference
	*/
	public function thenNewWordCloudDisplayedBasedOnThatConference()
	{
		
	}
	
}

?>