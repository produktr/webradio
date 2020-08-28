<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');
define('C_CORS', true);
define('C_CORS_NOWPLAYING_URL', 'https://cors.io/?');
if (isset($_POST['station'])) {
    $x = explode("%SPLIT%", $_POST['station']);
    $s_group = $x[0];
    $s_station = $x[1];
}
if (!isset($_COOKIE['scroll'])) {
    $_COOKIE['scroll'] = 0;
}
echo    <<<HERE
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>%TITLE%</title>
            <link rel="shortcut icon" href="favicon.ico" />
            <style>
                *{
                    -webkit-user-select: none; /* Chrome/Safari */
                    -moz-user-select: none; /* Firefox */
                    -ms-user-select: none; /* IE10+ */
                    /* Rules below not implemented in browsers yet */
                    -o-user-select: none;
                    user-select: none;
                }
                body{
                    background-color: black;
                }
                #ineedtohold{
                    height: 99vh;
                    position: relative;
                }
                #container{
                    margin: 0;
                    position: absolute;
                    top: 25%;
                    left: 50%;
                    -ms-transform: translate(-50%, -25%);
                    transform: translate(-50%, -25%);
                    width: 500px;
                    max-height: 90vh;
                    background-color: #EAEAF7;
                    padding: 24px;
                    padding-top: 0px;
                    border-top: 10px solid lightgray;
                    border-right: 10px solid gray;
                    border-bottom: 10px solid gray;
                    border-left: 10px solid lightgray;
                }
                pre.date{
                    padding: 0px;
                    height: 3px;
                    color: gray;
                    margin-bottom: 20px;
                    font-size: 80%;
                }
                div.group{
                    padding: 0px;
                }
                span.group{
                    border-width: 1px 1px 0px 1px;
                    border-style: solid;
                    border-color: black;
                    font-size: 85%;
                    width: 80%;
                    display: block;
                    margin-top: 1%;
                    margin-left: auto;
                    margin-right: auto;
                    text-align: center;
                    text-decoration: none;
                    font-family: Arial;
                    font-weight: bold;
                    position: relative;
                    background-color: none;
                }
                .group{
                    overflow: hidden;
                    max-height: 10000px;
                    transition: max-height 0.5s ease;
                }
                .group.hidden{
                    max-height: 0px;
                    transition: max-height 0.2s ease;
                }
                span.group.click:hover{
                    background-color: #C781E3;
                }
                span.group.click:after{
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    width: 93%;
                    border-width: 0px 14px 0px 14px;
                    border-color: #3498DB;
                    border-style: solid;
                    content: "";
                    display: block;
                }
                span.group.click:hover:after{
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    width: 99%;
                    border-width: 2px 2px 0px 2px;
                    border-color: #EAEAF7;
                    border-style: solid;
                    content: "";
                    display: block;
                }
                span.subgroup {
                    font-size: 60%;
                    width: 70%;
                    display: block;
                    margin-top: 1%;
                    margin-left: auto;
                    margin-right: auto;
                    text-align: left;
                    text-decoration: none;
                    font-family: Arial;
                    font-style: oblique;
                }
                .channels{
                    font-size: 120%;
                }
                #channels{
                    overflow-y: scroll;
                    overflow-x: hidden;
                    max-height: 55vh;
                    transition: max-height 0.8s ease;
                }
                #channels.hidden{
                    overflow: hidden;
                    max-height: 0px;
                    transition: max-height 0.8s ease;
                }
                .click{
                    cursor: pointer;
                }
                button.station{
                    width: 75%;
                    border: none;
                    color: white;
                    margin-top: 2px;
                    margin-left: auto;
                    margin-right: auto;
                    padding: 15px32px;
                    text-align: center;
                    text-decoration: none;
                    background-color: #4CAF50;
                    display: block;
                    position: relative;
                }
                button.station:not(.stop):hover:after{
                    position:absolute;
                    top:0;
                    bottom:0;
                    left:0;
                    width: 100%;
                    border-width: 1px 1px 1px 1px;
                    border-color: #EAEAF7;
                    border-style: solid;
                    content: "";
                    display: block;
                }
                button.station:hover{
                    font-weight: bold;
                }
                .station.active{
                    background-color:#EE7600;
                }
                button.stop{
                    position: relative;
                    margin-left: 24%;
                    width: 50%;
                    margin-top: 2%;
                    background-color: #DD2724;
                }
                button.stop:after{
                    position: absolute;
                    top: -8px;
                    left: 10%;
                    right: 10%;
                    content: "";
                    height: 1px;
                    width: 80%;
                    display: block;
                    border-top: 1px dashed black;
                }
                pre{
                    width: 80%;
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                    text-align: center;
                }
                #nowplaying{
                    overflow: hidden;
                    text-transform: capitalize;
                }
                #audiocontrol{
                    display: flex;
                    justify-content: space-between;
                    width: 36%;
                    margin-left: auto;
                    margin-right: auto;
                }
                .control{
                    height: 24px;
                    width: 24px;
                    display: inline-block;
                    margin-left: 1%;
                    margin-right: 1%;
                    background-size: contain;
                }
                .control:hover{
                    box-shadow: 1px 1px 2px #888888;
                }
                #play{
                    background-image: url(play.svg);
                }
                #pause{
                    background-image: url(pause.svg);
                }
                #mute{
                    background-image: url(muted.svg);
                }
                #unmute{
                    background-image: url(unmuted.svg);
                }
                #volume{
                    height: 16px;
                    width: 100px;
                    display: inline-block;
                    margin-left: 1%;
                    margin-right: 1%;
                    border: none;
                }
                img{
                    display: block;
                    margin-top: 12px;
                    margin-left: auto;
                    margin-right: auto;
                    width: 25%;
                }
                #osc{
                    display: block;
                    margin-top: 12px;
                    width: 75%;
                    height: 75px;
                    margin-left: auto;
                    margin-right: auto;
                    border-top: 5px solid gray;
                    border-right: 5px solid lightgray;
                    border-bottom: 5px solid lightgray;
                    border-left: 5px solid gray;
                }
                pre.footer{
                    padding: 0px;
                    height: 3px;
                    color: gray;
                    margin-bottom: 0px;
                    font-size: 50%;
                }
                .switch {
                    position: relative;
                    display: inline-block;
                    width: 30px;
                    height: 17px;
                }
                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }
                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    border-radius: 17px;
                    bottom: 0;
                    background-color: #ccc;
                    -webkit-transition: .4s;
                    transition: .4s;
                }
                .slider:before {
                    position: absolute;
                    content: "";
                    height: 13px;
                    width: 13px;
                    left: 2px;
                    border-radius: 50%;
                    bottom: 2px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                }
                input:checked + .slider {
                    background-color: #2196F3;
                }
                input:focus + .slider {
                    box-shadow: 0 0 1px #2196F3;
                }
                input:checked + .slider:before {
                    -webkit-transform: translateX(13px);
                    -ms-transform: translateX(13px);
                    transform: translateX(13px);
                }
                .slider::after {
                    content:"Disable background animation";
                    position: absolute;
                    top: 12%;
                    left: 120%;
                    width: 1000%;
                    font-size: 75%;
                    color: gray;
                    font-family: Consolas,monospace;
                }
            </style>
            <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.min.js"></script>
        </head>
