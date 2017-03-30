<?php

class IEEELibraryAdapter {
	
	function getPapersWithAuthorName($name, $limit)
	{	
		$papers = array();

		$ieeeURL = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?hc=' . $limit . '&au=' . urlencode($name);
		$ieeeXML = file_get_contents($ieeeURL); // this request is a bottleneck

		$doc = new DOMDocument();
		$doc->loadXML($ieeeXML); // the response is well-formed XML

		$xpath = new DOMXPath($doc);
		$documents = $xpath->query("//document"); // query for each paper
		foreach ($documents as $document) {
			$paper = array();
			
			$paper["source"] = "ieee";
			
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
			} else {
				continue;
			}
			
			// Query the paper publication name
			$publications = $xpath->query("./pubtitle", $document);
			if ($publications->length > 0) {
				$paper["publication"] = $publications[0]->textContent;
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
			
			// TODO: How to get Bibtex URL???
			$paper["bibtexURL"] = "";
			
			// Query the paper abstract
			$abstracts = $xpath->query("./abstract", $document);
			if ($abstracts->length > 0) {
				$paper["abstract"] = $abstracts[0]->textContent;
			} else {
				continue;
			}
			
			// Query the keyword terms
			$terms = $xpath->query("./*/term", $document);
			$paper["keywords"] = "";
			foreach ($terms as $term) {
				$paper["keywords"] .= " " . $term->textContent;
			}
			
			$papers[] = $paper;
		}
		
		return $papers;
	}
	
}