# Webradio
Simple webradio

### Stations
Add stations directly into index.php $stations object:  
    `groupname => [ station_name => [ url, init_volume, type ] ]`

The radio uses cookies to determine wich elements are hidden and to remember volume settings.

### Hls 
https://github.com/dailymotion/hls.js is used to play stations using this method. Add 'hls' as type.
