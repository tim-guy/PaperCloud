Feature: requirement_10 Export Paper List
	In order to export the paper list as PDFs and plain text
	As a user
	I need to be able to click the Export button

	Scenario: exporting the paper list as PDFs
		Given the paper list is generated for exporting as PDFs
		Then the "Download this list as a PDF" button is clickable

	Scenario: exporting he paper list as plain text
		Given the paper list is generated for exporting as plain text
		Then the "Download this list as a text file" button is clickable