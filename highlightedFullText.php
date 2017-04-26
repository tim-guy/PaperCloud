<?php

require_once "ajax/LibraryAdapter.php";

$highlightedFullText = LibraryAdapter::getHighlightedFullTextForPaperFromLibrary($_POST);

file_put_contents("fulltext.pdf", $highlightedFullText);

?>

<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script src="scripts/pdf.js"></script>
		<script src="scripts/util.js"></script>
		<script src="scripts/dom_utils.js"></script>
		<script src="scripts/textlayer.js"></script>
		<script>		
			$(document).ready(function() {

				// Render the PDF
				PDFJS.getDocument("fulltext.pdf").then(function(pdf) {


					for (var pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++)
					{
						(function (pageNumber) {						
							
							var canvas = $("<canvas height=1200>");
							$("<div class='page' id='page_" + pageNumber + "'>")
								.append(canvas)
								.append("<div class='overlay' id='overlay_" + pageNumber + "'>")
								.appendTo("#preview");

							var ctx = canvas.get(0).getContext('2d');

							pdf.getPage(pageNumber).then(function(page) {
						
								var viewport = page.getViewport(1);
								var scale = canvas.get(0).height / viewport.height;
								viewport = page.getViewport(scale);
								canvas.get(0).width = viewport.width;

								var params = {
									canvasContext: ctx,
									viewport: viewport
								};
								page.render(params);
						
								// Make divs
								page.getTextContent().then(function(tc) {
							
									renderTextLayer({
										textContent: tc,
										container: document.getElementById("overlay_" + pageNumber),
										viewport: viewport,
										textDivs: [],
										enhanceTextSelection: false
									});
							
									// Now, highlight the word in the divs
									$("#overlay_" + pageNumber + " > div").each(function(index) {
								
										$(this).html($(this).text().replace(<?php echo '/' . $_POST["word"] . '/i'; ?>, function(x) {
											return "<span class='highlight'>" + x + "</span>";
										}));
								
									});
							
								});
							});
						}) (pageNumber);
					}

				});
			});
		</script>
		<link rel=STYLESHEET href="highlightedFullText.css" type="text/css" />
		<link rel=STYLESHEET href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />
	</head>
	<body>
		<div id="preview"></div>
	</body>
</html>

