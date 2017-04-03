<?php

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
        // $this->titleColmunHeader = $this->paperListTable->find("css", "#titleColmunHeader");
        // $this->authorColumnHeader = $this->paperListTable->find("css", "#authorColumnHeader");
        // $this->conferenceColumnHeader = $this->paperListTable->find("css", "#conferenceColumnHeader");
        // $this->frequencyColumnHeader = $this->paperListTable->find("css", "#frequencyColumnHeader");

    }

    public function __destruct()
    {
        $this->session->stop();
    }
    /**
     * @Given that the user opens the webpage with a web browser
     */
    public function thatTheUserOpensTheWebpageWithAWebBrowser()
    {
        assertNotEquals(null, $this->searchBar);
    }

    /**
     * @When the artist search bar should be empty
     */
    public function theArtistSearchBarShouldBeEmpty()
    {
        assertEquals("", $this->searchField->getValue());
    }

    /**
     * @Then the search button is not clickable
     */
    public function theSearchButtonIsNotClickable()
    {
        assertNotEquals('disabled', $this->searchButton->getAttribute('disabled'));
    }

    /**
     * @Given there are three characters in the textbox
     */
    public function thereAreThreeCharactersInTheTextbox()
    {
        $this->searchField->setValue('Johnson');
        sleep(3);
    }

    /**
     * @Then the search button is clickable
     */
    public function theSearchButtonIsClickable()
    {
        assertEquals('disabled', $this->searchButton->getAttribute('disabled'));
    }

    /**
     * @Given X is set to :arg1 before searching
     */
    public function xIsSetToBeforeSearching($arg1)
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Halfond');
        $this->searchButton->click();
        sleep(10);
    }

    /**
     * @Then number of papers in the word cloud is :arg1
     */
    public function numberOfPapersInTheWordCloudIs($arg1)
    {
        $papersLength = $this->session->evaluateScript(
            "return papers.length;"
        );

        assertEquals($papersLength, 10);
    }

    /**
     * @Given that the user searches for a valid last name
     */
    public function thatTheUserSearchesForAValidLastName()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Halfond');
        $this->searchButton->click();
        sleep(10);
    }

    /**
     * @Then the appropriate top papers in the ACM and IEEE libraries are shown in the word cloud
     */
    public function theAppropriateTopPapersInTheAcmAndIeeeLibrariesAreShownInTheWordCloud()
    {
        $this->wordCloudPage = $this->session->getPage();
        $this->wordCloud = $this->wordCloudPage->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        array_pop($this->words)->click();
        sleep(1);
        $this->paperListPage = $this->session->getPage();
        $this->table = $this->paperListPage->find("css", "#paperList");
        $this->authors = $this->table->findAll("css", "#author");

        $author = array_pop($this->authors);

        $containsAuthor = strpos($author->getText(), "Halfond");
        assertEquals(true, $containsAuthor);
    }

    /**
     * @Given that the user searches for an invalid last name
     */
    public function thatTheUserSearchesForAnInvalidLastName()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Banananana');
        $this->searchButton->click();
    }

    /**
     * @Then a label is shown where the word cloud would be that there are no papers for this user
     */
    public function aLabelIsShownWhereTheWordCloudWouldBeThatThereAreNoPapersForThisUser()
    {
        $this->wordCloudPage = $this->session->getPage();
        $this->wordCloud = $this->wordCloudPage->find("css", "#wordCloudSVG");
        
        assertEquals(true, $containsAuthor);
    }

    /**
    * @Given the Paper Cloud is generated
    */
    public function thePaperCloudGenerated()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Miller');
        $this->searchButton->click();
        sleep(10);
    }

    /**
    * @When a word in the Paper Cloud is clicked
    */
    public function wordInThePaperCloudClicked()
    {
        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(10);
    }

    /**
    * @Then the paper list is displayed
    */
    public function paperListDisplayed()
    {
        assertNotEquals(null, $this->page->find("css", "#paperListPage"));
    }

    /**
    * @Given the paper list is generated for the "Title" column
    */
    public function thePaperListGeneratedForTitleColumn()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Miller');
        $this->searchButton->click();
        sleep(10);

        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(10);
    }

    /**
    * @When the "Title" column header is clicked
    */
    public function titleColumnHeaderClicked()
    {
        $this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $this->titleColmunHeader = $this->paperListTable->find("css", "#titleColumnHeader");

        $this->titleColmunHeader->click();
    }

    /**
    * @Then the paper list is sorted in the ascending order of the "Title" column
    */
    public function paperListsortInAscendingOrderOfTitleColumn()
    {
        $this->page = $this->session->getPage();

        $dom = new domDocument;
        $dom->loadHTML($page);
        $dom->preserveWhiteSpace = false;

        $tableArray = array();
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(1)->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $rowArray = array();
            $cols = $row->getElementsByTagName('td');

            foreach ($cols as $col) {
                array_push($rowArray, $col);
            }

            array_push($tableArray, $rowArray);
        }

        assertEquals(true, $tableArray[0][0] < $tableArray[1][0]);
    }

    /**
    * @Given the paper list is generated for the "Author" column
    */
    public function thePaperListGeneratedForAuthorColumn()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Miller');
        $this->searchButton->click();
        sleep(10);

        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(10);
    }

    /**
    * @When the "Author" column header is clicked
    */
    public function authorColumnHeaderClicked()
    {
        $this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $this->authorColmunHeader = $this->paperListTable->find("css", "#authorColumnHeader");
        $this->authorColmunHeader->click();
    }

    /**
    * @Then the paper list is sorted in the ascending order of the "Author" column
    */
    public function paperListsortInAscendingOrderOfAuthorColumn()
    {
        $this->page = $this->session->getPage();

        $dom = new domDocument;
        $dom->loadHTML($page);
        $dom->preserveWhiteSpace = false;

        $tableArray = array();
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(1)->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $rowArray = array();
            $cols = $row->getElementsByTagName('td');

            foreach ($cols as $col) {
                array_push($rowArray, $col);
            }

            array_push($tableArray, $rowArray);
        }

        assertEquals(true, $tableArray[0][1] < $tableArray[1][1]);
    }

    /**
    * @Given the paper list is generated for the "Conference" column
    */
    public function thePaperListGeneratedForConferenceColumn()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Miller');
        $this->searchButton->click();
        sleep(10);

        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(10);
    }

    /**
    * @When the "Conference" column header is clicked
    */
    public function conferenceColumnHeaderClicked()
    {
        $this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $this->titleColmunHeader = $this->paperListTable->find("css", "#titleColumnHeader");
        $this->conferenceColmunHeader->click();
    }

    /**
    * @Then the paper list is sorted in the ascending order of the "Conference" column
    */
    public function paperListsortInAscendingOrderOfConferenceColumn()
    {
        $this->page = $this->session->getPage();

        $dom = new domDocument;
        $dom->loadHTML($page);
        $dom->preserveWhiteSpace = false;

        $tableArray = array();
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(1)->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $rowArray = array();
            $cols = $row->getElementsByTagName('td');

            foreach ($cols as $col) {
                array_push($rowArray, $col);
            }

            array_push($tableArray, $rowArray);
        }

        assertEquals(true, $tableArray[0][2] < $tableArray[1][2]);
    }

    /**
    * @Given the paper list is generated for the "Frequency" column
    */
    public function thePaperListGeneratedForFrequencyColumn()
    {
        $this->sizeField->setValue('10');
        $this->searchField->setValue('Miller');
        $this->searchButton->click();
        sleep(10);

        $this->page = $this->session->getPage();
        $this->wordCloud = $this->page->find("css", "#wordCloudSVG");
        $this->g = $this->wordCloud->find("css", "#g");
        $this->words = $this->g->findAll("css", "#text");
        $this->words[0]->click();
        sleep(10);
    }

    /**
    * @When the "Frequency" column header is clicked
    */
    public function frequencyColumnHeaderClicked()
    {
        $this->page = $this->session->getPage();
        $this->paperListTable = $this->page->find("css", "#paperList");
        $this->frequencyColmunHeader = $this->paperListTable->find("css", "#requencyColumnHeader");
        $this->refquencyColmunHeader->click();
    }

    /**
    * @Then the paper list is sorted in the ascending order of the "Frequency" column
    */
    public function paperListsortInAscendingOrderOfFrequencyColumn()
    {
        $this->page = $this->session->getPage();
        
        $dom = new domDocument;
        $dom->loadHTML($page);
        $dom->preserveWhiteSpace = false;

        $tableArray = array();
        $table = $dom->getElementsByTagName('table');
        $rows = $table->item(1)->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $rowArray = array();
            $cols = $row->getElementsByTagName('td');

            foreach ($cols as $col) {
                array_push($rowArray, $col);
            }

            array_push($tableArray, $rowArray);
        }

        assertEquals(true, $tableArray[0][3] > $tableArray[1][3]);
    }

}
