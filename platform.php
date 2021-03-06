<!doctype html>
<?php
  $path = explode('/', $_SERVER['REQUEST_URI'])[1];
  $mediaid = 'sYKZyjxB';
  $playerid = $path == 'flash' ? 'keStX2EI' : 'WbTtnKtI';
  if ($path == 'mp4') {
    $mediaid = 'n1viIetj';
  } else if ($path == 'dash') {
    $mediaid = 'V3D2hVQR';
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>JW Player Test Page - Flash</title>
  <style>
        body {
            background: #eee;
            margin: 15px auto;
            width: 720px;
            font: 14px/20px Helvetica, Arial, sans-serif;
        }
        #botr_<?php echo $mediaid;?>_<?php echo $playerid;?>_div {
            background: gray;
            display: block;
            width: 640px;
            height: 360px;
        }
        #botr_<?php echo $mediaid;?>_<?php echo $playerid;?>_div.jwplayer {
            background: blue;
        }
    </style>
</head>
<body>
  <h1>JW Player Test Page</h1>
  <h2>Platform Embed Time: <span id="platform-load-and-embed-time">calculating...</span>ms</h2>
  <h2>Player Setup (part of platform embed): <span id="player-setup-time">calculating...</span>ms</h2>
  <h2>Player First Frame: <span id="player-first-frame-time">calculating...</span>ms</h2>
  <h2>Played Past First Frame: <span id="player-first-frame-past">calculating...</span>ms</h2>
  <h2>Provider: <span id="player-provider">loading...</span></h2>
  <div id="botr_<?php echo $mediaid;?>_<?php echo $playerid;?>_div"></div>
  <script>
    var startTime = performance.now();
    console.time('load-embed');
  </script>
  <script src="//content.jwplatform.com/players/<?php echo $mediaid;?>-<?php echo $playerid;?>.js"></script>
  <script>
  (function() {
    var embedTime = performance.now() - startTime;
    console.timeEnd('load-embed');
    console.time('setup');
    var jwVersion = jwplayer.version.split('+')[0];
    var config = jwplayer().getConfig();
    var mediaType = config.playlist[0].sources[0].type;
    var playerEventLabel = `primary-${config.primary||"none"}-${mediaType}-${jwVersion}`;
    var timeSinceScriptEmbed;

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-49334106-2', 'auto');
    ga('send', 'pageview');

    ga('send', 'event', 'player-metric', 'embed', 'platform-load-and-embed-time-' + playerEventLabel, embedTime);

    jwplayer()
    .on('ready', function(event){
      console.timeEnd('setup');
      //ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]);
      ga('send', 'event', 'player-metric', 'setup', 'player-setup-time-' + playerEventLabel, event.setupTime);

      // Legacy metric measured from time before platform one-line embed
      timeSinceScriptEmbed = performance.now() - startTime;
      ga('send', 'event', 'legacy-metric', 'total-setup-time', 'total-setup-time-' + playerEventLabel, timeSinceScriptEmbed);

      document.getElementById('platform-load-and-embed-time').textContent = embedTime.toFixed(1);
      document.getElementById('player-setup-time').textContent = event.setupTime;
    })
    .on('playAttempt', function(event){
      console.time('load-video');
    })
    .on('play', function(event){
      console.timeStamp('playing');
    })
    .on('firstFrame', function(event) {
      console.timeEnd('load-video');
      var provider = this.getProvider();
      playerEventLabel += '-' + provider.name;

      ga('send', 'event', 'player-metric', 'first-frame', 'player-first-frame-time-' + playerEventLabel, event.loadTime);

      // Legacy metric measured from time before platform one-line embed
      timeSinceScriptEmbed = performance.now() - startTime;
      ga('send', 'event', 'legacy-metric', 'total-time-to-first-frame', 'total-time-to-first-frame-' + playerEventLabel, timeSinceScriptEmbed);

      var video = document.getElementsByTagName('video')[0];
      var currentTimeMS = (video ? (video.currentTime) : this.getPosition()) * 1000;
      ga('send', 'event', 'provider-metric', 'current-time', 'player-first-frame-past-' + playerEventLabel , currentTimeMS);

      document.getElementById('player-first-frame-time').textContent = event.loadTime;
      document.getElementById('player-first-frame-past').textContent = currentTimeMS;
      document.getElementById('player-provider').textContent = provider.name;
    })
    // Add timestamps in dev tools timeline for all events:
    // .on('all', function(type, e) {
    //   console.timeStamp(type);
    // })
    ;
  })();
  </script>
</body>
</html>
