Feature: requirement_6 Clicking Author
	In order to do a new search
	As a user
	I need to be able to click on an author in the "Author" list from the paper list and it turns to be a list based on that author

	Scenario:
		Given the paper list is already generated
		When an author is clicked
		Then the paper list is based on that given author