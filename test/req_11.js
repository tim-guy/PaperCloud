var include = require('../scripts/include.js');

QUnit.test("testUpdateSearchHistoryCookie", function( assert ) {
  
	var searchHistoryObject = [
		{
			field: "A1",
			value: "B1",
			limit: "C1"
		},
		{
			field: "A2",
			value: "B2",
			limit: "C2"
		}
	];
	var searchHistoryString = JSON.stringify(searchHistoryObject);

	searchHistoryString = include.updateSearchHistoryCookie(searchHistoryString, "A3", "B3", "C3");
	searchHistoryObject = JSON.parse(searchHistoryString);

	assert.deepEqual([
		{
			field: "A1",
			value: "B1",
			limit: "C1"
		},
		{
			field: "A2",
			value: "B2",
			limit: "C2"
		},
		{
			field: "A3",
			value: "B3",
			limit: "C3"
		}
	], searchHistoryObject);

});
