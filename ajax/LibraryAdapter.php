<?php

include_once "IEEELibraryAdapter.php";
include_once "ACMLibraryAdapter.php";

abstract class LibraryAdapter
{
	var $requestManager;
	
	function __construct() {
		$this->requestManager = new HTTPRequestManager();
	}
	
	// Static Methods:
	
	private static $libraryAdapters = array();
	static function registerLibrary($key, LibraryAdapter $library)
	{
		self::$libraryAdapters[$key] = $library;
	}
	
	static function getPapersWithAuthorNameFromAllLibraries($field, $value, $exact, $limit)
	{
		$allPapers = array(); // an array of arrays of the papers returned by each library
		$count = 0;
		foreach (self::$libraryAdapters as $library)
		{
			$papers = $library->getPapersWithAuthorName($field, $value, $exact, $limit);
			
			$count += count($papers);
			$allPapers[] = $papers;
		}
		
		$fraction = min(1, $limit / ($count ? $count : 1)); // by what fraction we should cut allPapers
				
		$out = array();
		foreach ($allPapers as $papers)
		{			
			$out = array_merge($out, array_slice($papers, 0, $fraction * count($papers) + 1));
		}
		
		return array_slice($out, 0, $limit);
	}
	
	static function getBibtexForPaperFromLibrary($paper) {
		
		foreach (self::$libraryAdapters as $key => $library) {
			if ($key == $paper['source']) {
				return $library->getBibtexForPaper($paper);
				break;
			}
		}	
	}
	
	static function getAbstractForPaperFromLibrary($paper) {
		foreach (self::$libraryAdapters as $key => $library) {
			if ($key == $paper['source']) {
				return $library->getAbstractForPaper($paper);
				break;
			}
		}			
	}
	
	// Abstract Methods:
	
	abstract function getPapersWithAuthorName($field, $value, $exact, $limit);
	
	abstract function getBibtexForPaper($paper);
	
	abstract function getAbstractForPaper($paper);
}