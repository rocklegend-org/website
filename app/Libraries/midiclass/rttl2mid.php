<?php

error_reporting(E_ALL);

$PHP_SELF = $_SERVER['PHP_SELF'];

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

$inst = isset($_POST['inst'])?$_POST['inst']:0;
$rttl = isset($_POST['rttl'])?$_POST['rttl']:'Beethoven:d=4,o=5,b=250:e6,d#6,e6,d#6,e6,b,d6,c6,2a.,c,e,a,2b.,e,a,b,2c.6,e,e6,d#6,e6,d#6,e6,b,d6,c6,2a.,c,e,a,2b.,e,c6,b,1a';

$plug = isset($_POST['plug'])?$_POST['plug']:'qt';

/****************************************************************************
MIDI CLASS CODE
****************************************************************************/
require('./classes/midi_rttl.class.php');

$midi = new MidiRttl();
$instruments = $midi->getInstrumentList();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Rttl2Midi</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>
<form action="<?=$PHP_SELF?>" method="post">
<div>
<textarea name="rttl" cols="140" rows="2"><?=$rttl?></textarea>
<br /><br />
Use instrument: 
<select name="inst">
<?php
	for ($i=0;$i<128;$i++){
		echo '<option value="'.($i).'"'.($inst==$i?' selected="selected"':'').'>'.$instruments[$i]."</option>\n";
	}
?>
</select><br />
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
if (isset($_POST['rttl'])){
	$save_dir = 'tmp/';
	srand((double)microtime()*1000000);
	$file = $save_dir.rand().'.mid';

	$midi->importRttl($_POST['rttl'],$inst);
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,$visible,$autostart,$loop,$player);
?>
<br /><br /><input type="button" name="download" value="Save as SMF (*.mid)" onclick="self.location.href='download.php?f=<?=urlencode($file)?>'" />
<?	
}
?>
</div>

</body>
</html>