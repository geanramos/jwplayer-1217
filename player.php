<!doctype html>
<?php
  $path = explode('/', $_SERVER['REQUEST_URI'])[1];
  $mediaid = 'n1viIetj';
  $playerid = '7.4.2';
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
        #cdn_<?php echo $mediaid;?>_<?php echo $playerid;?>_div {
            background: gray;
            display: block;
            width: 640px;
            height: 360px;
        }
        #cdn_<?php echo $mediaid;?>_<?php echo $playerid;?>_div.jwplayer {
            background: blue;
        }
    </style>
</head>
<body>
  <h1>JW Player Test Page</h1>
  <h2>CDN Embed Time: <span id="platform-load-and-embed-time">calculating...</span>ms</h2>
  <h2>Player Setup: <span id="player-setup-time">calculating...</span>ms</h2>
  <h2>Player First Frame: <span id="player-first-frame-time">calculating...</span>ms</h2>
  <h2>Played Past First Frame: <span id="player-first-frame-past">calculating...</span>ms</h2>
  <h2>Provider: <span id="player-provider">loading...</span></h2>
  <div id="player_div"></div>
  <script>
    var startTime = performance.now();
    console.time('load-embed');
  </script>
  <script src="//ssl.p.jwpcdn.com/player/v/<?php echo $playerid;?>/jwplayer.js"></script>
  <script>
  (function() {
    var embedTime = performance.now() - startTime;
    console.timeEnd('load-embed');

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-49334106-2', 'auto');
    ga('send', 'pageview');

    console.time('setup');
    jwplayer('player_div').setup({
      "key": "GN5EiOaKgrcVjgBo7+dpEpM+le73uOPNEc85JePA3zYHCn5B5hE+u8OXIhA=",
      "preload": "none",
      "width": 640,
      "height": 360,
      "autostart": true,
      "displaydescription": true,
      "displaytitle": true,
      "mute": false,
      "playlist": [
        {
          "title": "caminandes-3-360p mp4",
          "image": "//content.jwplatform.com/thumbs/n1viIetj-720.jpg",
          "sources": [
            {
              "file": "http://content.jwplatform.com/videos/sYKZyjxB-mjpS2Ylx.mp4",
              "type": "video/mp4"
            }
          ]
        }
      ],
      "related": {
        "autoplaytimer": 5,
        "file": "http://content.jwplatform.com/related6/MEDIAID.xml",
        "onclick": "play",
        "oncomplete": "autoplay",
        "recommendations": "http://recommend-api.jwplayer.com/aanbevolen/v1/MEDIAID.json"
      },
      "sharing": {
        "link": "http://content.jwplatform.com/previews/MEDIAID-WbTtnKtI",
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
