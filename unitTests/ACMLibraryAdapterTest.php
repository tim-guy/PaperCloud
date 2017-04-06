<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/ACMLibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class ACMLibraryAdapterTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		//$expectedOutputFileName = "unitTests/expected_output/testValidACMGetPapersWithAuthorNameOutput.json";
		$ACM = new ACMLibraryAdapter();
		$acmPapers = $ACM->getPapersWithAuthorName("Johnson", "10");

		//$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals(10, sizeof($acmPapers));
		//$this->assertEquals($ACMPapersExpected, $ACMPapers);

		foreach ($acmPapers as $paper) {
			$this->assertContains("Johnson", $paper['authors']);
		}
	}

	public function testInvalidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidACMGetPapersWithAuthorNameOutput.json";
		$ACM = new ACMLibraryAdapter();
		$ACMPapers = $ACM->getPapersWithAuthorName("Banananana", "10");

		$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ACMPapersExpected, $ACMPapers);
	}
}
