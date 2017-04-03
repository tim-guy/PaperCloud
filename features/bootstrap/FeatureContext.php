<?php

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

        // added for requirement_1 black-box testing, reference: searchPage
        $this->searchBar = $this->page->find("css", "#searchBar");
        $this->searchField = $this->searchBar->find("css", "#searchTextField");
        $this->sizeField = $this->searchBar->find("css", "#limitTextField");
        $this->searchButton = $this->page->find("css", "#search");

        // added for requirement_3 black-box testing, reference: paperListPage
        //$this->paperListPage = $this->page->find("css", "#paperListPage");
        //$this->paperListTable = $this->page->find("css", "#paperList");
        //$this->titleColmunHeader = $this->paperListTable->find("css", "#titleColmunHeader");
        //$this->authorColumnHeader = $this->paperListTable->find("css", "#authorColumnHeader");
        //$this->conferenceColumnHeader = $this->paperListTable->find("css", "#conferenceColumnHeader");
        //$this->frequencyColumnHeader = $this->paperListTable->find("css", "#frequencyColumnHeader");
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
        assertNotEquals(null, $this->searchButton->getAttribute('disabled'));
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
        assertEquals(null, $this->searchButton->getAttribute('disabled'));
    }

    /**
     * @Given X is set to :arg1 before searching
     */
    public function xIsSetToBeforeSearching($arg1)
    {
        $this->sizeField.setValue($arg1);
        $this->searchField.setValue('Johnson');
        $this->searchButton.click();
        sleep(5);
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
        $this->sizeField.setValue('10');
        $this->searchField.setValue('Johnson');
        $this->searchButton.click();
    }

    /**
     * @Then the appropriate top papers in the ACM and IEEE libraries are shown in the word cloud
     */
    public function theAppropriateTopPapersInTheAcmAndIeeeLibrariesAreShownInTheWordCloud()
    {
        throw new PendingException();
    }

    /**
     * @Then there are no papers in the word cloud that do not belong to a user with that last name
     */
    public function thereAreNoPapersInTheWordCloudThatDoNotBelongToAUserWithThatLastName()
    {
        throw new PendingException();
    }

    /**
     * @Given that the user searches for an invalid last name
     */
    public function thatTheUserSearchesForAnInvalidLastName()
    {
        $this->sizeField.setValue('10');
        $this->searchField.setValue('Banananana');
        $this->searchButton.click();
    }

    /**
     * @Then a label is shown where the word cloud would be that there are no papers for this user
     */
    public function aLabelIsShownWhereTheWordCloudWouldBeThatThereAreNoPapersForThisUser()
    {
        throw new PendingException();
    }

    /**
     * @Given the Paper Cloud is generated
     */
    public function thePaperCloudIsGenerated()
    {
        throw new PendingException();
    }

    /**
     * @When a word in the Paper Cloud is clicked
     */
    public function aWordInThePaperCloudIsClicked()
    {
        throw new PendingException();
    }

    /**
     * @Then the paper list is displayed
     */
    public function thePaperListIsDisplayed()
    {
        throw new PendingException();
    }

    /**
     * @Given the paper list is generated
     */
    public function thePaperListIsGenerated()
    {
        throw new PendingException();
    }

    /**
     * @When the :arg1 column header is clicked
     */
    public function theColumnHeaderIsClicked($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the paper list is sorted in the ascending order of the :arg1 column
     */
    public function thePaperListIsSortedInTheAscendingOrderOfTheColumn($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the paper list is is sorted in the descending order of the :arg1 column
     */
    public function thePaperListIsIsSortedInTheDescendingOrderOfTheColumn($arg1)
    {
        throw new PendingException();
    }
}
