Feature: requirement_1 
	In order to be able to input a last name as search criteria
	As a user
	I need to be able to type in a author's last name when I click the search textfield

	Scenario: Openning the webpage with a web browser
		Given that the user opens the webpage with a web browser
		A textfield for search is shown near the search button

	Scenario: Clicking the search textfield
		Given that the user clicks at the search textfield
		The textfield becomes editable and input that the user types shows up in the textfield.