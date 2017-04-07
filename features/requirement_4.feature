Feature: requirement_4 Full Text Link
	In order to view the actual text of each paper from the paper list 
	As a user
	I need to be able to see a download link for each paper in the paper list

	Scenario: each paper has a link for its full text
		Given the paper list is generated for the "Full Text" column
		Then the paper list contains a "Full Text" column
		Then each paper has a link for its full text