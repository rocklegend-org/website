<?php

error_reporting(E_ALL);

$deleteFlag = false;

/****************************************************************************
MIDI CLASS CODE
****************************************************************************/
require('./classes/midi.class.php');

$midi = new Midi();

$instruments = $midi->getInstrumentList();
$drumset     = $midi->getDrumset();
$drumkit     = $midi->getDrumkitList();
$notes       = $midi->getNoteList();
//---------------------------------------------

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

if (isset($_POST['publish'])){
	#unset($_POST['plug']);
	if (isset($_POST['showTxt'])) unset($_POST['showTxt']);
	if (isset($_POST['showXml'])) unset($_POST['showXml']);
	
	$str = serialize($_POST);
	$mix = substr(md5(uniqid(rand())), 0, 10).'.mix';
	file_put_contents('mix/'.$mix, $str);
	$feedback = '<span style="color:#990000">your mix has been published as <a style="color:#990000" href="?mix='.$mix.'">'.$mix.'</a></span>';
}

if ($deleteFlag && isset($_GET['del'])){
	$mixfile = 'mix/'.basename($_GET['del']);
	#echo $mixfile;
	unlink($mixfile);
}

if (isset($_GET['mix'])){
	$mix = basename($_GET['mix']);
	$str = file_get_contents('mix/'.$mix);
	$_POST = unserialize($str);
	$_POST['play'] = 1;
}

//DEFAULTS
$rep = isset($_POST['rep'])?$_POST['rep']:4;

$play = isset($_POST['play']);

//$loop = isset($_POST['noloop'])?0:1;
//$plug = isset($_POST['plug'])?$_POST['plug']:(isset($_GET['plug'])?$_GET['plug']:'qt');
//

$bpm = isset($_POST['bpm'])?$_POST['bpm']:150;

$aktiv=array();
$inst=array();
$note=array();
$vol=array();

for ($k=1;$k<=8;$k++){
	$aktiv[$k] = isset($_POST["aktiv$k"])?1:0;
	$inst[$k] = isset($_POST["inst$k"])?$_POST["inst$k"]:0;
	$note[$k] = isset($_POST["note$k"])?$_POST["note$k"]:35;
	$vol[$k] = isset($_POST["vol$k"])?$_POST["vol$k"]:127;
}
//if (!isset($p['last'])) $aktiv[1]=1; //first call
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Sequencer</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="b=0;for(i=1;i<9;i++)b|=this['aktiv'+i].checked;if(b==0){alert('You have to activate at least one track!');return false};">
<div>
<?=@$feedback?>
<table border="0" cellpadding="2" cellspacing="0"><tr><td valign="top">
<table border="0" cellpadding="2" cellspacing="0">

<!-- DRUMS -->
<tr class="title"><td>&nbsp;</td><td colspan="7"><b>Drum tracks</b></td></tr>
<tr class="darkgrey"><td align="center">on</td><td>instrument</td><td>drum kit</td><td>vol</td><td colspan="4">pattern</td></tr>
<?php
for ($k=1;$k<=4;$k++){
?>
<tr>
<td class="mediumgrey"><input type="checkbox" name="aktiv<?=$k?>"<?=$aktiv[$k]?' checked="checked"':''?> /></td>
<td class="mediumgrey">
<select name="note<?=$k?>">
<?php
	for ($i=0;$i<128;$i++)
		if (isset($drumset[$i]))
			echo '<option value="'.$i.'"'.($note[$k]==$i?' selected="selected"':'').'>0'.$i.'&nbsp;&nbsp;'.$drumset[$i]."</option>\n";
		else{
			$num = ($i<10)?"00$i":($i<100?"0$i":"$i");
			echo '<option value="'.($i).'"'.($note[$k]==$i?' selected="selected"':'').'>'.$num."</option>\n";
		};
?>
</select>
</td>
<td class="mediumgrey">
<select name="inst<?=$k?>">
<?php
	foreach ($drumkit as $key=>$val) echo '<option value="'.$key.'"'.(($inst[$k]==$key)?' selected="selected"':'').">$val</option>\n";
?>
</select>
</td>
<td class="mediumgrey">
<select name="vol<?=$k?>">
<?php
	for ($i=127;$i>=0;$i--)
		echo "<option value=\"$i\"".($vol[$k]==$i?' selected="selected"':'').">$i</option>\n";
?>
</select>
</td>
<td class="mediumgrey">
<?php
	for ($i=0;$i<16;$i++) {
		echo "<input type=\"checkbox\" name=\"n$k$i\"".(isset($_POST["n$k$i"])?' checked="checked"':'')." />\n";
		if ($i<15&&$i%4==3) echo '</td><td'.($i%8==3?' class="lightgrey"':' class="mediumgrey"').'>';
	}
	echo "\n</td>\n</tr>\n";
}
?>
<!--
</td>
</tr>
-->

