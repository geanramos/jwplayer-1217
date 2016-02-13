<?php
	require 'vendor/autoload.php';
	
	use GuzzleHttp\Client;
		
	$locations = array(
	    "Dulles:Chrome", 
	    "ec2-us-east-1:Chrome",  
	    "ec2-us-west-1:Chrome",  
	    "ec2-us-west-2:Chrome",  
	    "ec2-eu-central-1:Chrome",  
	    "ec2-ap-northeast-1:Chrome",  
	    "ec2-ap-southeast-1:Chrome",  
	    "ec2-ap-southeast-2:Chrome",  
	    "ec2-sa-east-1:Chrome" 
	);
	
	$client = new Client();
	
	$location_count = count($locations);
	for ($i = 0; $i < $location_count; $i++) {
	    //echo $locations[$i] . "\n" ;
		$response = $client->request('GET', 'http://www.webpagetest.org/runtest.php', [
		    'query' => [
				'url' 		=> 'http://jwplayer-1217.appspot.com', 
				'k'   		=>  'A.2eac1a1250a8fb22d3459e67726a76e5',
				'video' 	=>  '1',
				'fvonly'	=>  '1',
				'location'	=>  $locations[$i]
			]
		]);
		
		if ($response->getStatusCode() != 200) {
			syslog(LOG_ERR, "Bad HTTP Status code");
			print("Bad HTTP Status code\n");
		} else {
			syslog(LOG_INFO, "Successful run.");
			print("Successful run.\n");
		}
	}
?>