<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>JW Player Test Page - HTML5</title>
    </head>
    <body>
        <h1>
		<?php
		echo "JW Player Test Page - HTML5";
		?>
	</h1>

		<p>Last updated: 2016-02-11</p>

		<script>
		var startTime = new Date();
		</script>

		<script src="//content.jwplatform.com/players/sYKZyjxB-WbTtnKtI.js"></script>

		<br/>

		<h2 id="time_to_player_ready">Time to Player Ready: calculating...</h2>
		<h2 id="time_to_first_frame">Time to First Frame: calculating...</h2>

    <script>
  		var playerInstance = jwplayer();

  		playerInstance.on('firstFrame', function(event){
  			var endTime = new Date();
  			var loadTime = endTime.getTime() - startTime.getTime();

  			console.log(loadTime);
  			//ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]);
  			ga('send', 'event', 'JW Player Video', 'metric', 'time-to-first-frame', loadTime);

  			document.getElementById('time_to_first_frame').innerHTML = "Time to First Frame:  " + loadTime + " milliseconds";
  		});

  		playerInstance.on('ready', function(event){
  			var endTime = new Date();
  			var loadTime = endTime.getTime() - startTime.getTime();

  			console.log(loadTime);
  			//ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]);
  			ga('send', 'event', 'JW Player Video', 'metric', 'time-to-player-ready', loadTime);

  			document.getElementById('time_to_player_ready').innerHTML = "Time to Player Ready:  " + loadTime + " milliseconds";
  		});

		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-49334106-2', 'auto');
		  ga('send', 'pageview');

		</script>
    </body>
</html>
