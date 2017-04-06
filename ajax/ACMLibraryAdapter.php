<?php

require_once "LibraryAdapter.php";
require_once("CSVParser.php");

class ACMLibraryAdapter extends LibraryAdapter {

	function getPapersWithAuthorName($name, $limit)
	{	
		$papers = array();

		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($name) . '%29&srt=%5Fscore&expformat=csv';
		$acmCSV = $this->requestManager->request($acmURL); // this request is a bottleneck

		$lines = CSVParser::parse($acmCSV);
		
		foreach ($lines as $line) {
			$paper = array();
			
			$paper["source"] = "acm";
			
			// Query the paper title
			$paper["title"] = $line["title"];
			
			// Query the paper authors
			$paper["authors"] = $line["author"];
			
			// Query the paper publication name
			$paper["publication"] = $line["booktitle"];
			
			// Derive the full text URL name from the ID
			$paper["fullTextURL"] = "http://dl.acm.org/ft_gateway.cfm?id=" . $line["id"];
			
			// Query the paper abstract
			$paper["abstract"] = "";
			
			// Query the keyword terms
			$paper["keywords"] = $line["title"] . ' ' . $line["keywords"];
			
			$papers[] = $paper;
			
			if (count($papers) >= $limit) {
				break;
			}
		}
		
		return $papers;
	}
	
}
LibraryAdapter::registerLibrary(new ACMLibraryAdapter());