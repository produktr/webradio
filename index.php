<?php
// 2017 - ProduktR [PointWood]
ob_start();
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST['station'])) {
	$x = explode("%SPLIT%", $_POST['station']);
	$s_group = $x[0];
	$s_station = $x[1];
}
echo	'<title>%TITLE%</title>';
echo 	"<link rel='shortcut icon' href='favicon.ico' />";
echo	'<style>
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
				background-position: center center;
			}
			#container{
				width:500px;
				max-height: 90vh;
				margin-top: 5vh;
				margin:auto;
				background-color: #EAEAF7;
				padding: 24px;
				padding-top: 0px;
				border-top: 10px solid lightgray;
				border-right:10px solid gray;
				border-bottom:10px solid gray;
				border-left:10px solid lightgray;
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
				width:80%;
				display:block;
				margin-top: 1%;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
				text-decoration:none;
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
				position:absolute;
				top:0;
				bottom:0;
				left:0;
				width: 93%;
				border-width: 0px 14px 0px 14px;
				border-color: #3498DB;
				border-style: solid;
				content: "";
				display: block;
			}
			span.group.click:hover:after{
				position:absolute;
				top:0;
				bottom:0;
				left:0;
				width: 99%;
				border-width: 2px 2px 0px 2px;
				border-color: #EAEAF7;
				border-style: solid;
				content: "";
				display: block;
			}
			span.subgroup {
				font-size: 60%;
				width:70%;
				display:block;
				margin-top: 1%;
				margin-left: auto;
				margin-right: auto;
				text-align: left;
				text-decoration:none;
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
				cursor:pointer;
			}
			button.station{
				width:75%;
				border:none;
				color:white;
				margin-top:2px;
				margin-left: auto;
				margin-right: auto;
				padding:15px32px;
				text-align:center;
				text-decoration:none;
				background-color:#4CAF50;
				display: block;
				position:relative;
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
				margin-left: 24%;
				width:50%;
				margin-top: 2%;
				background-color: #DD2724;
				poistion: relative;
			}
			button.stop:after{
				position: absolute;
				top:-8;
				left:10%;
				right:10%;
				content: "";
				height: 1px;
				width: 80%;
				display: block;
				border-top: 1px dashed black;
			}
			pre{
				width:80%;
				display:block;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
			audio{
				width:80%;
				display:block;
				margin-left: auto;
				margin-right: auto;
			}
			img{
				display: block;
				margin-top: 12px;
				margin-left: auto;
				margin-right: auto;
				width: 25%;
			}
		</style>';

$stations = [
	// groupname => [	{subgroupname => ''}
	//					{station name => [location, init volume(0.0..1.0)]}]
	'70/80/90/00s' => [
		'80s' => '--------------------------------------------------',
		'80s #1' =>
			[ 'http://50.7.76.254:9908/;stream/1', '0.8'],
		'181-80s' =>
			[ 'http://listen.181fm.com/181-lite80s_128k.mp3', ''],
		'181.fm - Awesome 80s' =>
			[ 'http://uplink.duplexfx.com:8000/;', ''],
		'Liquidsoap Radio!' =>
			[ 'http://stream.radiocorp.nl/r10_80s_mp3', ''],

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
		'deephouse' =>
			['http://198.15.94.34:8006/stream/1/', ''],
		'Dogglounge Deep House Radio' =>
			[ 'http://master.dogglounge.com:9128/;', '0.5'],

		'Techno' => '-------------------------------------------------',
		'Technomania' =>
			[ 'http://stream.nauticradio.net:14240/;', ''],

		'Dubstep' => '------------------------------------------------',
		'Dubstep #1' =>
			[ 'http://stream.dubbase.fm:7002/;', '0.6'],

		'Drum n Base' => '--------------------------------------------',
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
		'HardcorePower' =>
			[ 'http://src.shoutcaststream.com:8022/;', ''],
		'FrenchCore' =>
			[ 'http://frenchcore24.myetrayz.net:9001/ices', ''],
		'HardCoreRadioSeek' =>
			[ 'http://82.73.58.87:7810/;', ''],
		'NERadio Hardstyle' =>
			[ 'http://1.hardstyle.nu:443/;', ''],
		'gabberfmGabber FM' =>
			[ 'http://streaming.radionomy.com/Gabberfm?lang=en-GB%2cen-US%3bq%3d0.8%2cen%3bq%3d0.6', '0.6'],
	],

	'Regular' => [
		'Dutch' => '--------------------------------------------------',
		'3FM Alternative' =>
			[ 'http://icecast.omroep.nl/3fm-alternative-mp3', ''],
		'Radio Veronica' =>
			[ 'http://8543.live.streamtheworld.com/VERONICACMP3', ''],
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
	],
];
echo "<script>
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
	</script>";

echo "<script>
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
	</script>";

echo "<body>";
echo "<div id='container'>\n";
$date = date('l d M Y'); 
echo "<pre class='date'>Page loaded on: {$date}</pre>";
echo "<pre class='channels click' onclick='showhidechannels(this)' data-status='visible'><b>Stations:</b> [⇡]</pre>";
echo "<form id='channels' method='post'>\n";
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
		echo "<button class='click station {$class}' name='station' value='{$group}%SPLIT%{$name}'>{$name}</button>\n";//<br/>";
	}
	echo "</div>";
}
echo "</form>\n";
echo "<form method='post'><button class='click station stop' name='station' value='stop%SPLIT%stop'>stop</button></form>\n";

$buffer = ob_get_contents();
ob_end_clean();

if($s_group && $s_station) {
	if($s_station === 'stop') {
		$buffer = preg_replace('/%TITLE%/i', 'Radio - stopped', $buffer);
		echo $buffer;
		echo "<pre>Please select radio a station</pre>\n";
		echo "<audio id='audioplayer' controls autoplay></audio>\n";
	} else {
		$buffer = preg_replace('/%TITLE%/i', $s_station, $buffer);
		echo $buffer;
		echo "<pre>Listening to: {$s_station}</pre>";
		$location = $stations[$s_group][$s_station][0];
		$volume = $stations[$s_group][$s_station][1];
		echo "<audio id='audioplayer' controls autoplay>\n
				<source src='{$location}'>\n
			</audio>\n";
	}
} else {
	$buffer = preg_replace('/%TITLE%/i', 'Radio - none', $buffer);
	echo $buffer;
	echo "<pre>Please select radio a station</pre>\n";
	echo "<audio id='audioplayer' controls autoplay></audio>\n";
}
echo "<img src='logo.png'/>";
echo "</div>";
echo "</body>";
if(isset($volume) && $volume !== '') {
	echo "
	<script>
		window.addEventListener('DOMContentLoaded', function() {
			var audio = document.getElementById('audioplayer');
			audio.volume = {$volume};
		}, false);
	</script>";
}
?>
