Feature: requirement_14 Keyword Phrase Search
	In order to do keyword phrase search
	As a user
	I need to be able to add a second search functionality other than "Author Name"

	Scenario: checking keyword phrase search option
		Given the search page is opened for checking keyword phrase search option
		Then keyword phrase search option is selectable

	Scenario: searching for keyword phrase "data structure"
		Given the search page is opened for searching for keyword phrase "data structure"
		When search for keyword phrase "data structure"
		Then the word cloud is displayed for keyword phrase "data structure"