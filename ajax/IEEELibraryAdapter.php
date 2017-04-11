<?php

require_once 'LibraryAdapter.php';
require_once 'HTTPRequestManager.php';

class IEEELibraryAdapter extends LibraryAdapter {

	function getPapersWithAuthorName($field, $value, $exact, $limit)
	{
		$papers = array();
		
		$querystring = 'hc=' . $limit;
		switch ($field) {
			case 'name':
				$querystring .= '&au=' . urlencode(str_replace(",", " ", $value));
				break;
			case 'publication':
				$querystring .= '&jn=' . urlencode($value);
				break;
		}

		$ieeeURL = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?' . $querystring;
		$ieeeXML = $this->requestManager->request($ieeeURL); // this request is a bottleneck

		$doc = new DOMDocument();
		$doc->loadXML($ieeeXML); // the response is well-formed XML

		$xpath = new DOMXPath($doc);
		$documents = $xpath->query("//document"); // query for each paper
		foreach ($documents as $document) {
			$paper = array();
			
			$paper["source"] = "ieee";
			
			// Query the DOI
			$dois = $xpath->query("./doi", $document);
			if ($dois->length > 0) {
				$paper["id"] = $dois[0]->textContent;
			} else {
				continue;
			}
			
			// Query the paper title
			$titles = $xpath->query("./title", $document);
			if ($titles->length > 0) {
				$paper["title"] = $titles[0]->textContent;
			} else {
				continue;
			}
			
			// Query the paper authors
			$authorss = $xpath->query("./authors", $document);
			if ($authorss->length > 0) {
				$paper["authors"] = $authorss[0]->textContent;
				
				if ($exact && $field == 'name' && (stripos($paper["authors"], $value) === false)) {
					continue; // This entry doesn't contain the full author name.
				}
			} else {
				continue;
			}
			
			// Query the paper publication name
			$publications = $xpath->query("./pubtitle", $document);
			if ($publications->length > 0) {
				$paper["publication"] = $publications[0]->textContent;
				
				if ($exact && $field == "publication" && (stripos($paper["publication"], $value) === false)) {
					continue;
				}
				
			} else {
				continue;
			}
			
			// Query the full text URL name
			$fullTextURLs = $xpath->query("./pdf", $document);
			if ($fullTextURLs->length > 0) {
				$paper["fullTextURL"] = $fullTextURLs[0]->textContent;
			} else {
				continue;
			}
			
			// Query the paper abstract
			$abstracts = $xpath->query("./abstract", $document);
			if ($abstracts->length > 0) {
				$paper["abstract"] = $abstracts[0]->textContent;
			} else {
				continue;
			}
			
			// Query the keyword terms
			$terms = $xpath->query("./*/term", $document);
			$paper["keywords"] = $paper["title"];
			foreach ($terms as $term) {
				$paper["keywords"] .= " " . $term->textContent;
			}
			
			$papers[] = $paper;
		}
		
		return $papers;
	}
	
	function getBibtexForPaper($paper) {
		// Get Bibtex
		$url = 'http://www.doi2bib.org/doi2bib?id=' . urlencode($paper["id"]);
		$bibtex = @$this->requestManager->request($url);
		
		return $bibtex;
	}
	
	function getAbstractForPaper($paper) {
		return $paper["abstract"];
	}
}
LibraryAdapter::registerLibrary("ieee", new IEEELibraryAdapter());