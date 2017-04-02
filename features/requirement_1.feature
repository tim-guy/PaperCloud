Feature: requirement_1 
	In order to be able to input a last name as search criteria
	As a user
	I need to be able to type in a author's last name when I click the search textfield

	Scenario: Openning the webpage with a web browser
		Given that the user opens the webpage with a web browser
		When the artist search bar should be empty
		Then the search button is not clickable

	Scenario: Typing in the search textfield
		Given there are three characters in the textbox
		Then the search button is clickable