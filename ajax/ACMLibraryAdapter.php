<?php

require_once "LibraryAdapter.php";
require_once("CSVParser.php");

class ACMLibraryAdapter extends LibraryAdapter {

	function getPapersWithAuthorName($field, $value, $exact, $limit)
	{	
		$papers = array();
		
		$querystring = '?srt=%5Fscore&expformat=csv';
		switch ($field) {
			case 'name':
				$querystring .= '&query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($value) . '%29';
				break;
			case 'publication':
				$querystring .= '&query=%28(' . urlencode($value) . ')%29&within=owners%2Eowner%3DHOSTED';
				break;
		}
		
		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?' . $querystring;
		$acmCSV = $this->requestManager->request($acmURL); // this request is a bottleneck

		$lines = CSVParser::parse($acmCSV);
		
		foreach ($lines as $line) {
			$paper = array();
			
			$paper["source"] = "acm";
			
			$paper["id"] = $line["id"];
			
			// Query the paper title
			$paper["title"] = $line["title"];
			
			// Query the paper authors
			$paper["authors"] = $line["author"];
			if ($exact && $field == 'name' && stripos($paper["authors"], $value) === false) {
				continue; // This entry doesn't contain the full author name.
			}

			// Query the paper publication name
			$paper["publication"] = $line["booktitle"];
			if ($exact && $field == 'publication' && stripos($paper["publication"], $value) === false) {
				continue;
			}
			
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
	
	function getBibtexForPaper($paper) {
		$url = 'http://dl.acm.org/exportformats.cfm?expformat=bibtex&id=' . $paper["id"];
		
		$bibtexHTML = $this->requestManager->request($url);
		
		preg_match("/<PRE.*?>\n?(.*)<\/pre>/si", $bibtexHTML, $matches); // extract the bibtex itself
		
		return $matches[1];
	}
	
	function getAbstractForPaper($paper) {
		$url = 'http://dl.acm.org/tab_abstract.cfm?id=' . $paper["id"];
		
		$abstractHTML = $this->requestManager->request($url);
		
		preg_match("/<p.*?>\n?(.*)<\/p>/si", $abstractHTML, $matches); // extract the abstract itself
		
		return $matches[1];
	}
}
LibraryAdapter::registerLibrary("acm", new ACMLibraryAdapter());