Feature: requirement_8 Clicking Conference
	In order to view all the paper from the same conference
	As a user
	I need to be able to click on a conference in the "Conference" list from the paper list and it displays a new word cloud based on that conference

	Scenario:
		Given the paper list is already generated for clicking conference
		When a conference is clicked
		Then a new word cloud is displayed based on that conference
