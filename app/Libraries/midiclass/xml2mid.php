<?php

error_reporting(E_ALL);

if (isset($_POST['player'])){
	$player = $_POST['player'];
	$autostart = isset($_POST['autostart']);
	$loop = isset($_POST['loop']);
	$visible = isset($_POST['visible']);
}else{
	$player = 'default';
	$autostart = true;
	$loop = false;
	$visible = true;
}

if (isset($_POST['txt'])){
	$txt = $_POST['txt'];
	if (get_magic_quotes_gpc()) $txt = stripslashes($txt);
}else 
	$txt = $test='<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE MIDIFile SYSTEM "http://www.musicxml.org/dtds/midixml.dtd">
<MIDIFile>
<Format>1</Format>
<TrackCount>2</TrackCount>
<TicksPerBeat>120</TicksPerBeat>
<TimestampType>Absolute</TimestampType>
<Track Number="0">
  <Event>
    <Absolute>0</Absolute>
    <TimeSignature Numerator="4" LogDenominator="2" MIDIClocksPerMetronomeClick="24" ThirtySecondsPer24Clocks="8"/>
  </Event>
  <Event>
    <Absolute>0</Absolute>
    <KeySignature Fifths="0" Mode="0"/>
  </Event>
  <Event>
    <Absolute>0</Absolute>
    <SetTempo Value="371520"/>
  </Event>
  <Event>
    <Absolute>0</Absolute>
    <EndOfTrack/>
  </Event>
</Track>
<Track Number="1">
  <Event>
    <Absolute>0</Absolute>
    <ProgramChange Channel="1" Number="73"/>
  </Event>
  <Event>
    <Absolute>0</Absolute>
    <NoteOn Channel="1" Note="43" Velocity="127"/>
  </Event>
  <Event>
    <Absolute>240</Absolute>
    <NoteOn Channel="1" Note="59" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>240</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>256</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>376</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>392</Absolute>
    <NoteOn Channel="1" Note="55" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>422</Absolute>
    <NoteOn Channel="1" Note="43" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>632</Absolute>
    <NoteOn Channel="1" Note="59" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>738</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>738</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>738</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>738</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>798</Absolute>
    <NoteOn Channel="1" Note="38" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>798</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>798</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>814</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>844</Absolute>
    <NoteOn Channel="1" Note="55" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>860</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>860</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>890</Absolute>
    <NoteOn Channel="1" Note="37" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>966</Absolute>
    <NoteOn Channel="1" Note="61" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1072</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1162</Absolute>
    <NoteOn Channel="1" Note="37" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1162</Absolute>
    <NoteOn Channel="1" Note="38" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1178</Absolute>
    <NoteOn Channel="1" Note="61" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1268</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1268</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1298</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1404</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1464</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1510</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1540</Absolute>
    <NoteOn Channel="1" Note="43" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1736</Absolute>
    <NoteOn Channel="1" Note="55" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1766</Absolute>
    <NoteOn Channel="1" Note="59" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1766</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1766</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1856</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1886</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>1902</Absolute>
    <NoteOn Channel="1" Note="43" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1932</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>1992</Absolute>
    <NoteOn Channel="1" Note="59" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2022</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2112</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2188</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2188</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2264</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2294</Absolute>
    <NoteOn Channel="1" Note="71" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2310</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2356</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2356</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2356</Absolute>
    <NoteOn Channel="1" Note="62" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2356</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2372</Absolute>
    <NoteOn Channel="1" Note="37" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2372</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2448</Absolute>
    <NoteOn Channel="1" Note="38" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2448</Absolute>
    <NoteOn Channel="1" Note="55" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2448</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2464</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2510</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2510</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2540</Absolute>
    <NoteOn Channel="1" Note="69" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2570</Absolute>
    <NoteOn Channel="1" Note="69" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2660</Absolute>
    <NoteOn Channel="1" Note="61" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2706</Absolute>
    <NoteOn Channel="1" Note="66" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2766</Absolute>
    <NoteOn Channel="1" Note="37" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2782</Absolute>
    <NoteOn Channel="1" Note="38" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2798</Absolute>
    <NoteOn Channel="1" Note="61" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>2904</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="100"/>
  </Event>
  <Event>
    <Absolute>2964</Absolute>
    <NoteOn Channel="1" Note="50" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>3100</Absolute>
    <NoteOn Channel="1" Note="57" Velocity="0"/>
  </Event>
  <Event>
    <Absolute>3100</Absolute>
    <EndOfTrack/>
  </Event>
</Track>
</MIDIFile>';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Xml2Midi</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<div>
<textarea name="txt" cols="100" rows="30"><?php echo htmlspecialchars($txt)?></textarea><br />
<br />
Player:
<select name="player">
<?
$players = array(
	'default'=>'Default',
	'quicktime'=>'Quicktime',
	'crescendo'=>'Crescendo',
	'bgsound'=>'IE Win BgSound',
	'windowsmedia'=>'Windows Media',
	'beatnik'=>'Beatnik',
	'mp3_flash'=>'MP3 Flash Player',
	'ogg_html5'=>'OGG HTML5 Player'
);
foreach ($players as$k=>$v){
	echo '<option value="'.$k.'"'.($player==$k?' selected="selected"':'').'>'.$v."</option>\n";
}
?>
</select>
<br /><br />
Settings:
<?
$settings = array(
	'autostart'=>'Autostart',
	'loop'=>'Loop',
	'visible'=>'Visible'
);
foreach ($settings as $k=>$v){
	echo '<input type="checkbox" name="'.$k.'"'.($$k?' checked="checked"':'').' />'.$v."\n";
}
?>
<br /><br />
<input type="submit" value=" send " />
</div>
</form>

<div style="margin-top:20px">
<?php
if (isset($_POST['txt'])){
	$save_dir = 'tmp/';
	srand((double)microtime()*1000000);
	$file = $save_dir.rand().'.mid';

	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');

	@set_time_limit (600); # 10 minutes

	$midi = new Midi();
	$midi->importXml($txt);		
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,$visible,$autostart,$loop,$player);
?>
	<br /><br /><input type="button" name="download" value="Save as SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($file)?>'" />
<?php
}
?>
</div>

</body>
</html>