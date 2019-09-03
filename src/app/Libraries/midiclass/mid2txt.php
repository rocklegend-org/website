<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

$tt = isset($_POST['tt'])?$_POST['tt']:0;

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
<title>Midi2Text</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>
<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" />
<br />
TimestampType:
<input type="radio" name="tt" value="0"<?php if ($tt==0) echo ' checked="checked"'?> /> Absolute
<input type="radio" name="tt" value="1"<?php if ($tt==1) echo ' checked="checked"'?> /> Delta
<br /><br />
<input type="submit" value=" send " />
</div>
</form>
<?php
if (isset($file)){
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');

	$midi = new Midi();
	$midi->importMid($file);
	
	#$str = chr(0x8d) . chr(0xf9) .chr(0x00);
	#$pos = 0;
	#die("LEN:" . _readVarLen($str, &$pos));
?>
<div>
File: <?=$_FILES['mid_upload']['name']?>
<hr />
<pre>
<?=$midi->getTxt($tt)?>
</pre>
</div>
<?
}
?>
</body>
</html>