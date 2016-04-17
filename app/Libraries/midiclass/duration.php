<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

#$file=(isset($_FILES['mid_upload'])&&$_FILES['mid_upload']['tmp_name']!='')?$_FILES['mid_upload']['tmp_name']:'';
if (isset($_FILES['mid_upload'])){
	$file = $save_dir.rand().'.mid';
	$tmpFile=$_FILES['mid_upload']['tmp_name'];
	@move_uploaded_file($tmpFile,$file) or die('problems uploading file');
	@chmod($file,0666);
}elseif (isset($_POST['file'])){
	$file=$_POST['file'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Duration</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" />
<br /><br />
<input type="submit" value=" send " />
</div>
</form>
<?php
if (@$file){
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi_duration.class.php');

	$midi = new MidiDuration();
	$midi->importMid($file);
 	echo '<div style="margin-top:20px">Duration [sec]: '.$midi->getDuration().'</div>';
	
#	$midi = new Midi();
#	$midi->importMid($file);
#	
#	$maxTime=0;
#	foreach ($midi->tracks as $track){
#		$msgStr = $track[count($track)-1];
#		list($time)=explode(" ", $msgStr);
#		$maxTime=max($maxTime,$time);
#	}
#	$duration=$maxTime * $midi->getTempo() / $midi->getTimebase() / 1000000;
#	echo "Duration [sec]: $duration"; // ergibt 69.0623480625 sec für bossa.mid
}
?>
</body>
</html>