HERE;

$stations = [
    '70/80/90/00s' => [
        '70s' => '--------------------------------------------------',
            'Left Coast 70s' => [
                'http://ice1.somafm.com/seventies-128-aac',
                '',
                'rtp',
                [
                    'url' => 'https://somafm.com/songs/seventies.xml',
                    'type' => 'xml',
                    'title' => 'title',
                    'artist' => 'artist'
                ]
            ],
        '80s' => '--------------------------------------------------',
        //'80s #1' =>
        //    [ 'http://50.7.76.254:9908/;stream/1', '0.8', 'rtp'],
        '181-80s' =>
            [ 'http://listen.181fm.com/181-lite80s_128k.mp3', '', 'rtp'],
        '181.fm - Awesome 80s' =>
            [ 'http://uplink.duplexfx.com:8000/;', '', ''],
        '1000 HITS 80s' =>
            [ 'http://91.121.155.204:8048/;stream/1', '', 'rtp'],
        'KLUV radio' => 
            ['https://playerservices.streamtheworld.com/api/livestream-redirect/KLUVFM.mp3', '', 'rtp'],

        '90s' => '--------------------------------------------------',
        '90s #1 fm' =>
            [ 'http://19353.live.streamtheworld.com/977_90_SC', '', 'rtp'],
        //'90s Radio 10' =>
        //    [ 'http://vip-icecast.538.lw.triple-it.nl/WEB22_MP3', '', 'rtp'],

        '00s' => '----------------------------------------------------',
        '2000 FM' => [ 'http://bigrradio-edge1.cdnstream.com/5106_128', '', 'rtp'],
    ],

    //'Rock' => [
        //'Classic' => '------------------------------------------------',
            //'Arrow' => [
            //    'http://91.221.151.155/;?allradio.nl&1501067066',
            //    '',
            //    'rtp',
            //    [
            //        'url' => 'https://player.arrow.nl/index.php?c=Arrow%20Classic%20Rock',
            //        'type' => 'json',
            //        'title' => 'title',
            //        'artist' => 'artist'
            //    ]
            //],
            //'Classic Rock Florida' =>
            //    [ 'http://us2.internet-radio.com/proxy/classicrock160?mp=/;', '', 'rtp'],
            //'Classic Rock Planet' =>
            //    [ 'http://uk6.internet-radio.com:8022/;stream', '', 'rtp'],
            //'Classic Rock New York' =>
            //    [ 'http://us2.internet-radio.com:8351/;stream', '', 'rtp'],
            //'Classic Rock Miami' =>
            //    [ 'http://us2.internet-radio.com/proxy/classicrockmiamiplus?mp=/;', '', 'rtp'],
            //'Disco Classic Radio' =>
            //    [ 'http://discoclassicradio.shoutcaststream.com:8312/stream;?allradio.nl&1501067121', '', 'rtp'],
    //],

    'Electronic' => [
        'House' => '--------------------------------------------------',
        'Deephouse' =>
            ['http://198.15.94.34:8006/stream', '', 'rtp'],
        //'Dogglounge Deep House Radio' =>
        //    [ 'http://master.dogglounge.com:9128/;', '0.5', 'rtp'],
        'Beatblender' =>
            ['http://ice1.somafm.com/beatblender-128-aac', '', 'rtp'],
        'The Trip' => [
            'http://ice1.somafm.com/thetrip-128-mp3',
            '0.8',
            'rtp',
            [
                'url' => 'https://somafm.com/songs/thetrip.xml',
                'type' => 'xml',
                'title' => 'title',
                'artist' => 'artist'
            ]
        ],
        'Techno' => '-------------------------------------------------',
        'Technomania' =>
            [ 'http://stream.nauticradio.net:14240/;', '', 'rtp'],

        'Downtempo' => '----------------------------------------------',
        'Groove Salad' =>
            ['http://ice1.somafm.com/groovesalad-128-aac', '', 'rtp'],

        'Dubstep' => '------------------------------------------------',
        'Dubstep #1' =>
            [ 'http://stream.dubbase.fm:7002/;', '0.6', 'rtp'],

        'Drum n Bass' => '--------------------------------------------',
        'Beats n Breaks' =>
            [ 'http://stream.nauticradio.net:14280/;', '', 'rtp'],
        //'DnB Liquified' =>
        //   [ 'http://st8.webradioworld.net:8000/;', '', 'rtp'],
        'DnB Jungle' =>
            [ 'http://trace.dnbradio.com/dnbradio_main.mp3', '0.9', 'rtp'],

        //'Tekno' => '--------------------------------------------------',
        //'Tekno #1' =>
        //    [ 'http://channel1.teknoradio.nl:8064/;', '', 'rtp'],
        //'Tekno #2' =>
        //    [ 'http://channel2.teknoradio.nl:8126/;', '', 'rtp'],
        //'Tekno #3' =>
        //    [ 'http://channel3.teknoradio.nl:8124/;', '', 'rtp'],

        'French / Hardcore' => '---------------------------------------',
        'HardcoreNL' =>
            [ 'http://81.18.165.235/;', '0.8', ''],
        'HardcorePower' =>
            [ 'http://src.shoutcaststream.com:8022/;', '', 'rtp'],
        'Frenchcore' =>
            ['http://frenchcore24fm.nl/radiostation/index.php/stream', '', 'rtp'],
            // first generate link with above
            
            //['http://frenchcore24fm.nl/radiostation/webstream/1596122256.php', '', 'rtp'],
            // starts on the same point over and over
        //'NERadio Hardstyle' =>
        //    [ 'http://1.hardstyle.nu:443/;', '', 'rtp'],
        //'Gabber FM' =>
        //    [ 'http://streaming.radionomy.com/Gabberfm?lang=en-GB%2cen-US%3bq%3d0.8%2cen%3bq%3d0.6', '0.6', 'rtp'],
    ],

    'Regular' => [
        'Dutch' => '--------------------------------------------------',
        '3FM Alternative' =>
            [ 'http://icecast.omroep.nl/3fm-alternative-mp3', '', 'rtp'],
        'Studio 040' => [
            'https://stream.studio040.nl/studio040.aac', '', 'rtp'],
        'Next Movement' =>
            [ 'http://stream.nauticradio.net:14230/;', '', 'rtp'],
        'Vodoo Gospel' =>
            [ 'http://stream.nauticradio.net:14260/;', '0.9', 'rtp'],
        'Zwarte Hemel' =>
            [ 'http://stream.nauticradio.net:14220/;', '', 'rtp'],

        'International' => '------------------------------------------',
        'ANTENNE BAYERN 80s' => [
            'https://s8-webradio.webradio.de/80er-kulthits', '', 'rtp'],
        'CLASSICS HITS' => [
            'https://edge.audioxi.com/CLASSIC', '', 'rtp'],
        'NSBRadio.co.uk' =>
            [ 'http://live.nsbradio.co.uk:7904/;', '', 'rtp'],
        'FM4 - ORF' =>
            [ 'http://mp3stream1.apasf.apa.at:8000/;', '', 'rtp'],
        //'WDR4' =>
        //    [ 'http://wdr-wdr4-live.cast.addradio.de/wdr/wdr4/live/mp3/128/stream.mp3', '', 'rtp'],
        //'Radio Waf' =>
        //    [ 'http://mp3.radiowaf.c.nmdn.net/radiowaf/livestream.mp3', '', 'rtp'],
    ],
    'Other' => [
        'Generation Soul Disco Funk' =>
            [ 'http://event.generationdiscofunk.com:8000/;', '0.7', ''],
        //'Disco Paradise' =>
        //    ['http://144.217.129.213:9122/;*.mp3', '', ''],
        //'B4B' =>
        //    ['http://b4bdiscofunk.ice.infomaniak.ch/b4bdiscofunk-128.mp3', '0.7', ''],
        'STOMP' =>
            ['http://149.255.59.162:8064/live', '0.9', ''],
        //'Vaporwave #1' =>
        //    [ 'https://plaza.one/mp3', '', 'rtp'],
        'Poolside' =>
            [ 'http://stream.radio.co/s98f81d47e/listen', '0.7', 'rtp'],
        //'Lounge' =>
        //    [ 'http://listen.radionomy.com/;', '','rtp'],
        'Lagrosse Reggae' =>
            ['http://ice2.lagrosseradio.info/lagrosseradio-reggae-192.mp3', '', 'rtp'],
        'Seeburg 1000' =>
            ['http://74.82.59.197:8351/1?cb=762044.mp3', '', 'rtp']
    ],
];

    //function getMp3StreamTitle($streamingUrl, $interval, $offset = 0, $headers = true)
    //{
        //$needle = 'StreamTitle=';
        //$ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36';

        //$opts = array('http' => array(
                //'method' => 'GET',
                //'header' => 'Icy-MetaData: 1',
                //'user_agent' => $ua
            //)
        //);

        //if (($headers = get_headers($streamingUrl))) {
            //foreach ($headers as $h) {
                //$currentSection = explode(':', $h);
                //if (strpos(strtolower($h), 'icy-metaint') !== false && ($interval = $currentSection[1])) {
                    //break;
                //}
            //}
        //}
        //$context = stream_context_create($opts);

        //if ($stream = fopen($streamingUrl, 'r', false, $context)) {
            //$buffer = stream_get_contents($stream, $interval, $offset);
            //fclose($stream);

            //if (strpos($buffer, $needle) !== false) {
                //$currentSectionTwo = explode($needle, $buffer);
                //$title = $currentSectionTwo[1];
                //return substr($title, 1, strpos($title, ';') - 2);
            //} else {
                //return getMp3StreamTitle($streamingUrl, $interval, $offset + $interval, false);
            //}
        //} else {
            ////throw new Exception("Unable to open stream [{$streamingUrl}]");
        //}
    //}

    //$nnowpplating = getMp3StreamTitle($stations[$s_group][$s_station][0], 19200);
    //echo "<h1 style='color:white'>$nnowpplating</h1>";

