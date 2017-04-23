<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/IEEELibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class IEEELibraryAdapterTest extends TestCase
{
	public function testValidsearchPapers()
	{
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->searchPapers("name", "Johnson", false, 10);

		$this->assertLessThanOrEqual(10, sizeof($ieeePapers));

		foreach ($ieeePapers as $paper) {
			$this->assertContains("Johnson", $paper['authors']);
		}

	}

	public function testValidGetPapersWithExactAuthorName()
	{
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->searchPapers("name", "Barry Boehm", true, 10);

		$this->assertLessThanOrEqual(10, sizeof($ieeePapers));

		foreach ($ieeePapers as $paper) {
			$this->assertContains("Barry Boehm", $paper['authors']);
		}

	}

	

	public function testInvalidsearchPapers()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidsearchPapersOutput.json";
		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->searchPapers("name", "Banananana", false, 10);

		$ieeePapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ieeePapersExpected, $ieeePapers);
	}

	public function testValidGetPapersWithExactConferenceName()
	{
		$name = '2011 26th IEEE/ACM International Conference on Automated Software Engineering (ASE 2011)';

		$ieee = new IEEELibraryAdapter();
		$ieeePapers = $ieee->searchPapers("publication", $name, true, 10);

		$this->assertLessThanOrEqual(10, sizeof($ieeePapers));

		foreach ($ieeePapers as $paper) {
			$this->assertContains($name, $paper['publication']);
		}
	}

	public function testGetPaperBibtex()
	{
		$paper = array(
			"id" => "10.1109/ICSE.2015.32"
		);

		$ieee = new IEEELibraryAdapter();
		$bibtex = $ieee->getBibtexForPaper($paper);
		
		$expected = "@inproceedings{Gui_2015, doi = {10.1109/icse.2015.32}, url = {https://doi.org/10.1109%2Ficse.2015.32}, year = 2015, month = {may}, publisher = {{IEEE}}, author = {Jiaping Gui and Stuart Mcilroy and Meiyappan Nagappan and William G. J. Halfond}, title = {Truth in Advertising: The Hidden Cost of Mobile Ads for Software Developers}, booktitle = {2015 {IEEE}/{ACM} 37th {IEEE} International Conference on Software Engineering} }";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $bibtex));
	}

	public function testGetPaperAbstract()
	{
		$paper = array(
			"abstract" => "MY ABSTRACT"
		);

		$ieee = new IEEELibraryAdapter();
		$abstract = $ieee->getAbstractForPaper($paper);
		
		$this->assertContains("MY ABSTRACT", $abstract);
	}
}
