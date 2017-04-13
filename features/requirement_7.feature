Feature: requirement_7 Clicking Author
	In order to do a new search
	As a user
	I need to be able to click on an author in the "Author" list from the paper list and it displays a new word cloud based on that author

	Scenario:
		Given the paper list is already generated for clicking author
		When an author is clicked
		Then a new word cloud is displayed based on that author