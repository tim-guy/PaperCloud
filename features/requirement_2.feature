Feature: requirement_2
	In order to view the papers that are associated with a specific last name
	As a user
	I need to be able to generate a word cloud of the names of papers when I search for a last name
		
	Scenario: Searching for a specific last name that does have corresponding papers in IEEE and ACM libraries
		Given that the user searches for a valid last name
		Then the appropriate top papers in the ACM and IEEE libraries are shown in the word cloud

	Scenario: Searching for a last name that does not have any papers in the IEEE and ACM libararies
		Given that the user searches for an invalid last name
		Then a label is shown where the word cloud would be that there are no papers for this user

	Scenario: Changing the number of papers, X, to be shown before searching returns a word cloud with exactly that many papers
		Given X is set to 10 before searching
		Then number of papers in the word cloud is 10