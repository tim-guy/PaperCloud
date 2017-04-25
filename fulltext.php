<?php
// We'll be outputting a PDF
header('Content-Type: application/pdf');
//header('Content-Type: text/plain');

ini_set("display_errors", 1);

require_once("vendor/autoload.php");


use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

$driver = new \Behat\Mink\Driver\Selenium2Driver();
$session = new \Behat\Mink\Session($driver);

$session->start();

$session->visit('http://dl.acm.org.libproxy1.usc.edu/citation.cfm?id=2804356');
$page = $session->getPage();

$session->wait(
	10000,
	"document.URL == 'https://shibboleth.usc.edu/idp/profile/SAML2/POST/SSO?execution=e1s2'"
);

$page->find('css', '#username')->setValue("pmnazari");
$page->find('css', '#password')->setValue("organaorgana");
$page->find('css', 'button[name=_eventId_proceed]')->click();

$session->wait(
	20000,
	"document.URL.includes('dl.acm.org')"
);

$session->executeScript('document.getElementsByName("FullTextPDF")[0].setAttribute("target", "");');
$page->find('css', 'a[name=FullTextPDF]')->click();

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

echo base64_decode(substr(strstr($blob, ","), 1));;

?>


