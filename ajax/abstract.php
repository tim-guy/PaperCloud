<?php

header('Content-Type: text/plain');

require_once "LibraryAdapter.php";

$abstract = LibraryAdapter::getAbstractForPaperFromLibrary($_POST);

echo $abstract ? $abstract : "Abstract not found!";