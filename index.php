<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');
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
			#container{
				width:500px;
				margin:auto;
				background-color: #EAEAF7;
				padding: 24px;
				border-top: 10px solid lightgray;
				border-right:10px solid gray;
				border-bottom:10px solid gray;
				border-left:10px solid lightgray;
			}
			.click{
				cursor:pointer;
			}
#channels{
	visibility: visible;
	opacity:1;
	transition:opacity 0.5s linear;
}
#channels.hidden{
	visibility: hidden;
	opacity:0;
}
			.station{
				width:80%;
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
			}
			.active{
				background-color:#EE7600;
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
	'deephouse' => 'http://198.15.94.34:8006/stream/1/',
	//'8fm' => 'http://server-33.stream-server.nl/;',
	'80s' => 'http://50.7.76.254:9908/;stream/1',
	'181-80s' => 'http://listen.181fm.com/181-lite80s_128k.mp3',
	'FM4 - ORF' => 'http://mp3stream1.apasf.apa.at:8000/;',
	'3FM Alternative' => 'http://icecast.omroep.nl/3fm-alternative-mp3',
	'Radio Veronica' => 'http://8543.live.streamtheworld.com/VERONICACMP3',
	'Radio Veronica 1000' => 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR10.mp3',
	'Radio Veronica 80s' => 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR12.mp3',
	'Radio Veronica 90s' => 'http://live.icecast.kpnstreaming.nl/skyradiolive-SRGSTR13.mp3',
	'Radio 8FM [Noordoost Brabant]' => 'http://breedband.radio8fm.nl:8802/;',
	'Liquidsoap Radio!' => 'http://stream.radiocorp.nl/r10_80s_mp3',
	'181.fm - Awesome 80s' => 'http://uplink.duplexfx.com:8000/;',
	'Dogglounge Deep House Radio' => 'http://master.dogglounge.com:9128/;',
	'Technomania' => 'http://stream.nauticradio.net:14240/;',
	'Beats n Breaks' => 'http://stream.nauticradio.net:14280/;',
	'Next Movement' => 'http://stream.nauticradio.net:14230/;',
	'Vodoo Gospel' => 'http://stream.nauticradio.net:14260/;',
	'Zwarte Hemel' => 'http://stream.nauticradio.net:14220/;',
	'Tekno #1' => 'http://channel1.teknoradio.nl:8064/;',
	'Tekno #2' => 'http://channel2.teknoradio.nl:8126/;',
	'Tekno #3' => 'http://channel3.teknoradio.nl:8124/;',
	'HardcorePower' => 'http://src.shoutcaststream.com:8022/;',
	'FrenchCore' => 'http://frenchcore24.myetrayz.net:9001/ices',
	'HardCoreRadioSeek' => 'http://82.73.58.87:7810/;',
	'NERadio Hardstyle' => 'http://1.hardstyle.nu:443/;',
	'gabberfmGabber FM' => 'http://listen.radionomy.com/;',
	'Box UK Radio' => 'http://uk2.internet-radio.com:31076/;',
	'RSO 91.7 THESSALONIKI' => 'http://live.isolservers.com:8200/',
	'NSBRadio.co.uk' => 'http://live.nsbradio.co.uk:7904/;',
	'stop' => 'null'
];
echo "<script>
		function showhide(el) {
			var channels = document.getElementById('channels');
			if(channels.style.display) {
				channels.style.display = '';
				el.innerHTML = '<b>Stations:</b> [⇡]';
			} else {
				channels.style.display = 'none';
				el.innerHTML = '<b>Stations:</b> [⇣]<br/>   -  -  -  -  -   ';
			}
		}
	</script>";
echo "<div id='container'>\n";
echo "<pre class='click' onclick='showhide(this)'><b>Stations:</b> [⇡]</pre>";
echo "<form id='channels' method='post'>\n";

foreach($stations as $name => $location) {
	$class = '';
	if(isset($_POST['station']) && $_POST['station'] === $name) {
		$class = ' active';
	}
	echo "<button class='click station {$class}' name='station' value='{$name}'>{$name}</button>\n";//<br/>";
}

echo "</form>\n";

$buffer = ob_get_contents();
ob_end_clean();

if(isset($_POST['station'])) {
	$buffer = preg_replace('/%TITLE%/i', $_POST['station'], $buffer);
	echo $buffer;
	echo "<pre>Listening to: {$_POST['station']}</pre>";
	$location = $stations[$_POST['station']];
	echo "<audio controls autoplay>\n
			<source src='{$location}'>\n
		</audio>\n";
} else {
	$buffer = preg_replace('/%TITLE%/i', 'Radio - none', $buffer);
	echo $buffer;
	echo "<pre>Please select radio a station</pre>\n";
	echo "<audio controls autoplay></audio>\n";
}
echo "<img src='radio_logo.png'/>";
echo "</div>";
?>
