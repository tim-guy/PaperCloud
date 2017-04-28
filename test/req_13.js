var include = require('../scripts/include.js');

QUnit.test("testParseDataURL", function( assert ) {
  
	var dataURL = "data:image/png;base64,TESTDATA123";
	var data = include.parseDataURL(dataURL);
	
	assert.equal("TESTDATA123", data);
});
