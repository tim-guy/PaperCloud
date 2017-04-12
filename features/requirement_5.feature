Feature: requirement_5 Bibtext Link
	In order to view the bibtext for each paper from the paper list
	As a user
	I need to be able to see a bibtex link for each paper in the paper list

	Scenario: each paper has a link for its full text
		Given the paper list is generated for the "Bib Text" column
		Then the paper list contains a "Bib Text" column
		Then each paper has a link for its bib text