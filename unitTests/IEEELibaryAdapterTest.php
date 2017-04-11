<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/IEEELibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class IEEELibraryAdapterTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->getPapersWithAuthorName("name", "Johnson", false, 10);

		$this->assertEquals(10, sizeof($ieeePapers));

		foreach ($ieeePapers as $paper) {
			$this->assertContains("Johnson", $paper['authors']);
		}

	}

	public function testValidGetPapersWithExactAuthorName()
	{
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->getPapersWithAuthorName("name", "Barry Boehm", true, 10);

		$this->assertLessThanOrEqual(10, sizeof($ieeePapers));

		foreach ($ieeePapers as $paper) {
			$this->assertContains("Barry Boehm", $paper['authors']);
		}

	}

	

	public function testInvalidGetPapersWithAuthorName()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidGetPapersWithAuthorNameOutput.json";
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->getPapersWithAuthorName("name", "Banananana", false, 10);

		$ieeePapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ieeePapersExpected, $ieeePapers);
	}
}
