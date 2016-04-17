<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

if (isset($_POST['player'])){
	$player = $_POST['player'];
	$autostart = isset($_POST['autostart']);
	$loop = isset($_POST['loop']);
	$visible = isset($_POST['visible']);
}else{
	$player = 'default';
	$autostart = true;
	$loop = true;
	$visible = true;
}
	
if (isset($_FILES['mid_upload'])){
	$file = $save_dir.rand().'.mid';
	$tmpFile=$_FILES['mid_upload']['tmp_name'];
	@move_uploaded_file($tmpFile,$file) or die('problems uploading file');
	@chmod($file,0666);
}elseif (isset($_POST['file'])) $file=$_POST['file'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Manipulate MIDI file</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>
<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" />
<input type="submit" value=" send " />
</div>
</form>
<hr />
<?php
if (@$file){
	
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');

	$midi = new Midi();
	$midi->importMid($file);

	$tc = $midi->getTrackCount();
?>
<form action="manipulate.php" method="post">
<div>
<input type="hidden" name="file" value="<?php echo isset($file)?$file:''?>" />
<input type="checkbox" name="up"<?php echo isset($_POST['up'])?' checked="checked"':''?> />transpose up (1 octave)
<input type="checkbox" name="down"<?php echo isset($_POST['down'])?' checked="checked"':''?> />transpose down (1 octave)
<br /><br />
<input type="checkbox" name="double"<?php echo isset($_POST['double'])?' checked="checked"':''?> />double tempo
<input type="checkbox" name="half"<?php echo isset($_POST['half'])?' checked="checked"':''?> />half tempo
<br /><br />
<input type="checkbox" name="delete"<?php echo isset($_POST['delete'])?' checked="checked"':''?> />delete track
<select name="delTrackNum"><?php for ($i=0;$i<$tc;$i++) echo "<option value=\"$i\"".(isset($_POST['delTrackNum'])&&$i==$_POST['delTrackNum']?' selected="selected"':'').">$i</option>\n";?></select>
<input type="checkbox" name="solo"<?php echo isset($_POST['solo'])?' checked="checked"':''?> />solo track
<select name="soloTrackNum"><?php for ($i=0;$i<$tc;$i++) echo "<option value=\"$i\"".(isset($_POST['soloTrackNum'])&&$i==$_POST['soloTrackNum']?' selected="selected"':'').">$i</option>\n";?></select>
<br /><br />
<input type="checkbox" name="insert"<?php echo isset($_POST['insert'])?' checked="checked"':''?> />insert MIDI messages (3 handclaps at start)
<br /><br />
<input type="checkbox" name="show"<?php echo isset($_POST['show'])?' checked="checked"':''?> />show MIDI result as Text
<br /><br />

<hr />
Player:
<?
$players = array(
	'default'=>'Default',
	'quicktime'=>'Quicktime',
	'crescendo'=>'Crescendo',
	'bgsound'=>'IE Win BgSound',
	'windowsmedia'=>'Windows Media',
	'beatnik'=>'Beatnik'
);
foreach ($players as$k=>$v){
	echo '<input type="radio" name="player" value="'.$k.'"'.($player==$k?' checked="checked"':'').' />'.$v."\n";
}
?>
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
<input type="submit" value=" PLAY! " />
</div>
</form>

<div style="margin-top:20px">
<?php
	if (isset($_FILES['mid_upload']))
		$midi->playMidFile($file,$visible,$autostart,$loop,$player);
	else{
		$new = $save_dir.rand().'.mid';

		if (isset($_POST['up']))          $midi->transpose(12);
		if (isset($_POST['down']))        $midi->transpose(-12);
		if (isset($_POST['double'])) 			$midi->setTempo($midi->getTempo()/2);
		if (isset($_POST['half'])) 				$midi->setTempo($midi->getTempo()*2);
		if (isset($_POST['solo']))        $midi->soloTrack($_POST['soloTrackNum']);
		if (isset($_POST['delete']))      $midi->deleteTrack($_POST['delTrackNum']);
		if (isset($_POST['insert'])){
			$midi->insertMsg(0,"0 On ch=10 n=39 v=127");
			$midi->insertMsg(0,"120 On ch=10 n=39 v=127");
			$midi->insertMsg(0,"240 On ch=10 n=39 v=127");
		}
		$midi->saveMidFile($new, 0666);
		$midi->playMidFile($new,$visible,$autostart,$loop,$player);
?>
<br /><br /><input type="button" name="download" value="Save as SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($new)?>'" />
<?php
	}
	if (isset($_POST['show'])) echo '<hr />'.nl2br($midi->getTxt());
	echo '</div>';
}
?>

</body>
</html>