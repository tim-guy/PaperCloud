<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/queryPapers.php";

use PHPUnit\Framework\TestCase;

class queryPapersTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testValidACMGetPapersWithAuthorNameOutput.json";
		$ACM = new ACMLibraryAdapter();
		$ACMPapers = $ACM->getPapersWithAuthorName("Johnson", "10");

		$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals(10, sizeof($ACMPapers));
		$this->assertEquals($ACMPapersExpected, $ACMPapers);

	}

	public function testInvalidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidACMGetPapersWithAuthorNameOutput.json";
		$ACM = new ACMLibraryAdapter();
		$ACMPapers = $ACM->getPapersWithAuthorName("Banananana", "10");

		$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ACMPapersExpected, $ACMPapers);
	}	

	public function testMoreThan1kPapers()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidACMGetPapersWithAuthorNameOutput.json";
		$ACM = new ACMLibraryAdapter();
		$ACMPapers = $ACM->getPapersWithAuthorName("Johnson", "1000");

		$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals(1000, sizeof($ACMPapers));
	}
}
