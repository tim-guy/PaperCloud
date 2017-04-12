Feature: requirement_11 Access Previous Search
	In order to access previously entered searches
	As a user
	I need to be able to see a list of previous search on the Search Page
	
	Scenario: exisitng a list of previous search
		Given the last search is "Redekopp"
		When the Search Page is reopened
		Then the list of previous search shows "Redekopp" on the top