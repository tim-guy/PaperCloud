<?php

header('Content-Type: text/plain');

require_once "ajax/LibraryAdapter.php";

$bibtex = LibraryAdapter::getBibtexForPaperFromLibrary($_POST);

echo $bibtex ? $bibtex : "BibTeX not found!";