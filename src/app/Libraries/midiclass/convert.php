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
<title>CONVERSION</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>

<body>
<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" />
<br />
<input type="submit" value=" send " />
</div>
</form>
<?php

// TEST:
// $midi = new MidiConversion();
// $midi->importMid($file);
// $midi->convertToType0();
// $midi->downloadMidFile('converted.mid');
// exit();

if (@$file){
	
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi_conversion.class.php');
	
	$midi = new MidiConversion();
	$midi->importMid($file);
	
	// SHOW OLD TYPE
	echo '<div style="margin-top:20px">Old Midi-Type: '.$midi->type."<br />\n";	
	
	if ($midi->type==0) die('MIDI Type of file is already 0, nothing to do!');
	
	$midi->convertToType0();

	// SHOW NEW TYPE
	echo 'New Midi-Type: '.$midi->type."<br /><br />\n"; //midi_new
	
	$file = $save_dir.rand().'.mid';
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,1,1,0);
	
?>
<br /><br />
<input type="button" name="download" value="Save converted SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($file)?>'" />
</div>
<?php
}
?>
</body>
</html>