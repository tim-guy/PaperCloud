<?php
require_once "cache/CacheArtistWikipediaImageURLs.php";

use PHPUnit\Framework\TestCase;

class CacheArtistWikipediaImageURLsTest extends TestCase
{
	// MOCKING:

	private function mockWikipediaHeartQueryResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback(0, file_get_contents("unitTests/mocks/wikipediaHeartQueryResults.json"));
		}));
		
		return $stub;
	}

	private function mockWikipediaQuestionMarkAndTheMysteriansQueryResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback(0, file_get_contents("unitTests/mocks/wikipediaQuestionMarkAndTheMysteriansQueryResults.json"));
		}));
		
		return $stub;
	}

	// TESTS:

	public function testArtistMetadataIsProperlyStructured()
	{
		$artists = array(
			"9Ui9vfOrT0qaIUVR28P96Q" => array("chartLyricsID" => "9Ui9vfOrT0qaIUVR28P96Q", "wikipediaURL" => "https://en.wikipedia.org/wiki/Heart_%28band%29")
		);
		$artists = getArtistWikipediaImageURLs($artists, $this->mockWikipediaHeartQueryResults());

		$this->assertArrayHasKey("9Ui9vfOrT0qaIUVR28P96Q", $artists);
		$this->assertArrayHasKey("wikipediaImageURL", $artists["9Ui9vfOrT0qaIUVR28P96Q"]);
	}

	public function testArtistsWithNoWikipediaThumbnailsHaveEmptyWikipediaImageURLs()
	{
		$artists = array(
			"dcsvkRb65kmeGb7PD33qTQ" => array("chartLyricsID" => "dcsvkRb65kmeGb7PD33qTQ", "wikipediaURL" => "https://en.wikipedia.org/wiki/%3F_and_the_Mysterians")
		);
		$artists = getArtistWikipediaImageURLs($artists, $this->mockWikipediaQuestionMarkAndTheMysteriansQueryResults());

		$this->assertEquals("", $artists["dcsvkRb65kmeGb7PD33qTQ"]["wikipediaImageURL"]);
	}

	public function testArtistsWithWikipediaThumbnailsHaveCorrectWikipediaImageURLs()
	{
		$artists = array(
			"9Ui9vfOrT0qaIUVR28P96Q" => array("chartLyricsID" => "9Ui9vfOrT0qaIUVR28P96Q", "wikipediaURL" => "https://en.wikipedia.org/wiki/Heart_%28band%29")
		);
		$artists = getArtistWikipediaImageURLs($artists, $this->mockWikipediaHeartQueryResults());

		$this->assertEquals(
			"https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Heart_at_the_Beacon_Theater%2C_2012.jpg/150px-Heart_at_the_Beacon_Theater%2C_2012.jpg",
			$artists["9Ui9vfOrT0qaIUVR28P96Q"]["wikipediaImageURL"]
		);
	}

}
