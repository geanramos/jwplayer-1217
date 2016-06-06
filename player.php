<!doctype html>
<?php
  $path = explode('/', $_SERVER['REQUEST_URI'])[1];
  $mediaid = 'qduUCkEw';
  $playerid = 'QZTYYXcn';
  $titleid = 'My Movie';
?>
<!--Ex: https://geanramos.github.io/jwplayer/player.html-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $titleid;?></title>
  <style>
  @import url(https://fonts.googleapis.com/css?family=Lato:400,300,300italic);
    body {
        background: #eee;
        max-width: 500px;
        font-family: 'Lato', sans-serif;
        font-size: 13px;
        line-height: 0.8;
        text-align: left;
    }
    #cdn_<?php echo $mediaid;?>-<?php echo $playerid;?>_div {
        background: gray;
        display: block;
        width: 500px;
        height: 281px;
    }
    #cdn_<?php echo $mediaid;?>-<?php echo $playerid;?>_div.jwplayer {
        background: blue;
    }
    </style>
</head>
<body>
  <h1><?php echo $titleid;?> - Test Page</h1><p>
  <p><strong>CDN Embed Time: <span id="platform-load-and-embed-time">calculating...</span>ms</strong></p>
  <p><strong>Player Setup: <span id="player-setup-time">calculating...</span>ms</strong></p>
  <p><strong>Player First Frame: <span id="player-first-frame-time">calculating...</span>ms</strong></p>
  <p><strong>Played Past First Frame: <span id="player-first-frame-past">calculating...</span>ms</strong></p>
  <p><strong>Provider: <span id="player-provider">loading...</span></strong></p>
  <div id="player_div"></div>
  <script>
    var startTime = performance.now();
    console.time('load-embed');
  </script>
  <script src="//content.jwplatform.com/players/<?php echo $mediaid;?>-<?php echo $playerid;?>.js"></script>
  <script>
  (function() {
    var embedTime = performance.now() - startTime;
    console.timeEnd('load-embed');
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-12345678-9', 'auto');
    ga('send', 'pageview');
    console.time('setup');
    jwplayer('player_div').setup({
      "key": "GH7G+KFIVMF7EWjhG/giE9ckzCcL6YgUVLqpuoN8X7j3kAPDDUzZCMnAlfI=",
      "preload": "none",
      "width": 500,
      "height": 281,
      "autostart": true,
      "displaydescription": true,
      "displaytitle": true,
      "mute": false,
      "playlist": [
        {
          "title": "<?php echo $titleid;?>",
          "image": "//content.jwplatform.com/thumbs/<?php echo $mediaid;?>-720.jpg",
          "sources": [
            {
              "file": "//content.jwplatform.com/videos/<?php echo $mediaid;?>-480.mp4",
              "type": "video/mp4"
            }
          ]
        }
      ],
      "related": {
        "autoplaytimer": 5,
        "file": "http://content.jwplatform.com/related6/<?php echo $mediaid;?>.xml",
        "onclick": "play",
        "oncomplete": "autoplay",
        "recommendations": "http://recommend-api.jwplayer.com/aanbevolen/v1/<?php echo $mediaid;?>.json"
      },
      "sharing": {
        "link": "http://content.jwplatform.com/previews/<?php echo $mediaid;?>",
        "sites": [
          "facebook",
          "twitter",
          "email"
        ]
      }
    });
    var jwVersion = jwplayer.version.split('+')[0];
    var config = jwplayer().getConfig();
    var mediaType = config.playlist[0].sources[0].type;
    var playerEventLabel = `primary-${config.primary||"none"}-${mediaType}-${jwVersion}`;
    var timeSinceScriptEmbed;
    ga('send', 'event', 'player-metric', 'embed', 'player-load-and-embed-time-' + playerEventLabel, embedTime);
    jwplayer()
    .on('ready', function(event){
      console.timeEnd('setup');
      //ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]);
      ga('send', 'event', 'player-metric', 'setup', 'player-setup-time-' + playerEventLabel, event.setupTime);
      // Legacy metric measured from time before embed
      timeSinceScriptEmbed = performance.now() - startTime;
      ga('send', 'event', 'legacy-metric', 'total-setup-time-cdn', 'total-setup-time-' + playerEventLabel, timeSinceScriptEmbed);
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
      // Legacy metric measured from time before embed
      timeSinceScriptEmbed = performance.now() - startTime;
      ga('send', 'event', 'legacy-metric', 'total-time-to-first-frame-cdn', 'total-time-to-first-frame-' + playerEventLabel, timeSinceScriptEmbed);
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
