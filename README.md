# Webradio
Simple php webradio.
Except image files, this README.md and the hls library all code must be kept in one single file (index.php contains all css/html/js/php).

Why? Shits and giggles...

### How does it look

![preview](preview.png)
[See it in action](http://pointwood.pw/webradio)

### Stations
Add stations directly into index.php $stations object:  
    `groupname => [ station_name => [ url, init_volume, type ] ]`

The radio uses cookies to determine element visibility and volume settings.

### Hls type
https://github.com/dailymotion/hls.js is used to play stations using this method. Add 'hls' as type.

### Mobile
Page is not quite mobile friendly. Also audio only starts playing after the user clicks the play/pause button.
