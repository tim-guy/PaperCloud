var include = require('../scripts/include.js');

QUnit.test("testPDFPaperListLayout", function( assert ) {
  
	var papers = [
		{
			title: "A1",
			authors: "B1",
			publication: "C1"
		},
		{
			title: "A2",
			authors: "B2",
			publication: "C2"
		},
		{
			title: "A3",
			authors: "B3",
			publication: "C3"
		},
	];

	var pdf = include.layoutPDFPaperList(papers);

	assert.deepEqual([
		["A1", "B1", "C1"],
		["A2", "B2", "C2"],
		["A3", "B3", "C3"],
	], pdf.content[0].table.body.slice(1))

});
