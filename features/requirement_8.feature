Feature: requirement_8 Clicking Conference
	In order to view all the paper from the same conference
	As a user
	I need to be able to click on a conference in the "Conference" list from the paper list and a list should be based on that conference 

	Scenario:
		Given the paper list is already generated 
		When a conference in the "Conference" list is clicked
		Then the paper list is based on that given conference