<!-- INSTRUMENTS -->
<tr class="title"><td>&nbsp;</td><td colspan="7"><b>Instrument tracks</b></td></tr>
<tr class="darkgrey"><td align="center">on</td><td>instrument</td><td>note</td><td>vol</td><td colspan="4">pattern</td></tr>
<?php
for ($k=5;$k<=8;$k++){
?>
<tr>
<td class="mediumgrey"><input type="checkbox" name="aktiv<?=$k?>"<?=$aktiv[$k]?' checked="checked"':''?> /></td>
<td class="mediumgrey">
<select name="inst<?=$k?>">
<?php
	for ($i=0;$i<128;$i++){
		$num = ($i<10)?"00$i":($i<100?"0$i":"$i");
		echo '<option value="'.($i).'"'.($inst[$k]==$i?' selected="selected"':'').'>'.$num.'&nbsp;&nbsp;'.$instruments[$i]."</option>\n";
	}
?>
</select>
</td>
<td class="mediumgrey">
<select name="note<?=$k?>">
<?php
	for ($i=0;$i<128;$i++)
		echo '<option value="'.($i).'"'.($note[$k]==$i?' selected="selected"':'').'>'.$notes[$i]."</option>\n";
?>
</select>
</td>

<td class="mediumgrey">
<select name="vol<?=$k?>">
<?php
	for ($i=127;$i>=0;$i--)
		echo "<option value=\"$i\"".($vol[$k]==$i?' selected="selected"':'').">$i</option>\n";
?>
</select>
</td>

<td class="mediumgrey">
<?php
	for ($i=0;$i<16;$i++) {
		echo "<input type=\"checkbox\" name=\"n$k$i\"".(isset($_POST["n$k$i"])?' checked="checked"':'')." />\n";
		if ($i<15&&$i%4==3) echo "</td>\n<td".($i%8==3?' class="lightgrey"':' class="mediumgrey"').'>';
	}
	echo "\n</td>\n</tr>\n";
}
?>
<tr><td colspan="8">
<br />
<input type="text" name="bpm" size="3" value="<?=$bpm?>" /> bpm<br />
<input type="text" name="rep" size="3" value="<?=$rep?>" /> bar repetitions<br />
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
<!--
<br /><br />
<br />
<input type="checkbox" name="showTxt"<?=isset($_POST['showTxt'])?' checked="checked"':''?> />show MIDI result as Text<br />
<input type="checkbox" name="showXml"<?=isset($_POST['showXml'])?' checked="checked"':''?> />show MIDI result as XML
-->
<br /><br />
<input type="submit" name="play" value=" PLAY! " />&nbsp;&nbsp;
<input type="submit" name="publish" value="Publish" onclick="return confirm('Are you sure this mix is worth to be published?')" />&nbsp;&nbsp;<br /><br />

<?php

if ($play){

	$save_dir = 'tmp/';
	srand((double)microtime()*1000000);
	$file = $save_dir.rand().'.mid';
	
	$midi->open(480); //timebase=480, quarter note=120
	$midi->setBpm($bpm);
	
	for ($k=1;$k<=8;$k++) if ($aktiv[$k]){		
		$ch = ($k<5)?10:$k;
		$inst = $_POST["inst$k"];
		$n = $_POST["note$k"];
		$v = $_POST["vol$k"];
		$t = 0;
		$ts = 0;
		$tn = $midi->newTrack() - 1;
		
		$midi->addMsg($tn, "0 PrCh ch=$ch p=$inst");
		for ($r=0;$r<$rep;$r++){
			for ($i=0;$i<16;$i++){
				if ($ts == $t+120) $midi->addMsg($tn, "$ts Off ch=$ch n=$n v=127");
				if (isset($_POST["n$k$i"])){
					$t = $ts;
					$midi->addMsg($tn, "$t On ch=$ch n=$n v=$v");
				}
				$ts += 120;
			}
			if ($ts == $t+120) $midi->addMsg($tn, "$ts Off ch=$ch n=$n v=127");
		}
		$midi->addMsg($tn, "$ts Meta TrkEnd");
	}	
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,$visible,$autostart,$loop,$player);
?>	
	<br /><br />
	<input type="button" name="download" value="Save as SMF (*.mid)" onclick="self.location.href='download.php?f=<?=urlencode($file)?>'" />
<?php
}
?>
</td></tr></table>
</td>
<td style="width:10px">&nbsp;</td>
<td valign="top">

<table width="160" border="0" cellpadding="2" cellspacing="0" class="mediumgrey">
<tr class="title"><td colspan="7"><b>Published Mixes</b></td></tr>
<tr><td>
<div id="mixlist"<?=$deleteFlag?'':' style="height:480px;overflow:scroll"'?>>
<?php
function cmp ($a, $b) {
	return (filemtime('mix/'.$a) < filemtime('mix/'.$b)) ? 1 : -1;
}

$mixes = array();
$h = opendir ('mix');
while ($file = readdir($h)){
	if ($file!='.' && $file!='..'){
		#if ($file{0}=='6')
		$mixes[] = $file;
	}
}
closedir($h);

#usort ($mixes, "cmp");
sort ($mixes);

foreach ($mixes as $m){
	echo '<a href="sequencer.php?mix='.$m.'"'.(@$mix==$m?' class="on"':'').'>'.$m.'</a>'.($deleteFlag?'&nbsp;&nbsp;&nbsp;<a href="?del='.$m.'">[x]</a>':'').'<br />';
}
?>
</div>
</td></tr></table>

</td></tr></table>
</div>
</form>
<?php 
#if (isset($_POST['showTxt'])) echo '<hr /><pre>'.$midi->getTxt().'</pre>';
#if (isset($_POST['showXml'])) echo '<hr /><pre>'.htmlspecialchars($midi->getXml()).'</pre>';
?>
</body>
</html>