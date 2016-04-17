<?php
/****************************************************************************
 OGG HTML5 Player
 
 Firefox (and Opera 9.5) only!
 
 uses experimental tracksandfields midi2ogg service
 additional (optional) parameter: s (=Sample Set, can be eawpats|gm|gm64pro24|gravis|mustheory2|pc51f|unison)
 
 supports: $autostart, $visible
 currently not supported in firefox: $loop
 
****************************************************************************/

$sample_set = 'eawpats'; # can be eawpats|gm|gm64pro24|gravis|mustheory2|pc51f|unison

$w = $visible?290:0;
$h = $visible?24:0;

# FIND URL TO TMP MID FILE
$tmp = explode('/',$_SERVER['SCRIPT_NAME']);
array_pop($tmp);
$path=implode('/', $tmp).'/';
$midi_url = $_SERVER['HTTP_HOST'].$path.$file;

$oggFile_url = 'http://labs.tracksandfields.com/valentin/midi2ogg/?set='.$sample_set.'&amp;f='.urlencode($midi_url);

$autostart = $autostart?' autoplay="autoplay"':'';
$loop = $loop?' playcount="9999"':'';
$visible = $visible?' controls="controls"':'';

?>
<audio src="<?=$oggFile_url?>"<?=$autostart.$loop.$visible?>>
Get Firefox!
</audio>
