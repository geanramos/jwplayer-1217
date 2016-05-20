<?php
	// This code gets called by Google App Engine's Cron mechanism. See "cron.yaml" in this project for schedule.

	// refer to https://sites.google.com/a/webpagetest.org/docs/advanced-features/webpagetest-restful-apis
	// for documentation related to REST API for webpagetest.

	require 'vendor/autoload.php';

	use GuzzleHttp\Client;

  function runTest($path, $client, $loc) {
		$response = $client->request('GET', 'http://www.webpagetest.org/runtest.php', [
				'query' => [
				'url' 		=> 'http://jwplayer-1217.appspot.com/'.$path,
				'k'   		=>  'A.2eac1a1250a8fb22d3459e67726a76e5',		// API key
				'video' 	=>  '1',										// capture video
				'fvonly'	=>  '1',										// first view only
				'location'	=>  $loc          				// the webpagetest.org POP
			]
		]);

		if ($response->getStatusCode() != 200) {
			syslog(LOG_ERR, "Bad HTTP Status code");
			print("Bad HTTP Status code<br>");
		} else {
			syslog(LOG_INFO, "Successful run.");
			print("Successful run: $path @ $loc<br>");
		}
	}

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

	// call the webpagetest.org runner from the different locations globally
	for ($i = 0; $i < $location_count; $i++) {
		runTest('flash', $client, $locations[$i]);
		runTest('html5', $client, $locations[$i]);
		runTest('dash', $client, $locations[$i]);
		runTest('mp4', $client, $locations[$i]);
		runTest('cdn-mp4', $client, $locations[$i]);
	}
?>
