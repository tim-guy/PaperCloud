<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
require_once "ajax/LibraryAdapter.php";

use PHPUnit\Framework\TestCase;

class LibraryAdapterTest extends TestCase
{
	public function testValidGetPapersWithAuthorName()
	{
		$papers = LibraryAdapter::getPapersWithAuthorNameFromAllLibraries("name", "Johnson", false, 10);

		$this->assertLessThanOrEqual(10, sizeof($papers));

		foreach ($papers as $paper) {
			$this->assertContains("Johnson", $paper['authors']);
		}
	}

	public function testValidGetPapersWithExactAuthorName()
	{
		$papers = LibraryAdapter::getPapersWithAuthorNameFromAllLibraries("name", "Barry Boehm", true, 10);

		$this->assertLessThanOrEqual(10, sizeof($papers));

		foreach ($papers as $paper) {
			$this->assertContains("Barry Boehm", $paper['authors']);
		}
	}
}