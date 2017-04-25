<?php

header('Content-Type: application/pdf');

require_once "ajax/LibraryAdapter.php";

$highlightedFullText = LibraryAdapter::getHighlightedFullTextForPaperFromLibrary($_POST);

echo $highlightedFullText;
