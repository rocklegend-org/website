<?php

error_reporting(E_ALL);
srand((double)microtime()*1000000);
$save_dir = 'tmp/';
$tt = isset($_POST['tt'])?$_POST['tt']:0;
$xm = isset($_POST['xm'])?$_POST['xm']:0;

if (isset($_FILES['mid_upload'])){
	$file = $save_dir.rand().'.mid';
	$tmpFile=$_FILES['mid_upload']['tmp_name'];
	@move_uploaded_file($tmpFile,$file) or die('problems uploading file');
	@chmod($file,0666);
}elseif (isset($_POST['file'])) 
	$file=$_POST['file'];

If (@$file){
	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');
	
	$midi = new Midi();
	$midi->importMid($file);
	$xml = $midi->getXml($tt);
	
	$fn = $_FILES['mid_upload']['name'];
	
	$a = explode('.',$fn);
	$a[count($a)-1] = 'xml';
	$xn = implode('.', $a);
		
	if ($xm==1){
		header('Content-Type: application/octetstream');
		header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Content-Disposition: attachment; filename="'.$xn.'"');
		header('Pragma: no-cache');
		echo $xml;
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Midi2Xml</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="if (this.mid_upload.value==''){alert('Please choose a mid-file to upload!');return false}">
<div>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><!-- 1 MB -->
MIDI file (*.mid) to upload: <input type="file" name="mid_upload" />
<br /><br />
TimestampType:<br />
<input type="radio" name="tt" value="0"<?php if ($tt==0) echo ' checked="checked"'?> /> Absolute<br />
<input type="radio" name="tt" value="1"<?php if ($tt==1) echo ' checked="checked"'?> /> Delta
<br /><br />
<input type="radio" name="xm" value="0"<?php if ($xm==0) echo ' checked="checked"'?> /> Display XML<br />
<input type="radio" name="xm" value="1"<?php if ($xm==1) echo ' checked="checked"'?> /> Download XML
<br /><br />
<input type="submit" value=" send " />
</div>
</form>
<?php
if (@$file&&$xm==0){
	echo '<div style="margin-top:20px">File: '.$fn;
	echo '<hr /><pre>';	
	echo htmlspecialchars($xml);
	echo '</pre></div>';
}
?>
</body>
</html>