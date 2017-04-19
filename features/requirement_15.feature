Feature: requirement_15 Download Highlighted Paper PDF
	In order to download save the paper with the keyword highlighted
	As a user
	I need to be able to download the paper as a PDF file

	Scenario: downloading the paper as PDF with the keyword highlighted
		Given the paper list is generated for downloading the paper
		When the "Download Paper" button is clicked
		Then the paper is downloaded with the keyword highlighted