<?php
UpdateFeaturedLocation();

function UpdateFeaturedLocation(){  
	/** URL path **/
	$updateURL = "http://travaguide.com/api/batchUpdateFeaturedLocation?user=webadmin&key=981bce3f4b506c6eb5473debb3275c27&skipSession=1";

	//open connection
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $updateURL);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);
	$result = json_decode($result);
	//close connection
	curl_close($ch);          
}
?>