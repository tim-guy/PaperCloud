Feature: requirement_9 Clicking Title
	In order to view the abstract of the same paper with word(s) highlighted
	As a user
	I need to be able to click on a title in the "Title" list from the paper list

	Scenario:
		Given the paper list is already generated 
		When a paper's title is clicked
		Then the words in that paper's abstract are highlighted