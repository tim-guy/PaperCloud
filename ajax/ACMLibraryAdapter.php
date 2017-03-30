<?php

require_once("CSVParser.php");

class IEEELibraryAdapter {
	
	function getPapersWithAuthorName($name, $limit)
	{	
		$papers = array();

		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($name) . '%29&srt=%5Fscore&expformat=csv';
		$acmCSV = file_get_contents($acmURL); // this request is a bottleneck

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
			$paper["keywords"] = $line["keywords"]
			
			$papers[] = $paper;
		}
		
		return $papers;
	}
	
}