echo <<<HERE
    <script>
        function setChannelVisibility(el)
        {
            var channels = document.getElementById('channels');
            var status = el.getAttribute('data-status');
            if (status === 'visible') {
                channels.className = 'hidden';
                el.setAttribute('data-status', 'hidden');
                el.innerHTML = '<b>Stations:</b> [⇣]';
            } else {
                channels.className = '';
                el.setAttribute('data-status', 'visible');
                el.innerHTML = '<b>Stations:</b> [⇡]';
            }
        }
    </script>

    <script>
        function setGroupVisibility(el)
            {
            var status = el.getAttribute('data-status');
            var name = el.innerHTML;
            var group = el.nextSibling;
            if (status === 'visible') {
                group.className = 'group hidden';
                el.setAttribute('data-status', 'hidden');
                document.cookie = name+'=hidden';
            } else {
                group.className = 'group';
                el.setAttribute('data-status', 'visible');
                document.cookie = name+'=visible';
            }
        }
    </script>

    <script>
        function setScrollPosition(action)
        {
            var ch = document.getElementById('channels');
            if (action === 'save') {
                document.cookie = 'scroll='+ch.scrollTop;
            } else {
                ch.scrollTop = {$_COOKIE['scroll']};
            }
        }
    </script>
    
    <script>
        function setBackgroundAnimationCookie(el)
        {
            if (el.checked == true) {
                document.cookie = 'stopBackgroundAnimation=true';
            } else {
                document.cookie = 'stopBackgroundAnimation=false';
                setBackgroundAnimation();
            }
        }
    </script>
