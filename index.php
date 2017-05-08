<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST['station'])) {
	$x = explode("%SPLIT%", $_POST['station']);
	$s_group = $x[0];
	$s_station = $x[1];
}
if(!isset($_COOKIE['scroll'])){
	$_COOKIE['scroll'] = 0;
}
echo	<<<HERE
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
					background-image: url(logo_no_fill.png);
				}
				#container{
					width: 500px;
					max-height: 90vh;
					margin-top: 5vh;
					margin: auto;
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
				pre.footer{
					padding: 0px;
					height: 3px;
					color: gray;
					margin-bottom: 0px;
					font-size: 50%;
				}
			</style>
			<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.min.js"></script>
		</head>
HERE;

$stations = [
	// groupname => [	{subgroupname => ''}
	//					{station name => [location, init volume(0.0..1.0)]}]
	'70/80/90/00s' => [
		'70s' => '--------------------------------------------------',
			'Left Coast 70s' =>
				[ 'http://ice1.somafm.com/seventies-128-aac', ''],
		'80s' => '--------------------------------------------------',
		'80s #1' =>
			[ 'http://50.7.76.254:9908/;stream/1', '0.8'],
		'181-80s' =>
			[ 'http://listen.181fm.com/181-lite80s_128k.mp3', ''],
		'181.fm - Awesome 80s' =>
			[ 'http://uplink.duplexfx.com:8000/;', ''],
		'Liquidsoap Radio!' =>
			[ 'http://538hls.lswcdn.triple-it.nl/content/web20/index.m3u8', '', 'hls'],

		'90s' => '--------------------------------------------------',
		'90s #1 fm' =>
			[ 'http://19353.live.streamtheworld.com/977_90_SC', ''],
		'965crush fm' =>
			[ 'http://us4.internet-radio.com:8062/;', ''],
		'Harder-FM Eurodance' =>
			[ 'http://uk5.internet-radio.com:8325/;', ''],

		'00s' => '----------------------------------------------------',
		'2000 FM' => [ 'http://bigrradio-edge1.cdnstream.com/5106_128', ''],
	],

	'Electronic' => [
		'House' => '--------------------------------------------------',
		'Deephouse' =>
			['http://198.15.94.34:8006/stream/1/', ''],
		'Dogglounge Deep House Radio' =>
			[ 'http://master.dogglounge.com:9128/;', '0.5'],
		'Beatblender' =>
			['http://ice1.somafm.com/beatblender-128-aac', ''],

		'Techno' => '-------------------------------------------------',
		'Technomania' =>
			[ 'http://stream.nauticradio.net:14240/;', ''],

		'Downtempo' => '----------------------------------------------',
		'Groove Salad' =>
			['http://ice1.somafm.com/groovesalad-128-aac', ''],

		'Dubstep' => '------------------------------------------------',
		'Dubstep #1' =>
			[ 'http://stream.dubbase.fm:7002/;', '0.6'],

		'Drum n Bass' => '--------------------------------------------',
		'Beats n Breaks' =>
			[ 'http://stream.nauticradio.net:14280/;', ''],
		'DnB Liquified' =>
			[ 'http://st8.webradioworld.net:8000/;', ''],
		'DnB Jungle' =>
			[ 'http://trace.dnbradio.com/dnbradio_main.mp3', '0.9'],

		'Tekno' => '--------------------------------------------------',
		'Tekno #1' =>
			[ 'http://channel1.teknoradio.nl:8064/;', ''],
		'Tekno #2' =>
			[ 'http://channel2.teknoradio.nl:8126/;', ''],
		'Tekno #3' =>
			[ 'http://channel3.teknoradio.nl:8124/;', ''],

		'French / Hardcore' => '---------------------------------------',
		'HardcoreNL' =>
			[ 'http://81.18.165.235/;', '0.8'],
		'HardcorePower' =>
			[ 'http://src.shoutcaststream.com:8022/;', ''],
		'FrenchCore' =>
			[ 'http://frenchcore24.myetrayz.net:9001/ices', ''],
		'HardCoreRadioSeek' =>
			[ 'http://82.73.58.87:7810/;', ''],
		'NERadio Hardstyle' =>
			[ 'http://1.hardstyle.nu:443/;', ''],
		'Gabber FM' =>
			[ 'http://streaming.radionomy.com/Gabberfm?lang=en-GB%2cen-US%3bq%3d0.8%2cen%3bq%3d0.6', '0.6'],
	],

	'Regular' => [
		'Dutch' => '--------------------------------------------------',
		'3FM Alternative' =>
			[ 'http://icecast.omroep.nl/3fm-alternative-mp3', ''],
		'Radio Veronica' =>
			[ 'http://8543.live.streamtheworld.com/VERONICACMP3', ''],
		'Slam FM' =>
			['http://vip-icecast.538.lw.triple-it.nl/SLAMFM_MP3', ''],
		'Radio Veronica 1000' =>
			[ 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR10.mp3', ''],
		'Radio Veronica 80s' =>
			[ 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR12.mp3', ''],
		'Radio Veronica 90s' =>
			[ 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR13.mp3', ''],
		'Radio 8FM [Noordoost Brabant]' =>
			[ 'http://breedband.radio8fm.nl:8802/;', ''],
		'Next Movement' =>
			[ 'http://stream.nauticradio.net:14230/;', ''],
		'Vodoo Gospel' =>
			[ 'http://stream.nauticradio.net:14260/;', '0.9'],
		'Zwarte Hemel' =>
			[ 'http://stream.nauticradio.net:14220/;', ''],

		'International' => '------------------------------------------',
		'Box UK Radio' =>
			[ 'http://uk2.internet-radio.com:31076/;', ''],
		'RSO 91.7 THESSALONIKI' =>
			[ 'http://live.isolservers.com:8200/', ''],
		'NSBRadio.co.uk' =>
			[ 'http://live.nsbradio.co.uk:7904/;', ''],
		'FM4 - ORF' =>
			[ 'http://mp3stream1.apasf.apa.at:8000/;', ''],
	],
	'Other' => [
		'Vaporwave #1' => 
			[ 'https://plaza.one/mp3', ''],
		'Poolside' =>
			[ 'http://stream.radio.co/s98f81d47e/listen', '0.7'],
		'Lounge' =>
			[ 'http://listen.radionomy.com/;', ''],
		'Seeburg 1000' =>
			['http://74.82.59.197:8351/1?cb=762044.mp3', '']
	],
];

echo <<<HERE
	<script>
		function showhidechannels(el) {
			var channels = document.getElementById('channels');
			var status = el.getAttribute('data-status');
			if(status === 'visible') {
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
		function showhidegroup(el) {
			var status = el.getAttribute('data-status');
			var name = el.innerHTML;
			var group = el.nextSibling;
			if(status === 'visible') {
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
		function setscroll(action){
			var ch = document.getElementById('channels');
			if(action === 'save'){
				document.cookie = 'scroll='+ch.scrollTop;
			}else{
				ch.scrollTop = {$_COOKIE['scroll']};
			}
		}
	</script>
HERE;

$date = date('l d M Y'); 
echo <<<HERE
	<body>
		<div id='container'>
			<pre class='date'>Page loaded on: {$date}</pre>
			<pre class='channels click' onclick='showhidechannels(this)' data-status='visible'><b>Stations:</b> [⇡]</pre>
			<form id='channels' method='post' onsubmit="setscroll('save')" >
HERE;
foreach($stations as $group => $station) {
	if(!isset($_COOKIE[$group])) {
		setcookie($group, 'hidden');  //should be set before any is outputted to page
		$_COOKIE[$group] = 'hidden';
	}
	echo "<span class='group click' onclick='showhidegroup(this)' data-status='{$_COOKIE[$group]}'>{$group}</span>";
	echo "<div class='group {$_COOKIE[$group]}'>";
	foreach($station as $name => $data) {
		$class = '';
		if(!is_array($data)){
			echo "<span class='subgroup'>- {$name} -</span>";
			continue;
		}
		if(isset($s_station) && $s_station === $name && $s_group === $group) {
			$class .= ' active';
		}
		echo "<button class='click station {$class}' name='station' value='{$group}%SPLIT%{$name}'>{$name}</button>";
	}
	echo "</div>";
}
echo "</form>";
echo "<form method='post' onsubmit=\"setscroll('save')\" ><button class='click station stop' name='station' value='stop%SPLIT%stop'>stop</button></form>";

$buffer = ob_get_contents();
ob_end_clean();
$controls = '';
if(isset($s_group) && isset($s_station)) {
	if($s_station === 'stop') {
		$buffer = preg_replace('/%TITLE%/i', 'Radio - stopped', $buffer);
		echo $buffer;
		echo "<pre>Please select radio a station</pre>";
	} else {
		$buffer = preg_replace('/%TITLE%/i', $s_station, $buffer);
		echo $buffer;
		echo "<pre id='stationinfo'>Loading... {$s_station}</pre>";
		$location = $stations[$s_group][$s_station][0];
		$volume = $stations[$s_group][$s_station][1];
		$type = $stations[$s_group][$s_station][2];
		if(!isset($volume) || $volume === '') {
			$volume = 1;
		}
		if(isset($type) || $type === 'hls'){
			$type = 'hls';
		}
		if(isset($_COOKIE['volume'])) {
			$set_volume = $_COOKIE['volume'];
			$volume = ($set_volume / 1) * $volume;
		}
		$controls = <<<EOL
					<div id='pause' class='control click' onclick="audiocontrol(this,'pause');"></div>
					<div id='unmute' class='control click' onclick="audiocontrol(this,'mute');"></div>
					<input id='volume' class='click' type='range' min='0' max='1' step='0.01' value='{$volume}'
					oninput="audiocontrol(this,'volume');"	onchange="audiocontrol(this,'volume');"/>
EOL;
		echo "
		<script>
			window.addEventListener('DOMContentLoaded', function() {setPlayer();}, false);

			function setPlayer(){
				if (document.contains(document.getElementById('audioplayer'))) {
					document.getElementById('audioplayer').remove();
				}
				var type = '{$type}';
				//var audio = new Audio('{$location}');
				var audio = document.createElement('audio');
				var location = '{$location}';
				if(type === 'hls'){
					if(Hls.isSupported()) {
						var hls = new Hls();
						hls.loadSource(location);
						hls.attachMedia(audio);
						hls.on(Hls.Events.MANIFEST_PARSED,function() {
							audio.play();
						});
					}
				}else{
					audio.src = location;
				}
				audio.volume = {$volume};
				audio.id = 'audioplayer';
				audio.style.display = 'none';
				audio.play();
				document.body.appendChild(audio);
				(function(){
					var y = setInterval(function(){ reportAudioState(y); }, 1000);
				})();
			};

			var called = 0;
			var laststate = '';
			var retries = 0;

			function reportAudioState(intervalid){
				var audioelem = document.getElementById('audioplayer');
				var stationinfo = document.getElementById('stationinfo');
				var state = audioelem.readyState;

				if(state === 0 || state === 1){
					if(laststate === state){
						laststate = state;
						called++;
					}else{
						laststate = state;
						called = 1;
					}
					if(called > 10){
						laststate = state;
						called = 0;
						retries++;
						if(retries > 0){
							stationinfo.innerHTML = 'Error: {$s_station} offline';
							clearInterval(intervalid);
							return false;
						}
						setPlayer();
					}
				}
				switch(state){
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

			function audiocontrol(el, action) {
				var audioplayer = document.getElementById('audioplayer');
				if(audioplayer) {
					switch(action) {
						case 'pause':
							if(audioplayer.paused) {
								audioplayer.play();
								el.id = 'pause';
								break;
							}
							audioplayer.pause();
							el.id = 'play';
							break;
						case 'mute':
							if(audioplayer.muted) {
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
							if(volume > 0) {
								mute = document.getElementById('mute');
								if(mute) {
									mute.id = 'unmute';
								}
								break;
							}
							unmute = document.getElementById('unmute');
							if(unmute) {
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
				<img src='logo.png'/>
				<pre onclick="javascript:location.href = 'http://github.com/produktr/webradio'" class='footer click' >github.com/produktr/webradio</pre></a>
			</div>
			<script>
				window.addEventListener('DOMContentLoaded', function() {
					setscroll();
				}, false);
			</script>
		</body>
	</html>
HERE;
?>
