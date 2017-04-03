<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/IEEELibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class IEEELibraryAdapterTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testValidGetPapersWithAuthorNameOutput.json";
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->getPapersWithAuthorName("Johnson", "10");

		$ieeePapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals(10, sizeof($ieeePapers));
		$this->assertEquals($ieeePapersExpected, $ieeePapers);

	}
	public function testInvalidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidGetPapersWithAuthorNameOutput.json";
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->getPapersWithAuthorName("Banananana", "10");

		$ieeePapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ieeePapersExpected, $ieeePapers);
	}
}
