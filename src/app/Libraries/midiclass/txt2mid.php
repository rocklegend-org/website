<?php
@set_time_limit(120);
error_reporting(E_ALL);

$PHP_SELF = $_SERVER['PHP_SELF'];

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

if (isset($_POST['txt'])){
	$txt = $_POST['txt'];
	if (get_magic_quotes_gpc()==1) $txt = stripslashes($txt);
}else{
	$txt = 'MFile 1 5 480
MTrk
0 SeqSpec 00 00 41
0 Meta Text "Seq-1"
0 SMPTE 96 0 10 0 0
0 TimeSig 4/4 24 8
0 Tempo 500000
0 Meta TrkEnd
TrkEnd
MTrk
0 Meta Text "Organ"
0 Par ch=13 c=6 v=0
0 Par ch=13 c=7 v=100
0 Par ch=13 c=64 v=0
0 Pb ch=13 v=8192
0 PrCh ch=13 p=16
480 On ch=13 n=55 v=87
960 On ch=13 n=74 v=85
960 On ch=13 n=70 v=97
1059 Off ch=13 n=74 v=53
1063 Off ch=13 n=70 v=78
1440 On ch=13 n=70 v=95
1440 On ch=13 n=74 v=85
1920 On ch=13 n=51 v=101
1934 Off ch=13 n=55 v=60
1999 Off ch=13 n=70 v=36
2002 Off ch=13 n=74 v=44
2400 On ch=13 n=70 v=95
2400 On ch=13 n=73 v=99
2505 Off ch=13 n=73 v=73
2508 Off ch=13 n=70 v=64
2880 On ch=13 n=70 v=103
2880 On ch=13 n=73 v=103
3360 On ch=13 n=55 v=99
3362 Off ch=13 n=51 v=85
3453 Off ch=13 n=73 v=56
3466 Off ch=13 n=70 v=57
3840 On ch=13 n=70 v=97
3840 On ch=13 n=74 v=90
3951 Off ch=13 n=70 v=72
3960 Off ch=13 n=74 v=57
4320 On ch=13 n=70 v=105
4320 On ch=13 n=74 v=92
4800 On ch=13 n=51 v=107
4810 Off ch=13 n=55 v=58
4920 Off ch=13 n=74 v=33
4932 Off ch=13 n=70 v=41
5280 On ch=13 n=70 v=111
5280 On ch=13 n=73 v=95
5383 Off ch=13 n=73 v=58
5392 Off ch=13 n=70 v=70
5760 On ch=13 n=73 v=92
5760 On ch=13 n=70 v=103
6178 Off ch=13 n=73 v=67
6178 Off ch=13 n=70 v=66
6192 Off ch=13 n=51 v=81
6240 On ch=13 n=55 v=82
6240 On ch=13 n=70 v=111
6240 On ch=13 n=74 v=103
6412 Off ch=13 n=70 v=87
6425 Off ch=13 n=74 v=65
6475 Off ch=13 n=55 v=59
6720 Pb ch=13 v=8192
6720 Par ch=13 c=64 v=0
6720 Par ch=13 c=7 v=100
6720 Par ch=13 c=6 v=0
6720 Meta TrkEnd
TrkEnd
MTrk
0 Meta Text "Fantasia"
0 Par ch=14 c=6 v=0
0 Par ch=14 c=7 v=100
0 Par ch=14 c=64 v=0
0 Pb ch=14 v=8192
0 PrCh ch=14 p=88
480 On ch=14 n=67 v=75
600 Off ch=14 n=67 v=36
600 On ch=14 n=68 v=83
720 Off ch=14 n=68 v=44
720 On ch=14 n=69 v=74
840 Off ch=14 n=69 v=46
840 On ch=14 n=70 v=81
960 Off ch=14 n=70 v=47
960 On ch=14 n=71 v=77
1080 Off ch=14 n=71 v=43
1080 On ch=14 n=72 v=71
1200 Off ch=14 n=72 v=34
1200 On ch=14 n=73 v=83
1320 Off ch=14 n=73 v=51
1320 On ch=14 n=74 v=80
1440 Off ch=14 n=74 v=38
1440 On ch=14 n=75 v=76
1560 Off ch=14 n=75 v=36
1560 On ch=14 n=76 v=69
1680 Off ch=14 n=76 v=44
1680 On ch=14 n=77 v=75
1800 Off ch=14 n=77 v=31
1800 On ch=14 n=78 v=74
1920 Off ch=14 n=78 v=41
1920 On ch=14 n=79 v=81
2040 Off ch=14 n=79 v=46
2040 On ch=14 n=78 v=71
2160 Off ch=14 n=78 v=48
2160 On ch=14 n=77 v=68
2280 Off ch=14 n=77 v=32
2280 On ch=14 n=76 v=71
2400 Off ch=14 n=76 v=35
2400 On ch=14 n=75 v=80
2520 Off ch=14 n=75 v=45
2520 On ch=14 n=74 v=71
2640 Off ch=14 n=74 v=28
2640 On ch=14 n=73 v=86
2760 Off ch=14 n=73 v=36
2760 On ch=14 n=72 v=73
2880 Off ch=14 n=72 v=27
2880 On ch=14 n=71 v=62
3000 Off ch=14 n=71 v=35
3000 On ch=14 n=72 v=66
3120 Off ch=14 n=72 v=30
3120 On ch=14 n=73 v=90
3240 Off ch=14 n=73 v=32
3240 On ch=14 n=74 v=86
3360 Off ch=14 n=74 v=44
3360 On ch=14 n=75 v=67
3480 Off ch=14 n=75 v=32
3480 On ch=14 n=76 v=67
3600 Off ch=14 n=76 v=38
3600 On ch=14 n=77 v=62
3720 Off ch=14 n=77 v=28
3720 On ch=14 n=78 v=72
3840 Off ch=14 n=78 v=44
3840 On ch=14 n=79 v=77
3960 Off ch=14 n=79 v=44
3960 On ch=14 n=80 v=85
4080 Off ch=14 n=80 v=40
4080 On ch=14 n=81 v=75
4200 Off ch=14 n=81 v=41
4200 On ch=14 n=82 v=83
4320 Off ch=14 n=82 v=55
4320 On ch=14 n=83 v=80
4440 Off ch=14 n=83 v=48
4440 On ch=14 n=84 v=62
4560 Off ch=14 n=84 v=33
4560 On ch=14 n=85 v=83
4680 Off ch=14 n=85 v=56
4680 On ch=14 n=86 v=85
4800 Off ch=14 n=86 v=31
4800 On ch=14 n=87 v=81
4920 Off ch=14 n=87 v=40
4920 On ch=14 n=86 v=64
5040 Off ch=14 n=86 v=39
5040 On ch=14 n=85 v=71
5160 Off ch=14 n=85 v=35
5160 On ch=14 n=84 v=72
5280 Off ch=14 n=84 v=35
5280 On ch=14 n=83 v=62
5400 Off ch=14 n=83 v=34
5400 On ch=14 n=82 v=62
5520 Off ch=14 n=82 v=40
5520 On ch=14 n=81 v=58
5640 Off ch=14 n=81 v=37
5640 On ch=14 n=80 v=71
5760 Off ch=14 n=80 v=38
5760 On ch=14 n=81 v=55
5880 Off ch=14 n=81 v=29
5880 On ch=14 n=80 v=68
6000 Off ch=14 n=80 v=25
6000 On ch=14 n=79 v=52
6120 Off ch=14 n=79 v=31
6120 On ch=14 n=78 v=87
6240 Off ch=14 n=78 v=45
6240 On ch=14 n=79 v=81
6360 Off ch=14 n=79 v=64
6720 Pb ch=14 v=8192
6720 Par ch=14 c=64 v=0
6720 Par ch=14 c=7 v=100
6720 Par ch=14 c=6 v=0
6720 Meta TrkEnd
TrkEnd
MTrk
0 Meta Text "Organ 2"
0 Par ch=1 c=6 v=0
0 Par ch=1 c=7 v=100
0 Par ch=1 c=64 v=0
0 Pb ch=1 v=8192
0 PrCh ch=1 p=16
480 On ch=1 n=55 v=87
960 On ch=1 n=74 v=85
960 On ch=1 n=70 v=97
1059 Off ch=1 n=74 v=53
1063 Off ch=1 n=70 v=78
1440 On ch=1 n=70 v=95
1440 On ch=1 n=74 v=85
1920 On ch=1 n=51 v=101
1934 Off ch=1 n=55 v=60
1999 Off ch=1 n=70 v=36
2002 Off ch=1 n=74 v=44
2400 On ch=1 n=70 v=95
2400 On ch=1 n=73 v=99
2505 Off ch=1 n=73 v=73
2508 Off ch=1 n=70 v=64
2880 On ch=1 n=70 v=103
2880 On ch=1 n=73 v=103
3360 On ch=1 n=55 v=99
3362 Off ch=1 n=51 v=85
3453 Off ch=1 n=73 v=56
3466 Off ch=1 n=70 v=57
3840 On ch=1 n=70 v=97
3840 On ch=1 n=74 v=90
3951 Off ch=1 n=70 v=72
3960 Off ch=1 n=74 v=57
4320 On ch=1 n=70 v=105
4320 On ch=1 n=74 v=92
4800 On ch=1 n=51 v=107
4810 Off ch=1 n=55 v=58
4920 Off ch=1 n=74 v=33
4932 Off ch=1 n=70 v=41
5280 On ch=1 n=70 v=111
5280 On ch=1 n=73 v=95
5383 Off ch=1 n=73 v=58
5392 Off ch=1 n=70 v=70
5760 On ch=1 n=73 v=92
5760 On ch=1 n=70 v=103
6178 Off ch=1 n=73 v=67
6178 Off ch=1 n=70 v=66
6192 Off ch=1 n=51 v=81
6240 On ch=1 n=55 v=82
6240 On ch=1 n=70 v=111
6240 On ch=1 n=74 v=103
6412 Off ch=1 n=70 v=87
6425 Off ch=1 n=74 v=65
6475 Off ch=1 n=55 v=59
6720 Pb ch=1 v=8192
6720 Par ch=1 c=64 v=0
6720 Par ch=1 c=7 v=100
6720 Par ch=1 c=6 v=0
6720 Meta TrkEnd
TrkEnd
MTrk
0 Meta Text "Fantasia 2"
0 Par ch=2 c=6 v=0
0 Par ch=2 c=7 v=100
0 Par ch=2 c=64 v=0
0 Pb ch=2 v=8192
0 PrCh ch=2 p=88
480 On ch=2 n=67 v=75
600 Off ch=2 n=67 v=36
600 On ch=2 n=68 v=83
720 Off ch=2 n=68 v=44
720 On ch=2 n=69 v=74
840 Off ch=2 n=69 v=46
840 On ch=2 n=70 v=81
960 Off ch=2 n=70 v=47
960 On ch=2 n=71 v=77
1080 Off ch=2 n=71 v=43
1080 On ch=2 n=72 v=71
1200 Off ch=2 n=72 v=34
1200 On ch=2 n=73 v=83
1320 Off ch=2 n=73 v=51
1320 On ch=2 n=74 v=80
1440 Off ch=2 n=74 v=38
1440 On ch=2 n=75 v=76
1560 Off ch=2 n=75 v=36
1560 On ch=2 n=76 v=69
1680 Off ch=2 n=76 v=44
1680 On ch=2 n=77 v=75
1800 Off ch=2 n=77 v=31
1800 On ch=2 n=78 v=74
1920 Off ch=2 n=78 v=41
1920 On ch=2 n=79 v=81
2040 Off ch=2 n=79 v=46
2040 On ch=2 n=78 v=71
2160 Off ch=2 n=78 v=48
2160 On ch=2 n=77 v=68
2280 Off ch=2 n=77 v=32
2280 On ch=2 n=76 v=71
2400 Off ch=2 n=76 v=35
2400 On ch=2 n=75 v=80
2520 Off ch=2 n=75 v=45
2520 On ch=2 n=74 v=71
2640 Off ch=2 n=74 v=28
2640 On ch=2 n=73 v=86
2760 Off ch=2 n=73 v=36
2760 On ch=2 n=72 v=73
2880 Off ch=2 n=72 v=27
2880 On ch=2 n=71 v=62
3000 Off ch=2 n=71 v=35
3000 On ch=2 n=72 v=66
3120 Off ch=2 n=72 v=30
3120 On ch=2 n=73 v=90
3240 Off ch=2 n=73 v=32
3240 On ch=2 n=74 v=86
3360 Off ch=2 n=74 v=44
3360 On ch=2 n=75 v=67
3480 Off ch=2 n=75 v=32
3480 On ch=2 n=76 v=67
3600 Off ch=2 n=76 v=38
3600 On ch=2 n=77 v=62
3720 Off ch=2 n=77 v=28
3720 On ch=2 n=78 v=72
3840 Off ch=2 n=78 v=44
3840 On ch=2 n=79 v=77
3960 Off ch=2 n=79 v=44
3960 On ch=2 n=80 v=85
4080 Off ch=2 n=80 v=40
4080 On ch=2 n=81 v=75
4200 Off ch=2 n=81 v=41
4200 On ch=2 n=82 v=83
4320 Off ch=2 n=82 v=55
4320 On ch=2 n=83 v=80
4440 Off ch=2 n=83 v=48
4440 On ch=2 n=84 v=62
4560 Off ch=2 n=84 v=33
4560 On ch=2 n=85 v=83
4680 Off ch=2 n=85 v=56
4680 On ch=2 n=86 v=85
4800 Off ch=2 n=86 v=31
4800 On ch=2 n=87 v=81
4920 Off ch=2 n=87 v=40
4920 On ch=2 n=86 v=64
5040 Off ch=2 n=86 v=39
5040 On ch=2 n=85 v=71
5160 Off ch=2 n=85 v=35
5160 On ch=2 n=84 v=72
5280 Off ch=2 n=84 v=35
5280 On ch=2 n=83 v=62
5400 Off ch=2 n=83 v=34
5400 On ch=2 n=82 v=62
5520 Off ch=2 n=82 v=40
5520 On ch=2 n=81 v=58
5640 Off ch=2 n=81 v=37
5640 On ch=2 n=80 v=71
5760 Off ch=2 n=80 v=38
5760 On ch=2 n=81 v=55
5880 Off ch=2 n=81 v=29
5880 On ch=2 n=80 v=68
6000 Off ch=2 n=80 v=25
6000 On ch=2 n=79 v=52
6120 Off ch=2 n=79 v=31
6120 On ch=2 n=78 v=87
6240 Off ch=2 n=78 v=45
6240 On ch=2 n=79 v=81
6360 Off ch=2 n=79 v=64
6720 Pb ch=2 v=8192
6720 Par ch=2 c=64 v=0
6720 Par ch=2 c=7 v=100
6720 Par ch=2 c=6 v=0
6720 Meta TrkEnd
TrkEnd';

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Text2Midi</title>
<link rel="stylesheet" type="text/css" href="css/midi.css" />
</head>
<body>

<form action="<?=$PHP_SELF?>" method="post">
<div>
<textarea name="txt" cols="100" rows="30"><?php echo $txt?></textarea><br />
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
<br /><br />
<input type="submit" value=" send " />
</div>
</form>

<div style="margin-top:20px">
<?php
if (isset($_POST['txt'])){
	$save_dir = 'tmp/';
	srand((double)microtime()*1000000);
	$file = $save_dir.rand().'.mid';

	/****************************************************************************
	MIDI CLASS CODE
	****************************************************************************/
	require('./classes/midi.class.php');

	$midi = new Midi();
	$midi->importTxt($txt);
	$midi->saveMidFile($file, 0666);
	$midi->playMidFile($file,$visible,$autostart,$loop,$player);
?>
<br /><br /><input type="button" name="download" value="Save as SMF (*.mid)" onclick="self.location.href='download.php?f=<?php echo urlencode($file)?>'" />
<?php
}
?>
</div>

</body>
</html>