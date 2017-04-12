Feature: requirement_6 Status Bar for Generating Word Cloud
	In order to visualized the current process in generating the word cloud
	As a user
	I need to be able to see a status bar for generating word cloud on the Word Cloud Page

	Scenario: Searching for a last name that does not have any papers in the IEEE and ACM libararies
		Given that the user searches
		Then a progress bar is shown