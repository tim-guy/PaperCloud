Feature: requirement_3 Paper List Sorting
	In order to view the paper list sorted in a specified order 
	As a user
	I need to be able to sort the table by clicking on the first four column headers

	Scenario: Clicking on a word in the Paper Cloud return a list of papers that mention that word
		Given the Paper Cloud is generated
		When a word in the Paper Cloud is clicked
		Then the paper list is displayed

	Scenario: Sorting the paper list in ascending order of the "Title" Column
		Given the paper list is generated
		When the "Title" column header is clicked
		Then the paper list is sorted in the ascending order of the "Title" column

	Scenario: Sorting the paper list in ascending order of the "Author" Column
		Given the paper list is generated (1)
		When the "Author" column header is clicked
		Then the paper list is sorted in the ascending order of the "Author" column

	Scenario: Sorting the paper list in ascending order of the "Conference" Column
		Given the paper list is generated (2)
		When the "Conference" column header is clicked
		Then the paper list is sorted in the ascending order of the "Conference" column

	Scenario: Sorting the paper list in ascending order of the "Frequency" Column
		Given the paper list is generated (3)
		When the "Frequency" column header is clicked
		Then the paper list is is sorted in the ascending order of the "Frequency" column