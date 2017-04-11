<?php
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";
//require_once "ajax/queryPapers.php";

use PHPUnit\Framework\TestCase;

class abstractTest extends TestCase
{
	public function testFunction()
	{
		$this->assertEquals(0, 0);
	}
}
