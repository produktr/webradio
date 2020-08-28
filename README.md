# Webradio
Simple php file webradio.  
Except image files, this README.md and the hls library all code is kept in one single file (index.php contains all css/html/js/php).  

Why? Shits and giggles...  
Drawbacks? All of them... (more to load)

### How does it look

![preview](preview.png)  
[See it in action](http://pointwood.pw/webradio)

### Stations
Add stations directly into index.php $stations object:  
    `groupname => [ station_name => [ url, init_volume, type ] ]`  

The page relies on functional cookies to determine the element visibility and to remember volume settings.  
The page does not use asynchronous methods meaning everytime a station is selected the page gets reloaded.

### Hls type
https://github.com/dailymotion/hls.js is used to play stations using HLS. Add 'hls' as type to the station info.  

### Oscilloscope visuals
Uses web audio api and canvas to create oscilliscope.  

### CORS
Not all sources have the header Access-Control-Allow-Origin set.  
To circumvent CORS restrictions you could set up a reverse proxy:  

Apache 2 config example:  
	`# Proxy for circumventing CORS restrictions (webradio)`
	`ProxyPassMatch ^/c_cors/(.*)$ http://$1`
	`Header set Access-Control-Allow-Origin "*"`

Configuration (top of index file):  
	`define('C_CORS', true); // circumvent CORS (use proxy)`  
Set to false when not using a proxy  

When no reverse proxy is set, the visuals won't work.

### Mobile
Page is not ~really~ mobile friendly. 
Also audio only starts playing after the user taps the play/pause button.  


