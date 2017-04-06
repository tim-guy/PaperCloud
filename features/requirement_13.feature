Feature: requirement_13 Download Word Cloud Image
	In order to download an image of the generateed word cloud
	As a user
	I need to be able to click the Download button on the World Cloud Page

	Scenario: existing a Download button on the Word Cloud Page
		Given the word cloud is generated for checking the Download button
		Then a Download button exists on the Word Cloud Page

	Scenario: clicking the Download button on the Word Cloud Page
		Given the word cloud is generated for clicking the Download button
		Then 