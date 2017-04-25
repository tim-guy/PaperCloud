<?php

require_once "LibraryAdapter.php";
require_once("CSVParser.php");

require_once(__DIR__ . "/../vendor/autoload.php");

class ACMLibraryAdapter extends LibraryAdapter {

	function searchPapers($field, $value, $exact, $limit)
	{	
		$papers = array();
		
		$querystring = '?srt=%5Fscore&expformat=csv';
		switch ($field) {
			case 'name':
				$querystring .= '&query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($value) . '%29';
				break;
			case 'publication':
				$querystring .= '&query=%28(' . urlencode($value) . ')%29';
				break;
			case 'keyword':
				$querystring .= '&query=recordAbstract%3A%28%252B' . urlencode($value) . '%29';
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
			// @codeCoverageIgnoreStart
			if ($exact && $field == 'name' && stripos($paper["authors"], $value) === false)
				continue; // This entry doesn't contain the full author name.
			// @codeCoverageIgnoreEnd

			// Query the paper publication name
			$paper["publication"] = $line["booktitle"];
			// @codeCoverageIgnoreStart
			if ($exact && $field == 'publication' && stripos($paper["publication"], $value) === false)
				continue;
			// @codeCoverageIgnoreEnd
			
			// Derive the full text URL name from the ID
			$paper["fullTextURL"] = "http://dl.acm.org/ft_gateway.cfm?id=" . $line["id"];
			
			// Query the paper abstract
			$paper["abstract"] = "";
			
			// Query the keyword terms
			$paper["keywords"] = $line["title"] . ' ' . $line["keywords"];
			
			$papers[] = $paper;
			
			if (count($papers) >= $limit)
				break;
		}
		
		return $papers;
	}

	function getFullTextForPaper($paper) {

		$driver = new \Behat\Mink\Driver\Selenium2Driver();
		$session = new \Behat\Mink\Session($driver);

		$session->start();
		$session->visit($paper['fullTextURL']);

		$session->wait(
			10000,
			"PDFViewerApplication != null && PDFViewerApplication.pdfDocument != null"
		);

		$session->executeScript('
			PDFViewerApplication.pdfDocument.getData().then(function(d) {
				window.pdfBlob = PDFJS.createBlob(d);
		
				var freader = new FileReader();
				freader.addEventListener("loadend", function() {
					window.pdf64 = freader.result;
				});
				freader.readAsDataURL(window.pdfBlob);
			});');

		$session->wait(
			10000,
			"window.pdf64 != undefined"
		);

		$blob = $session->evaluateScript('return window.pdf64;');

		$session->stop();

		//return substr(strstr($blob, ","), 1);
		return base64_decode(substr(strstr($blob, ","), 1));
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
