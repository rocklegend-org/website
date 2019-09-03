<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

if (isset($_POST['save'])){
	$mime_type = 'application/octetstream'; // force download
	header('Content-Type: '.$mime_type);
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Disposition: attachment; filename="rttl.txt"');
	header('Pragma: no-cache');
	echo $_POST['rttl'];
	exit();
}

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
<title>Midi2Rttl</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="if (this.mid_upload.value==''){return true;alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: 
<input type="file" name="mid_upload" /> 
<input type="submit" value=" send " />
</div>
</form>

<div style="margin-top:20px">
Notice: The MIDI to RTTL conversion only works for simple Midi files of type 0. Here some sample files:<br />
<ul>
<li><a href="sample_files/beethoven1.mid">beethoven1.mid</a></li>
<li><a href="sample_files/beethoven2.mid">beethoven2.mid</a></li>
<li><a href="sample_files/peter_wolf.mid">peter_wolf.mid</a></li>
<li><a href="sample_files/suite1.mid">suite1.mid</a></li>
<li><a href="sample_files/flute.mid">flute.mid</a></li>
</ul>
<?php

if (@$file){

	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi_rttl.class.php');
	
	$fn = $_FILES['mid_upload']['name'];
	$bn = strtok($fn, '.');
	
	$midi = new MidiRttl();
	
	// TEST
	$midi->defaultDur = 8;
	$midi->defaultScale = 7;

	$midi->importMid($file);
?>
<hr />
RTTL converted from: <?=$fn?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<div>
<textarea name="rttl" style="width:90%" cols="60" rows="2"><?=$midi->getRttl($bn)?></textarea><br />
<input type="submit" name="save" value="save" />
</div>
</form>
<?php
}
?>
</div>

</body>
</html>