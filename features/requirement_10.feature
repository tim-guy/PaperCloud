Feature: requirement_10 Export Paper List
	In order to export the paper list as PDFs and plain text
	As a user
	I need to be able to click the Export button

	Scenario: exporting the paper list as PDFs
		Given the paper list is generated for exporting as PDFs
		When the "Export as PDF" button is clicked
		Then the paper is exported as PDF

	Scenario: exporting he paper list as plain text
		Given the paper list is generated for exporting as plain text
		When the "Export as Plain Text" button is clicked
		Then the paper is exported as plain text