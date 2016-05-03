# jwplayer-1217

This application gathers two metrics for player performance: time to first frame (TTFF) and time to player ready (TTPR).
Two web pages (_let's call them emitters_), one for the HTML5 player and one for the Flash player are hosted on Google App Engine. 
These web pages emit the TTFF and TTPR metrics to Google Analytics via JavaScript. 

The emitters are periodically called from different parts of world using webpagetest.org. The webpagetest.org jobs are kicked off
by a cron job running from __Google App Engine__. See __cron.php__ and __cron.yaml__. 
there are three components to this metrics gathering system

1) webpagetest.org REST API
2) Google App Engine
3) This application code
