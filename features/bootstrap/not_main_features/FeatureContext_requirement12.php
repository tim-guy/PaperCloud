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
	* @Given the paper list is generated for checking each paper selectable
	*/
	public function givenPaperListGeneratedForCheckingEachPaperSelectable()
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
	* @When the "Search Selected Subset" button is clicked
	*/
	public function whenSearchSelectedSubsetButtonClicked()
	{
		$this->page = $this->session->getPage();
		$listDownloadLinks = $this->page->find("css", "#listDownloadLinks");
		$subsetLink = $listDownloadLinks->find("css", "#subsetLink");
		$subsetLink->click();
		sleep(1);
	}

	/**
	* @Then each paper is selectable on the Paper List Page
	*/
	public function thenEachPaperSelectableOnPaperListPage()
	{
		$this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $rows = $this->paperListTable->findAll("css", "#row");
        $firstRowData = $rows[0]->findAll("css", "td");
        $firstSubsetCheckbox = $firstRowData[0]->find("css", "input");

        assertEquals("subsetCheckbox", $firstSubsetCheckbox->getAttribute('class'));
	}

	/**
	* @Given the paper list is generated for selecting papers
	*/
	public function givenPaperListGeneratedForSelectingPapers()
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
	* @When the first paper is selected
	*/
	public function whenFirstPaperSelected()
	{
		$this->page = $this->session->getPage();
		$listDownloadLinks = $this->page->find("css", "#listDownloadLinks");
		$subsetLink = $listDownloadLinks->find("css", "#subsetLink");
		$subsetLink->click();
		sleep(1);

		$this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $rows = $this->paperListTable->findAll("css", "#row");
        $firstRowData = $rows[0]->findAll("css", "td");
        $firstSubsetCheckbox = $firstRowData[0]->find("css", "input");
        $firstSubsetCheckbox->click();
        $subsetLink->click();
		sleep(5);
	}

	/**
	* @Then a new Paper Cloud is generated
	*/
	public function thenNewPaperCloudGenerated()
	{
		assertNotEquals(null, $this->page->find("css", "#wordCloudPage"));
	}
	
}

?>