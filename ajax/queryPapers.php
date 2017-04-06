<?php

/*

Should return a JSON object of the form:

	[
		{
			"source": <"ieee" | "acm">,
			"title": <paper title>,
			"authors": <authors>,
			"publication": <publication, maybe a conference>,
			
			QUESTION: do we only want papers from conferences?
			
			"fullTextURL": <fullTextURL>,
			"bibtex": <bibtex>,
			"bibtexURL": <bibtexURL>,
			"keywords": <keywords>
		}, ... for each paper (up to 'limit')
	]


*/

require_once("LibraryAdapter.php");

$name = $_GET['name'];
$limit = intval($_GET['limit']);
if ($limit <= 0 || $limit > 1000) { // max limit of 1000
	$limit = 1000;
}

/*
$ieee = new IEEELibraryAdapter();
$ieeePapers = $ieee->getPapersWithAuthorName($name, $limit);

$acm = new ACMLibraryAdapter();
$acmPapers = $acm->getPapersWithAuthorName($name, $limit);

$allPapers = array_merge($ieeePapers, $acmPapers);
*/

$papers = LibraryAdapter::getPapersWithAuthorNameFromAllLibraries($name, $limit);

echo json_encode($papers);
