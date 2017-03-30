<?php

class HTTPRequestManager
{
	
	function request($url) {
		return file_get_contents($url);
	}
	
}