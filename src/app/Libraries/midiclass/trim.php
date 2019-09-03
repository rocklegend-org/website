<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

#$file = (isset($_FILES['mid_upload'])&&$_FILES['mid_upload']['tmp_name']!='')?$_FILES['mid_upload']['tmp_name']:false;
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
<title>Midi2Text</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" /><br />
Trim from [sec] <input type="text" name="trim_from" size="2" value="<?=@$_POST['trim_from']?$_POST['trim_from']:'0'?>" />sec. to <input type="text" name="trim_to" size="2" value="<?=@$_POST['trim_to']?$_POST['trim_to']:'1'?>" />sec.<br />
<br />
<input type="submit" value=" send " />
</div>
</form>

<div style="margin-top:20px">
<?php
if (@$file){
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi_trim.class.php');

	$midi = new MidiTrim();
	$midi->importMid($file);
	
	// USE TIMESTAMPS
	//$midi->trimSong(5000, 10000);
	
	// USE SECONDS
	$fromSec = (int)$_POST['trim_from']; //2;
	$toSec   = (int)$_POST['trim_to']; //4;
	$midi->trimSong($midi->seconds2timestamp($fromSec), $midi->seconds2timestamp($toSec));

	$file = $save_dir.rand().'.mid';
	
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,1,1,0,'qt');

	//echo '<hr /><pre><b>Trimmed file as text:</b><br>';
	//echo $midi->getTxt();
	//echo '</pre>';
?>
	<br /><br /><input type="button" name="download" value="Save trimmed SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($file)?>'" />
<?php
}
?>
</div>

</body>
</html>