<?php
require_once "cache/HTTPRequestManager.php";

use PHPUnit\Framework\TestCase;

class HTTPRequestTest extends TestCase
{
	// MOCKING:

	private function mockGoogleYahooUSCMultiRequest()
	{
		return function($data) {
			return array_intersect_key(array(
				"google" => "XXX",
				"yahoo" => "YYY",
				"usc" => "ZZZ"
			), $data);
		};
	}

	// TESTS:	

	public function testCallbackCalledOncePerURL()
	{
		$urls = array(
			"google" => "https://www.google.com",
			"yahoo" => "https://www.yahoo.com",
			"usc" => "https://www.usc.edu"
		);

		(new HTTPRequestManager())->requestURLs($urls, function($key, $response) use (&$count) {
			$count++;
		}, 0, $this->mockGoogleYahooUSCMultiRequest());

		$this->assertEquals(count($urls), $count);
	}
	
	public function testCallbackKeysMatchURLKeys()
	{
		$urls = array(
			"google" => "https://www.google.com",
			"yahoo" => "https://www.yahoo.com",
			"usc" => "https://www.usc.edu"
		);

		(new HTTPRequestManager())->requestURLs($urls, function($key, $response) use ($urls) {
			$this->assertContains($key, array_keys($urls));
		}, 0, $this->mockGoogleYahooUSCMultiRequest());
	}

	public function testRequestsDoNotExceedThrottle()
	{
		$urls = array(
			"google" => "https://www.google.com",
			"yahoo" => "https://www.yahoo.com",
			"usc" => "https://www.usc.edu"
		);
		$throttle = 0.5;		

		$lastTime = 0;
		(new HTTPRequestManager())->requestURLs($urls, function($key, $response) use ($throttle, &$lastTime) {
			$this->assertGreaterThanOrEqual($lastTime + $throttle, microtime(true));
			$lastTime = microtime(true);
		}, $throttle, $this->mockGoogleYahooUSCMultiRequest());
	}

	public function testResponsesAreNotEmpty()
	{
		$urls = array(
			"google" => "https://www.google.com",
			"yahoo" => "https://www.yahoo.com",
			"usc" => "https://www.usc.edu"
		);

		(new HTTPRequestManager())->requestURLs($urls, function($key, $response) {
			$this->assertNotEquals("", $response);
		}, 0, $this->mockGoogleYahooUSCMultiRequest());
	}
}
