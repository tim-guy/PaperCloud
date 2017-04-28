
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
