<?php
require_once "cache/CacheArtistMBIDs.php";

use PHPUnit\Framework\TestCase;

class CacheArtistMBIDsTest extends TestCase
{
	// MOCKING:

	private function mockMusicBrainzTearsForFearsSearchResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("lJx_fOjeA0mJK2z0RlLi3g", file_get_contents("unitTests/mocks/musicBrainzTearsForFearsSearchResults.xml"));
		}));
		
		return $stub;
	}

	private function mockMusicBrainzNonEnglishSearchResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("M14Tm7wvVUGzUcwqOZ15dQ", file_get_contents("unitTests/mocks/musicBrainzNonEnglishSearchResults.xml"));
		}));
		
		return $stub;
	}

	private function mockMusicBrainzKrisiunSearchResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("1lhknlNw60isj79v35Fpxg", file_get_contents("unitTests/mocks/musicBrainzKrisiunSearchResults.xml"));
		}));
		
		return $stub;
	}

	private function mockMusicBrainzKrisKrossSearchResults()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("_-hhvyF2VUaOvWghBkXF6Q", file_get_contents("unitTests/mocks/musicBrainzKrisKrossSearchResults.xml"));
		}));
		
		return $stub;
	}

	// TESTS:
	
	public function testEncodedURLsContainNoSpecialCharacters()
	{
		$in = array("P", "8", "-", "/", "?", "&", "+", "=", " ");
		$in[] = array_reduce($in, function($carry, $item) {
			return $carry . $item;
		});

		foreach ($in as $str)
		{
			$out = encodeURL($str);
			$this->assertRegExp("/^[a-zA-Z0-9_\-%+]*$/", $out);
		}
	}

	public function testArtistMetadataIsProperlyStructured()
	{
		$artists = array(
			"lJx_fOjeA0mJK2z0RlLi3g" => array("chartLyricsID" => "lJx_fOjeA0mJK2z0RlLi3g", "name" => "Tears for Fears", "disambiguator" => "")
		);
		$artists = getArtistMBIDs($artists, $this->mockMusicBrainzTearsForFearsSearchResults());

		$this->assertArrayHasKey("lJx_fOjeA0mJK2z0RlLi3g", $artists);
		$this->assertArrayHasKey("musicBrainzID", $artists["lJx_fOjeA0mJK2z0RlLi3g"]);
	}

	public function testArtistsWithNoMusicBrainzEntryHaveEmptyMusicBrainzIDs()
	{
		$artists = array(
			"M14Tm7wvVUGzUcwqOZ15dQ" => array(
				"chartLyricsID" => "M14Tm7wvVUGzUcwqOZ15dQ",
				"name" => "\u00d0\u009a\u00d1\u0080\u00d0\u00b5\u00d0\u00bc\u00d0\u00b0\u00d1\u0082\u00d0\u00be\u00d1\u0080\u00d0\u00b8\u00d0\u00b9",
				"disambiguator" => ""
			)
		);
		$artists = getArtistMBIDs($artists, $this->mockMusicBrainzNonEnglishSearchResults());

		$this->assertEquals("", $artists["M14Tm7wvVUGzUcwqOZ15dQ"]["musicBrainzID"]);
	}

	public function testArtistWithDisambiguatorsHaveCorrectMusicBrainzIDs()
	{
		$artists = array(
			"1lhknlNw60isj79v35Fpxg" =>array(
				"chartLyricsID" => "1lhknlNw60isj79v35Fpxg",
				"name" => "Krisiun",
				"disambiguator" => "Brazillian death metal band"
			)
		);
		$artists = getArtistMBIDs($artists, $this->mockMusicBrainzKrisiunSearchResults());

		$this->assertEquals("9e6458d6-7053-48eb-ac8f-bf6fdf9169c6", $artists["1lhknlNw60isj79v35Fpxg"]["musicBrainzID"]);
	}

	public function testArtistWithoutDisambiguatorsHaveCorrectMusicBrainzIDs()
	{
		$artists = array(
			"_-hhvyF2VUaOvWghBkXF6Q" => array("chartLyricsID" => "_-hhvyF2VUaOvWghBkXF6Q", "name" => "Kris Kross", "disambiguator" => "")
		);
		$artists = getArtistMBIDs($artists, $this->mockMusicBrainzKrisKrossSearchResults());

		$this->assertEquals("bf61e8ff-7621-4655-8ebd-68210645c5e9", $artists["_-hhvyF2VUaOvWghBkXF6Q"]["musicBrainzID"]);
	}
}
