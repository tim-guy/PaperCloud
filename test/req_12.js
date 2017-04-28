var include = require('../scripts/include.js');

QUnit.test("testSubsetSearch", function( assert ) {
  
	var papers = ["A", "B", "C", "D", "E"];
	var indices = [1, 2, 4];
	var checkboxes = [];	
	indices.forEach(function(index) {
		checkboxes.push({
			attr: function() { return index; }
		});
	});

	papers = include.selectPaperSubset(papers, checkboxes);

	assert.deepEqual(["B", "C", "E"], papers);
});
