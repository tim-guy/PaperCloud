<?php

/*

Should return a JSON object of the form:

	[
		{
			"source": <"ieee" | "acm">,
			"id": <an ID of relevance to the particular library>,
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
$exactName = $_GET['exactName'] == 'true';
if ($limit <= 0 || $limit > 1000) { // max limit of 1000
	$limit = 1000;
}

$papers = LibraryAdapter::getPapersWithAuthorNameFromAllLibraries($name, $exactName, $limit);

echo json_encode($papers);
