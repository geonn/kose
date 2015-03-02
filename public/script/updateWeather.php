<?php
UpdateWeatherInfo();

function UpdateWeatherInfo(){  
	/** URL path **/
	$listURL   = "http://travaguide.com/api/getAllLocation?user=webadmin&key=981bce3f4b506c6eb5473debb3275c27&skipSession=1";
	$updateURL = "http://travaguide.com/api/batchUpdateWeather?user=webadmin&key=981bce3f4b506c6eb5473debb3275c27&skipSession=1";
	
	
	//open connection
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $listURL);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);
	$result = json_decode($result);
	//close connection
	curl_close($ch);    
	
	
	/** Update List location's weather **/
	 
	$curl_options = array(
	    CURLOPT_URL => $updateURL,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => http_build_query( $result ),
	    CURLOPT_HTTP_VERSION => 1.0,
	    CURLOPT_RETURNTRANSFER => true,
	  );

	  $curl = curl_init();
	  curl_setopt_array( $curl, $curl_options );
	  $results = curl_exec( $curl );
	  $results = json_decode($results);
      echo $results ;
      curl_close( $curl );
      
}


?>