HERE;

$checkedAttribute = 'checked';
if (!isset($_COOKIE['stopBackgroundAnimation']) || $_COOKIE['stopBackgroundAnimation'] == 'false') {
    $checkedAttribute = '';
    setcookie('stopBackgroundAnimation', false);
}
$date = date('l d M Y');
echo <<<HERE
    <body>
    <div id='ineedtohold'>
        <div id='container'>
            <pre class='date'>Page loaded on: {$date}</pre>
            <pre>{$selected}</pre>
            <label class="switch">
                <input type="checkbox" onclick="setBackgroundAnimationCookie(this)" {$checkedAttribute}>
                <span class="slider"></span>
            </label>
            <pre class='channels click' onclick='setChannelVisibility(this)' data-status='visible'><b>Stations:</b> [⇡]</pre>
            <form id='channels' method='post' onsubmit="setScrollPosition('save')" >
HERE;
foreach ($stations as $group => $station) {
    if (!isset($_COOKIE[$group])) {
        setcookie($group, 'hidden');
        $_COOKIE[$group] = 'hidden';
    }
    echo "<span class='group click' onclick='setGroupVisibility(this)' data-status='{$_COOKIE[$group]}'>{$group}</span>";
    echo "<div class='group {$_COOKIE[$group]}'>";
    foreach ($station as $name => $data) {
        $class = '';
        if (!is_array($data)) {
            echo "<span class='subgroup'>- {$name} -</span>";
            continue;
        }
        if (isset($s_station) && $s_station === $name && $s_group === $group) {
            $class .= ' active';
        }
        echo "<button class='click station {$class}' name='station' value='{$group}%SPLIT%{$name}'>{$name}</button>";
    }
    echo "</div>";
}
echo "</form>";
echo "<form method='post' onsubmit=\"setScrollPosition('save')\" ><button class='click station stop' name='station' value='stop%SPLIT%stop'>stop</button></form>";

