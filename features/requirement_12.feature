Feature: requirement_12 Subset Selection
	In order to generate a new word cloud from the exisitng paper list
	As a user
	I need to be able to select a subset from the existing paper list
	
	Scenario: each paper is selectable on the Paper List Page
		Given the paper list is generated for checking each paper selectable
		Then each paper is selectable on the Paper List Page

	Scenario: selecting papers to generate a new word cloud
		Given the paper list is generated for selecting papers
		When the first paper is selected
		Then a new Paper Cloud is generated