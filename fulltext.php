<iframe id="content" src="http://ieeexplore.ieee.org/ielx7/6969845/6976043/06976078.pdf?tp=&arnumber=6976078&isnumber=6976043"> </iframe>

<style>
	body {
		margin: 0;
		overflow: hidden;
	}
	
	#content {
		width: 100%;
		height: 100%;
	}
	
	div {
		background-color: yellow;
	}
	
</style>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>

	$("#content").on("load", function() {
		
		$("#content").html();
		
		console.log("Load!");
	});
	
</script>
