Feature: requirement_11 Access Previous Search
	As a user
	I need to be able to access previously entered searches
	
	Scenario: exisitng a list of previous search
		Given the search page is opened to see previous search
		Then the list of previous search exists

	Scenario: showing the most recent search in the list of previous search
		Given the last search is "Redekopp"
		When the Search Page is reopened
		Then the list of previous search shows "Redekopp" on the top