<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/LibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class LibraryAdapterTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		$papers = LibraryAdapter::searchPapersFromAllLibraries("name", "Johnson", false, 10);

		$this->assertLessThanOrEqual(10, sizeof($papers));

		foreach ($papers as $paper) {

			$this->assertContains("Johnson", $paper['authors']);
		}
	}

	public function testValidGetPapersWithExactAuthorName()
	{
		$papers = LibraryAdapter::searchPapersFromAllLibraries("name", "Barry Boehm", true, 10);

		$this->assertLessThanOrEqual(10, sizeof($papers));

		foreach ($papers as $paper) {
			$this->assertContains("Barry Boehm", $paper['authors']);
		}
	}

	public function testGetIEEEPaperBibtex()
	{
		$paper = array(
			"source" => 'ieee',
			"id" => "10.1109/ICSE.2015.32"
		);

		$bibtex = LibraryAdapter::getBibtexForPaperFromLibrary($paper);
		
		$expected = "@inproceedings{Gui_2015, doi = {10.1109/icse.2015.32}, url = {https://doi.org/10.1109%2Ficse.2015.32}, year = 2015, month = {may}, publisher = {{IEEE}}, author = {Jiaping Gui and Stuart Mcilroy and Meiyappan Nagappan and William G. J. Halfond}, title = {Truth in Advertising: The Hidden Cost of Mobile Ads for Software Developers}, booktitle = {2015 {IEEE}/{ACM} 37th {IEEE} International Conference on Software Engineering} }";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $bibtex));
	}

	public function testGetACMPaperBibtex()
	{
		$paper = array(
			"source" => "acm",
			"id" => "2492397"
		);

		$bibtex = LibraryAdapter::getBibtexForPaperFromLibrary($paper);
		
		$expected = "@inproceedings{Buda:2013:GTD:2483760.2492397, author = {Buda, Teodora Sandra}, title = {Generation of Test Databases Using Sampling Methods}, booktitle = {Proceedings of the 2013 International Symposium on Software Testing and Analysis}, series = {ISSTA 2013}, year = {2013}, isbn = {978-1-4503-2159-4}, location = {Lugano, Switzerland}, pages = {366--369}, numpages = {4}, url = {http://doi.acm.org/10.1145/2483760.2492397}, doi = {10.1145/2483760.2492397}, acmid = {2492397}, publisher = {ACM}, address = {New York, NY, USA}, keywords = {Database sampling, relational database, testing}, }";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $bibtex));
	}

	public function testGetIEEEPaperAbstract()
	{
		$paper = array(
			"source" => "ieee",
			"abstract" => "MY ABSTRACT"
		);

		$abstract = LibraryAdapter::getAbstractForPaperFromLibrary($paper);
		
		$this->assertContains("MY ABSTRACT", $abstract);
	}

	public function testGetACMPaperAbstract()
	{
		$paper = array(
			"source" => "acm",
			"id" => "2492397"
		);

		$abstract = LibraryAdapter::getAbstractForPaperFromLibrary($paper);
		
		$expected = "Populating the testing environment with relevant data represents a great challenge in software validation, generally requiring expert knowledge about the system under development, as its data critically impacts the outcome of the tests designed to assess the system. Current practices of populating the testing environments generally focus on developing efficient algorithms for generating synthetic data or use the production environment for testing purposes. The latter is an invaluable strategy to provide real test cases in order to discover issues that critically impact the user of the system. However, the production environment generally consists of large amounts of data that are difficult to handle and analyze. Database sampling from the production environment is a potential solution to overcome these challenges.</p><p>In this research, we propose two database sampling methods, VFDS and CoDS, with the objective of populating the testing environment. The first method is a very fast random sampling approach, while the latter aims at preserving the distribution of data in order to produce a representative sample. In particular, we focus on the dependencies between the data from different tables and the method tries to preserve the distributions of these dependencies.";
		$this->assertContains(preg_replace('/\s/', '', $expected), preg_replace('/\s/', '', $abstract));
	}
}
