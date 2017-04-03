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
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given that the user opens the webpage with a web browser
     */
    public function thatTheUserOpensTheWebpageWithAWebBrowser()
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
    public function thereAreThreeCharactersInTheTextbox()
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

    /**
     * @Given X is set to :arg1 before searching
     */
    public function xIsSetToBeforeSearching($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then number of items in the word cloud is :arg1
     */
    public function numberOfItemsInTheWordCloudIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given that the user searches for a valid last name
     */
    public function thatTheUserSearchesForAValidLastName()
    {
        throw new PendingException();
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
        throw new PendingException();
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
     * @Then the paper list is displayed, and ranked by the word frequency
     */
    public function thePaperListIsDisplayedAndRankedByTheWordFrequency()
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
