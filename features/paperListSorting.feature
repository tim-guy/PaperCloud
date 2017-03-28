Feature: Paper List Sorting
	In order to view the paper list sorted in a specified order 
	As a user
	I nees to be able to sort the table by clicking on the first four column headers

	Scenario: Observing an generated paper list ranked by descending word frequency
		Given the "Title" column header is clicked
		Then the paper list is sorted in the A-Z order of the "Title" column

	Scenario: Observing an generated paper list ranked by descending word frequency
		Given the "Author" column header is clicked
		Then the paper list is sorted in the A-Z order of the "Author" column

	Scenario: Observing an generated paper list ranked by descending word frequency
		Given the "Conference" column header is clicked
		Then the paper list is sorted in the A-Z order of the "Conference" column

	Scenario: Observing an generated paper list not ranked by descending word frequency
		Given the "Frequency" column header is clicked
		Then the paper list is ranked by descending word frequency