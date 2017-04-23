<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/ACMLibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class ACMLibraryAdapterTest extends TestCase
{
	public function testValidsearchPapers()
	{
		//$expectedOutputFileName = "unitTests/expected_output/testValidACMsearchPapersOutput.json";
		$ACM = new ACMLibraryAdapter();
		$acmPapers = $ACM->searchPapers("name", "Johnson", false, "10");

		//$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals(10, sizeof($acmPapers));
		//$this->assertEquals($ACMPapersExpected, $ACMPapers);

		foreach ($acmPapers as $paper) {
			$this->assertContains("Johnson", $paper['authors']);
		}
	}

	public function testValidGetPapersWithExactAuthorName()
	{
		$acm = new ACMLibraryAdapter();
		$acmPapers = $acm->searchPapers("name", "Barry Boehm", true, 10);

		$this->assertLessThanOrEqual(10, sizeof($acmPapers));

		foreach ($acmPapers as $paper) {
			$this->assertContains("Barry Boehm", $paper['authors']);
		}

	}

	public function testInvalidsearchPapers()
	{
		$expectedOutputFileName = "unitTests/expected_output/testInvalidACMsearchPapersOutput.json";
		$ACM = new ACMLibraryAdapter();
		$ACMPapers = $ACM->searchPapers("name", "Banananana", false, "10");

		$ACMPapersExpected = json_decode(file_get_contents($expectedOutputFileName), true);
		$this->assertEquals($ACMPapersExpected, $ACMPapers);
	}

	public function testValidGetPapersWithExactConferenceName()
	{
		$name = 'Proceedings of the 2013 International Symposium on Software Testing and Analysis';

		$acm = new ACMLibraryAdapter();
		$papers = $acm->searchPapers("publication", $name, true, 10);

		$this->assertLessThanOrEqual(10, sizeof($papers));

		foreach ($papers as $paper) {
			$this->assertContains($name, $paper['publication']);
		}
	}

	public function testGetPaperBibtex()
	{
		$paper = array(
			"id" => "2492397"
		);

		$acm = new ACMLibraryAdapter();
		$bibtex = $acm->getBibtexForPaper($paper);
		
		$expected = "@inproceedings{Buda:2013:GTD:2483760.2492397, author = {Buda, Teodora Sandra}, title = {Generation of Test Databases Using Sampling Methods}, booktitle = {Proceedings of the 2013 International Symposium on Software Testing and Analysis}, series = {ISSTA 2013}, year = {2013}, isbn = {978-1-4503-2159-4}, location = {Lugano, Switzerland}, pages = {366--369}, numpages = {4}, url = {http://doi.acm.org/10.1145/2483760.2492397}, doi = {10.1145/2483760.2492397}, acmid = {2492397}, publisher = {ACM}, address = {New York, NY, USA}, keywords = {Database sampling, relational database, testing}, }";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $bibtex));
	}

	public function testGetPaperAbstract()
	{
		$paper = array(
			"id" => "2492397"
		);

		$acm = new ACMLibraryAdapter();
		$abstract = $acm->getAbstractForPaper($paper);
		
		$expected = "Populating the testing environment with relevant data represents a great challenge in software validation, generally requiring expert knowledge about the system under development, as its data critically impacts the outcome of the tests designed to assess the system. Current practices of populating the testing environments generally focus on developing efficient algorithms for generating synthetic data or use the production environment for testing purposes. The latter is an invaluable strategy to provide real test cases in order to discover issues that critically impact the user of the system. However, the production environment generally consists of large amounts of data that are difficult to handle and analyze. Database sampling from the production environment is a potential solution to overcome these challenges.</p><p>In this research, we propose two database sampling methods, VFDS and CoDS, with the objective of populating the testing environment. The first method is a very fast random sampling approach, while the latter aims at preserving the distribution of data in order to produce a representative sample. In particular, we focus on the dependencies between the data from different tables and the method tries to preserve the distributions of these dependencies.";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $abstract));
	}

}
