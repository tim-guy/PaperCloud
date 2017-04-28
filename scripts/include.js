
function register(key, value) {
	if (typeof module !== "undefined") module.exports[key] = value;
}


// PROGRESS BAR:

var completionHandler = false;
function startProgressBar(estimatedTime, progressbar, getCompletionHandler)
{
	progressbar.progressbar({
		value: 0
	});
	progressbar.show(0);
	
	var t = 0, dt = 40;
	completionHandler = false;
	function progress() {

		if (typeof module !== "undefined") completionHandler = getCompletionHandler();

		var val = progressbar.progressbar("value");
		
		progressbar.progressbar("value", completionHandler ? (val+5) : (25*Math.log(t/estimatedTime) + 100));
		
		if (val < 99 || !completionHandler) {
			t += dt;
			setTimeout(progress, dt);
		} else {
			completionHandler();
		}
	}
	progress();
}
register("completionHandler", completionHandler);
register("startProgressBar", startProgressBar);

// DOWNLOAD PAPER LIST AS PDF:

function layoutPDFPaperList(papers)
{
	var table = [[
		{text: 'Title', bold: true},
		{text: 'Authors', bold: true},
		{text: 'Publication/Conference', bold: true}
	]];
	papers.forEach(function(paper) {
		table.push([paper.title, paper.authors, paper.publication]);
	});

	return {
	  content: [
		{
		  table: {
			headerRows: 1,
			widths: [ '50%', '20%', '30%' ],
			body: table
		  }
		}
	  ]
	};
}
register("layoutPDFPaperList", layoutPDFPaperList);

// ACCESS PREVIOUS SEARCHES:

function updateSearchHistoryCookie(previousValue, searchField, searchValue, limit)
{
	var searchHistory = JSON.parse(previousValue);
	searchHistory.push({"field": searchField, "value": searchValue, "limit": limit });
	return JSON.stringify(searchHistory);
}
register("updateSearchHistoryCookie", updateSearchHistoryCookie);

// SUBSET SEARCH:

function selectPaperSubset(papers, checkboxes)
{
	var out = [];

	checkboxes.forEach(function(checkbox) {
		out.push(papers[checkbox.attr("paperIndex")]);
	});

	return out;
}
register("selectPaperSubset", selectPaperSubset);

// DOWNLOAD CLOUD IMAGE:

function parseDataURL(dataURL)
{
	return dataURL.substring(dataURL.indexOf(',') + 1, dataURL.length);
}
register("parseDataURL", parseDataURL);


