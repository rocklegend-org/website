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
}elseif (isset($_POST['file'])) $file=$_POST['file'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Meta-Messages</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" /><br />
Track-Number: <select name="track_num">
<? for ($i=0;$i<16;$i++) echo '<option value="'.$i.'"'.(@$_POST['track_num']==$i?' selected="selected"':'').'>'.$i.'</option>'; ?>
</select><br />
<input type="submit" value=" send " />
</div>
</form>
<?php
if (@$file){
	echo '<div style="margin-top:20px">File: '.$_FILES['mid_upload']['name'];
	echo '<hr /><pre>';

	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');
	
	$midi = new Midi();
	$midi->importMid($file);
	$track = $midi->getTrack((int)$_POST['track_num']);

	// list of meta events that we are interested in (adjust!)
	$texttypes = array('Text','Copyright','TrkName','InstrName','Lyric','Marker','Cue');

	$nothing = 1;
	foreach ($track as $msgStr){
		$msg = explode(' ',$msgStr);
		if ($msg[1]=='Meta'&&in_array($msg[2],$texttypes)){
			echo $msg[2].': '.substr($msgStr,strpos($msgStr,'"'))."\n";
			$nothing = 0;
		}
	}
	if ($nothing) echo 'No events found!';
	echo '</pre></div>';
}
?>
</body>
</html>