$buffer = ob_get_contents();
ob_end_clean();
$controls = '';
if (isset($s_group) && isset($s_station)) {
    if ($s_station === 'stop') {
        $buffer = preg_replace('/%TITLE%/i', 'Radio - stopped', $buffer);
        echo $buffer;
        echo "<pre>Please select radio a station</pre>";
    } else {
        $buffer = preg_replace('/%TITLE%/i', $s_station, $buffer);
        echo $buffer;
        echo "<pre id='stationinfo'>Loading... {$s_station}</pre>";
        $location = $stations[$s_group][$s_station][0];
        if (C_CORS) {
            $location = '/c_cors/'.preg_replace('/http[s]?:\/\//', '', $location);
        }
        $volume = $stations[$s_group][$s_station][1];
        $type = $stations[$s_group][$s_station][2];
        if (!isset($volume) || $volume === '') {
            $volume = 1;
        }
        if (isset($_COOKIE['volume'])) {
            $set_volume = $_COOKIE['volume'];
            $volume = ($set_volume / 1) * $volume;
        }
echo "<pre id='nowplaying'></pre>";
        if ($stations[$s_group][$s_station][3]) {
            $urlextension = C_CORS_NOWPLAYING_URL;
            $nowplaying = <<<EOL
                <script>
                    function getNowPlaying()
                    {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                type = "{$stations[$s_group][$s_station][3]['type']}";
                                switch (type) {
                                    case 'json':
                                        var jsonresponse = JSON.parse(this.responseText);
                                        document.getElementById("nowplaying").innerHTML =
                                        jsonresponse.{$stations[$s_group][$s_station][3]['artist']}.toLowerCase()+" - "+jsonresponse.{$stations[$s_group][$s_station][3]['title']}.toLowerCase();
                                        break;
                                    case 'xml':
                                        parser = new DOMParser();
                                        xmlDoc = parser.parseFromString(this.responseText,"text/xml");
                                        document.getElementById("nowplaying").innerHTML =
                                        xmlDoc.getElementsByTagName("songs")[0].getElementsByTagName("song")[0].getElementsByTagName("{$stations[$s_group][$s_station][3]['artist']}")[0].textContent.toLowerCase()+ " - "+
                                        xmlDoc.getElementsByTagName("songs")[0].getElementsByTagName("song")[0].getElementsByTagName("{$stations[$s_group][$s_station][3]['title']}")[0].textContent.toLowerCase();
                                        break;
                                    default:
                                        document.getElementById("nowplaying").innerHTML = '';
                                        break;
                                }
                                document.getElementById("nowplaying").style.color = useColor; // same as oscilloscope (somehow)?
                            }
                        };
                        xhttp.open("GET", "{$urlextension}{$stations[$s_group][$s_station][3]['url']}", true);
                        xhttp.send();
                    }
                </script>
EOL;
        }
        $controls = <<<EOL
                    <div id='pause' class='control click' onclick="setAudioAction(this,'pause');"></div>
                    <div id='unmute' class='control click' onclick="setAudioAction(this,'mute');"></div>
                    <input id='volume' class='click' type='range' min='0' max='1' step='0.01' value='{$volume}'
                    oninput="setAudioAction(this,'volume');"  onchange="setAudioAction(this,'volume');"/>
