<!--
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
</style>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>

	$("#content").on("load", function() {
		
		$("#content").contents().find("title").text();
		
		console.log("Load!");
	});
	
</script>
-->

<?php
// We'll be outputting a PDF
//header('Content-Type: application/pdf');

// The PDF source is in original.pdf

function curl_get($url, array $get = NULL, array $options = array())
{   
    $defaults = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_TIMEOUT => 30
    );
   
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_errno($ch));
    }
	
	var_dump(curl_getinfo($ch));
	
    curl_close($ch);
    return $result;
}

echo curl_get('https://www.wikipedia.org');

//readfile('http://ieeexplore.ieee.org/ielx7/6969845/6976043/06976078.pdf?tp=&arnumber=6976078&isnumber=6976043');
?>
