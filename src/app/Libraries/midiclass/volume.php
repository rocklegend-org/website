<?php

error_reporting(E_ALL);
$PHP_SELF = $_SERVER['PHP_SELF'];
srand((double)microtime()*1000000);
$save_dir = 'tmp/';

$vol = isset($_POST['vol'])?(int)$_POST['vol']:64;

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
<title>Volume</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$PHP_SELF?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" /><br />
<br />
Volume: <select name="vol">
<?php
	for ($i=127;$i>=0;$i--)
		echo '<option value="'.$i.'".'.($vol==$i?' selected="selected"':'').'>'.$i.'</option>';
?>
</select><br />
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
	require('./classes/midi_volume.class.php');
	
	$midi = new MidiVolume();
	$midi->importMid($file);
	
	// SHOW OLD VOLUMES
	echo '<b>Volumes before:</b><br /><br />';	
	$volumes = $midi->getVolumes();
	echo '<table border="1" cellspacing="0"><tr><td>Channel&nbsp;&nbsp;</td><td>Volume</td></tr>';
	foreach ($volumes as $chan=>$vol)
		echo '<tr><td>'.$chan.'</td><td>'.$vol.'</td></tr>';
	echo '</table><br /><br />';

	#$midi->setChannelVolume(1, 30); // CHANGES VOLUME OF CHANNEL 1
	$midi->setGlobalVolume($vol);     // CHANGES VOLUME OF ALL CHANNELS
	
	// SHOW NEW VOLUMES
	echo '<b>Volumes after conversion:</b><br /><br />';	
	$volumes = $midi->getVolumes();
	echo '<table border="1" cellspacing="0"><tr><td>Channel&nbsp;&nbsp;</td><td>Volume</td></tr>';
	foreach ($volumes as $chan=>$vol)
		echo '<tr><td>'.$chan.'</td><td>'.$vol.'</td></tr>';
	echo '</table><br />';
	
	$file = $save_dir.rand().'.mid';
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,1,1,0);
?>
	<br /><br /><input type="button" name="download" value="Save converted SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($file)?>'" />
<?php
}
?>
</div>

</body>
</html>