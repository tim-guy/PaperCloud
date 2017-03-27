<?php
require_once "cache/CacheArtistSongLists.php";

use PHPUnit\Framework\TestCase;

class CacheArtistSongListsTest extends TestCase
{
	// MOCKING:

	private function mockChartLyricsTearsForFearsSongListPage()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("lJx_fOjeA0mJK2z0RlLi3g", file_get_contents("unitTests/mocks/chartLyricsTearsForFearsSongListPage.html"));
		}));
		
		return $stub;
	}

	private function mockChartLyricsTechnicalItchSongListPage()
	{
		$stub = $this->createMock(HTTPRequestManager::class);
		$stub->method('requestURLs')->will($this->returnCallback(function($urls, $callback, $throttle) {
			$callback("7I_0efIuGkO6TZpeoGu2VQ", file_get_contents("unitTests/mocks/chartLyricsTechnicalItchSongListPage.html"));
		}));
		
		return $stub;
	}

	// TESTS:

	public function testArtistMetadataIsProperlyStructured()
	{
		$artists = array("lJx_fOjeA0mJK2z0RlLi3g" => array());
		$artists = getArtistSongLists($artists, $this->mockChartLyricsTearsForFearsSongListPage());

		$this->assertArrayHasKey("lJx_fOjeA0mJK2z0RlLi3g", $artists);
		$this->assertArrayHasKey("songURLs", $artists["lJx_fOjeA0mJK2z0RlLi3g"]);
	}

	public function testArtistsWithNoSongsWithAvailableLyricsAreExcluded()
	{
		$artists = array("7I_0efIuGkO6TZpeoGu2VQ" => array());
		$artists = getArtistSongLists($artists, $this->mockChartLyricsTechnicalItchSongListPage());
	
		$this->assertEmpty($artists);
	}

	public function testArtistSongListsIncludeSongsWithAvailableLyrics()
	{
		$artists = array("lJx_fOjeA0mJK2z0RlLi3g" => array());
		$artists = getArtistSongLists($artists, $this->mockChartLyricsTearsForFearsSongListPage());

		$this->assertContains("http://www.chartlyrics.com/lJx_fOjeA0mJK2z0RlLi3g/Everybody+Wants+to+Rule+the+World.aspx", $artists["lJx_fOjeA0mJK2z0RlLi3g"]["songURLs"]);
	}

	public function testArtistSongListsDoNotIncludeSongsWithUnavailableLyrics()
	{
		$artists = array("lJx_fOjeA0mJK2z0RlLi3g" => array());
		$artists = getArtistSongLists($artists, $this->mockChartLyricsTearsForFearsSongListPage());

		foreach ($artists["lJx_fOjeA0mJK2z0RlLi3g"]["songURLs"] as $id => $songURL)
		{
			$this->assertInternalType('string', $songURL);
			$this->assertNotEquals("", $songURL);
		}
	}
}
