var include = require('../scripts/include.js');

QUnit.test("testProgressBarNotTooFast", function( assert ) {

	var done = assert.async();	
	
	var full = false;
	var progressbar = {
		value: 0,
		progressbar: function(one, two) {
			if (typeof one == "object") {
				progressbar.value = one.value;
			} else if (typeof two == "undefined") {
				return progressbar.value;
			} else {
				progressbar.value = two;
				
				assert.equal(false, full && two > 100, "progress bar doesn't reach full");

				full = two > 100;
			}
		},
		show: function() { }
	};	
	
	var completionHandler = false;
	include.startProgressBar(5000, progressbar, function () { return completionHandler; });

	setTimeout(function() {
		completionHandler = function() { done() };
	}, 5000);
});

QUnit.test("testProgressBarCallsCompletionHandler", function( assert ) {

	var done = assert.async();	
	

	var progressbar = {
		value: 0,
		progressbar: function(one, two) {
			if (typeof one == "object") {
				progressbar.value = one.value;
			} else if (typeof two == "undefined") {
				return progressbar.value;
			} else {
				progressbar.value = two;
			}
		},
		show: function() { }
	};	
	
	var completionHandler = false;
	include.startProgressBar(5000, progressbar, function () { return completionHandler; });

	setTimeout(function() {
		completionHandler = function() {
			assert.ok(true, "completion handler called");
			done()
		};
	}, 5000);
});
