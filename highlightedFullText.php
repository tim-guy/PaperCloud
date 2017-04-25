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
				
				var _ = {};
				
				_.$canvas = $('#canvas');
				var ctx = _.$canvas.get(0).getContext('2d');

				// Render the PDF
				PDFJS.getDocument("fulltext.pdf").then(function(pdf) {
					pdf.getPage(1).then(function(page) {
						
						_.page = page;
						
						var viewport = page.getViewport(1);
						_.scale = _.$canvas.get(0).height / viewport.height;
						viewport = page.getViewport(_.scale);
						_.$canvas.get(0).width = viewport.width;

						var params = {
							canvasContext: ctx,
							viewport: viewport
						};
						page.render(params);
						
						// Make divs
						page.getTextContent().then(function(tc) {
							
							renderTextLayer({
								textContent: tc,
								container: document.getElementById("overlay"),
								viewport: viewport,
								textDivs: [],
								enhanceTextSelection: false
							});
							
							/*
							$('#here').empty();
							_.titles = [];
							var sizes = {};
							
							$.each(tc.items, function(index) {
								
								var match = /energy/i.exec(this.str);
								
								if (match)
								{
									var tx = Util.transform(viewport.transform, this.transform);
									var fontHeight = Math.sqrt((tx[2] * tx[2]) + (tx[3] * tx[3]));
									
									ctx.font = (this.height * 0.95) + 'px ' + tc.styles[this.fontName].fontFamily;
									//console.log(tc.styles);
									
									overlay(
										this.transform[4] + ctx.measureText(this.str.substring(0, match.index)).width, // x
										this.transform[5], // y
										ctx.measureText(match[0]).width, // w
										this.height, // h
										'toggle-on yes-no', // style
										function() {} // on click
									);
								}
							});
							*/

							// Now, highlight the word in the divs
							$("#overlay > div").each(function(index) {
								
								$(this).html($(this).text().replace(/energy/i, function(x) {
									return "<span class='highlight'>" + x + "</span>";
								}));
								
							});
							
						});
					});
				});
			});
		</script>
		<link rel=STYLESHEET href="highlightedFullText.css" type="text/css" />
		<link rel=STYLESHEET href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />
	</head>
	<body>
		<div id="preview">
			<canvas id="canvas" height=1200 ></canvas>
			<div id="overlay"></div>
		</div>
	</body>
</html>