EOL;
        echo "

        $nowplaying

        <script>
            window.addEventListener('DOMContentLoaded', function() {setPlayer();}, false);

            function setPlayer()
            {
                if (document.contains(document.getElementById('audioplayer'))) {
                    document.getElementById('audioplayer').remove();
                }
                var type = '{$type}';
                var audio = document.createElement('audio');
                var location = '{$location}';
                audio.crossOrigin = 'anonymous';
                switch (type) {
                    case 'hls':
                        if (Hls.isSupported()) {
                            var hls = new Hls();
                            hls.loadSource(location);
                            hls.attachMedia(audio);
                            hls.on(Hls.Events.MANIFEST_PARSED,function() {
                                audio.play();
                            });
                        }
                        break;
                    case 'rtp':
                    default:
                        audio.src = location;
                        break;
                }
                audio.volume = {$volume};
                audio.id = 'audioplayer';
                audio.style.display = 'none';

                var playPromise = audio.play();

                if (playPromise !== undefined) {
                    playPromise.then(function() {
                        // create audioContext
                        var audioContext = new (window.AudioContext || window.webkitAudioContext)();
                        var source = audioContext.createMediaElementSource(audio);
                        // connect source to browser audio out
                        source.connect(audioContext.destination);
                        // create analyser
                        var analyser = audioContext.createAnalyser();
                        // connect audio to analyser
                        source.connect(analyser);
                        // parse
                        analyser.fftSize = 256;
                        var bufferLength = analyser.frequencyBinCount;
                        var dataArray = new Uint8Array(bufferLength);
                        // create canvasContext
                        var canvas = document.getElementById('osc');
                        var canvasCtx = canvas.getContext('2d');
                        colors = ['#B5382F','#E74C3C','#BC5E00','#EE7700',
                        '#BF980A','#F1C40F','#0E6E59','#16A085','#246E9F',
                        '#3498DB','#0000BB','#0000ED','#6E4084','#9B59B6',];
                        useColor = colors[Math.floor(Math.random() * 13)];
                        function drawOsc() 
                        {
                            drawVisual = requestAnimationFrame(drawOsc);
                            analyser.getByteTimeDomainData(dataArray);
                            canvasCtx.clearRect(0, 0, canvas.width, canvas.height);
                            canvasCtx.fillStyle = 'rgba(160, 160, 160, 0)';
                            canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
                            canvasCtx.lineWidth = 4;
                            canvasCtx.strokeStyle = useColor;
                            canvasCtx.beginPath();
                            var sliceWidth = canvas.width * 1.0 / bufferLength;
                            var x = 0;
                            for (var i = 0; i < bufferLength; i++) {
                                var v = dataArray[i] / 128.0;
                                var y = v * canvas.height/2;
                                if (i === 0) {
                                    canvasCtx.moveTo(x, y);
                                } else {
                                    canvasCtx.lineTo(x, y);
                                }
                                x += sliceWidth;
                            }
                            canvasCtx.lineTo(canvas.width, canvas.height/2);
                            canvasCtx.stroke();
                        };
                        drawOsc();
                    }).catch(function(error)
                    {
                        audio.src = '';
                        audio.load();
                        audio.removeAttribute('crossOrigin');
                        audio.src = location;
                        audio.play();
                    });
                }

                // append audio to body (for play/pause/mute/unmute/volume)
                document.body.appendChild(audio);
                // get artist and trackname
                getNowPlaying();

                // set time based function
                (function()
                {
                    var y = setInterval(function(){ setAudioState(y); }, 1000);
                    var x = setInterval(function(){ getNowPlaying(); }, 5000);
                })();
            };

            var called = 0;
            var laststate = '';
            var retries = 0;

            function setAudioState(intervalid)
            {
                var audioelem = document.getElementById('audioplayer');
                var stationinfo = document.getElementById('stationinfo');
                var state = audioelem.readyState;

                if (state === 0 || state === 1) {
                    if (laststate === state) {
                        laststate = state;
                        called++;
                    } else {
                        laststate = state;
                        called = 1;
                    }
                    if (called > 10) {
                        laststate = state;
                        called = 0;
                        retries++;
                        if (retries > 0) {
                            stationinfo.innerHTML = 'Error: {$s_station} offline';
                            clearInterval(intervalid);
                            return false;
                        }
                        setPlayer();
                    }
                }
                switch (state) {
                    case 0:
                        stationinfo.innerHTML = 'Loading... {$s_station}';
                        break;
                    case 1:
                        stationinfo.innerHTML = 'Loading... {$s_station}';
                        break;
                    case 1:
                        stationinfo.innerHTML = '{$s_station} Almost ready';
                        break;
                    case 4:
                        stationinfo.innerHTML = 'Listening to: {$s_station}';
                        clearInterval(intervalid);
                        break;
                }
            }

            function setAudioAction(el, action) 
            {
                var audioplayer = document.getElementById('audioplayer');
                if (audioplayer) {
                    switch (action) {
                        case 'pause':
                            if (audioplayer.paused) {
                                audioplayer.play();
                                el.id = 'pause';
                                break;
                            }
                            audioplayer.pause();
                            el.id = 'play';
                            break;
                        case 'mute':
                            if (audioplayer.muted) {
                                audioplayer.muted = false;
                                document.getElementById('volume').value = audioplayer.volume;
                                el.id = 'unmute';
                                break;
                            }
                            audioplayer.muted = true;
                            document.getElementById('volume').value = 0;
                            el.id = 'mute';
                            break;
                        case 'volume':
                            var volume = el.value;
                            audioplayer.volume = volume;
                            document.cookie = 'volume='+volume;
                            if (volume > 0) {
                                mute = document.getElementById('mute');
                                if (mute) {
                                    mute.id = 'unmute';
                                }
                                break;
                            }
                            unmute = document.getElementById('unmute');
                            if (unmute) {
                                unmute.id = 'mute';
                            }
                            break;
                    }
                }
            }
        </script>";
    }
} else {
    $buffer = preg_replace('/%TITLE%/i', 'Radio - none', $buffer);
    echo $buffer;
    echo "<pre>Please select radio a station</pre>";
}
echo <<<HERE
            <div id='audiocontrol'>
                    {$controls}
                </div>
                <canvas id='osc'></canvas>
                <pre onclick="javascript:location.href = 'http://github.com/produktr/webradio'" class='footer click' >github.com/produktr/webradio</pre></a>
            </div>
            </div>
            <script>
                function setBackgroundAnimation()
                {
                    function shiftColors(colors)
                    {
                        var shifted = colors.shift();
                        colors.push(shifted);
                        var shifted = colors.shift();
                        colors.push(shifted);

                        return colors;
                    }

                    function createCanvas()
                    {
                        var cv = document.createElement('canvas');
                        cv.width = 304;
                        cv.height = 304;
                        cv.style.width = "304px";
                        cv.style.height = "304px";

                        return cv;
                    }

                    function createCanvasX(canvas)
                    {
                        var cv = canvas;
                        var cvx = cv.getContext('2d');
                        cvx.webkitImageSmoothingEnabled = false;
                        cvx.mozImageSmoothingEnabled = false;
                        cvx.imageSmoothingEnabled = false; /// future

                        return cvx;
                    }

                    function isBackgroundAnimationDisabled()
                    {
                        var match = document.cookie.match('(^|[^;]+)\\s*stopBackgroundAnimation\\s*=\\s*([^;]+)');
                        return match ? match.pop() : false;
                    }

                    function drawImageToCanvasX(canvas, canvasX, colors)
                    {
                        var cvx = canvasX;
                        var x = y = 64;
                        for (i = 0; i < 14; i++) {
                            if (i % 2) {
                                cvx.beginPath();
                                cvx.lineWidth = 3;
                                cvx.strokeStyle = colors[i];
                                cvx.moveTo(x+2.5,y+1);
                                cvx.lineTo(x+2.5,y+220);
                                cvx.stroke();
                                cvx.moveTo(x+2.5,y+2.5);
                                cvx.lineTo(x+220,y+2.5);
                                cvx.stroke();
                                cvx.moveTo(x+6.5+220,y-4);
                                cvx.lineTo(x+6.5+220,y+6+220);
                                cvx.stroke();
                                cvx.moveTo(x-4,y+1+220+5.5);
                                cvx.lineTo(x+3+220+5,y+1+220+5.5);
                                cvx.stroke();
                                x = y -= 8;
                            } else {
                                cvx.beginPath();
                                cvx.rect(x,y,224,224);
                                cvx.lineWidth = 8;
                                cvx.strokeStyle = colors[i];
                                cvx.stroke();
                            }
                        }
                        setCanvasAsBackground(canvas);
                        colors = shiftColors(colors);
                        if (isBackgroundAnimationDisabled() == 'true') {
                            return 0;
                        }
                        setTimeout(function(){drawImageToCanvasX(canvas, canvasX, colors)}, 1250);
                    }

                    function setCanvasAsBackground(canvas)
                    {
                        var cv = canvas;
                        var url = cv.toDataURL();
                        document.body.style.backgroundImage = "url("+url+")";
                        document.body.style.backgroundPosition = "-75% -0%";
                    }

                    var colors = [
                        '#9B59B6',
                        '#6E4084',
                        '#0000ED',
                        '#0000BB',
                        '#3498DB',
                        '#246E9F',
                        '#16A085',
                        '#0E6E59',
                        '#F1C40F',
                        '#BF980A',
                        '#EE7700',
                        '#BC5E00',
                        '#E74C3C',
                        '#B5382F'
                    ];

                    var canvas = createCanvas();
                    var canvasX = createCanvasX(canvas);
                    drawImageToCanvasX(canvas, canvasX, colors);
                }
            </script>
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    setScrollPosition();
                    setBackgroundAnimation();
                }, false);
            </script>
        </body>
    </html>
HERE;
?>
