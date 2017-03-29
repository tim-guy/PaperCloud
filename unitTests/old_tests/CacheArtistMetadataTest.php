<?php
require_once "cache/CacheArtistMetadata.php";

use PHPUnit\Framework\TestCase;

class CacheArtistMetadataTest extends TestCase
{
	// MOCKING:

	private function mockChartLyricsIndex()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback(0, file_get_contents("unitTests/mocks/chartLyricsIndex.html"));
		}));
		
		return $stub;
	}

	private function mockChartLyricsArtistListPage()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback(0, file_get_contents("unitTests/mocks/chartLyricsArtistListPage.html"));
		}));
		
		return $stub;
	}

	// TESTS:

	public function testThereAreBetween300And400ArtistListPageURLs()
	{
		$artistListPageURLs = getArtistListPageURLs($this->mockChartLyricsIndex());

		$this->assertGreaterThanOrEqual(300, count($artistListPageURLs));
		$this->assertLessThanOrEqual(400, count($artistListPageURLs));
	}

	public function testArtistListPageURLsAreOfCorrectFormat()
	{
		$artistListPageURLs = getArtistListPageURLs($this->mockChartLyricsIndex());
		foreach ($artistListPageURLs as $url)
		{
			$this->assertRegExp("/^(http:\/\/)?www\.chartlyrics\.com\/...\.aspx$/", $url);
		}
	}

	public function testAlphanumericChartLyricsIDCorrectlyExtracted()
	{
		$id = extractChartLyricsID("/FgiZDj7LMEmi63eQnkLNZg.aspx");

		$this->assertEquals("FgiZDj7LMEmi63eQnkLNZg", $id);
	}

	public function testChartLyricsIDWithUnderscoreCorrectlyExtracted()
	{
		$id = extractChartLyricsID("/PsZnf6TFCkeFzmd_fGqUpA.aspx");

		$this->assertEquals("PsZnf6TFCkeFzmd_fGqUpA", $id);
	}

	public function testChartLyricsIDWithDashCorrectlyExtracted()
	{
		$id = extractChartLyricsID("/zVI-HMXAIEKF2evbaibQVg.aspx");

		$this->assertEquals("zVI-HMXAIEKF2evbaibQVg", $id);
	}

	public function test249ArtistsAreLoadedFromAPage()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		$this->assertEquals(249, count($artists));
	}

	public function testArtistMetadataIsProperlyStructured()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		foreach ($artists as $id => $artist)
		{
			$this->assertArrayHasKey("chartLyricsID", $artist);
			$this->assertArrayHasKey("name", $artist);
			$this->assertArrayHasKey("disambiguator", $artist);
			$this->assertArrayHasKey("popularity", $artist);

			$this->assertEquals($id, $artist["chartLyricsID"]);
		}
	}

	public function testArtistChartLyricsIDsAreValid()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		foreach ($artists as $id => $artist)
		{
			$this->assertRegExp("/^[a-zA-Z0-9\-_]{22}$/", $artist["chartLyricsID"]);
		}
	}

	public function testArtistNamesAreNonEmptyStrings()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		foreach ($artists as $id => $artist)
		{
			$this->assertInternalType('string', $artist["name"]);
			$this->assertNotEquals("", $artist["name"]);
		}	
	}

	public function testArtistDisambiguatorsAreStrings()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		foreach ($artists as $id => $artist)
		{
			$this->assertInternalType('string', $artist["disambiguator"]);
		}
	}

	public function testArtistPopularitiesAreIntegersBeteween1And10()
	{
		$artists = getArtistMetadata(array("http://www.chartlyrics.com/T03.aspx"), $this->mockChartLyricsArtistListPage());

		foreach ($artists as $id => $artist)
		{
			$this->assertGreaterThanOrEqual(0, $artist["popularity"]);
			$this->assertLessThanOrEqual(10, $artist["popularity"]);
		}
	}
}
