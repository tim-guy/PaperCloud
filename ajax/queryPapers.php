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

require_once("IEEELibraryAdapter.php");
require_once("ACMLibraryAdapter.php");
ini_set('memory_limit', '1G');

$name = $_GET['name'];
$limit = intval($_GET['limit']);
if ($limit <= 0 || $limit > 1000) { // max limit of 1000
	$limit = 1000;
}

/*
$ieee = new IEEELibraryAdapter();
$papers = $ieee->getPapersWithAuthorName($name, $limit);
echo json_encode($papers);
*/

$acm = new ACMLibraryAdapter();
$papers = $acm->getPapersWithAuthorName($name, $limit);
echo json_encode($papers);
