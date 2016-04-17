<?php
/****************************************************************************
 MP3 Flash Player
 
 uses experimental tracksandfields midi2mp3 service
 additional (optional) parameter: s (=Sample Set, can be eawpats|gm|gm64pro24|gravis|mustheory2|pc51f|unison)
 
 supports: $visible, $loop, $autostart
 
****************************************************************************/

$sample_set = 'unison'; # can be eawpats|gm|gm64pro24|gravis|mustheory2|pc51f|unison

$w = $visible?290:0;
$h = $visible?24:0;

# FIND URL TO TMP MID FILE
$tmp = explode('/',$_SERVER['SCRIPT_NAME']);
array_pop($tmp);
$path=implode('/', $tmp).'/';
$midi_url = $_SERVER['HTTP_HOST'].$path.$file;

$mp3File_url = 'http://labs.tracksandfields.com/valentin/midi2mp3/?'.urlencode('s='.$sample_set.'&f='.$midi_url);

$autostart = $autostart?'yes':'no';
$loop = $loop?'yes':'no';

?>
<object 
 type="application/x-shockwave-flash" 
 data="player/player.swf" 
 width="<?=$w?>" 
 height="<?=$h?>" 
 id="audioplayer1"
>
<param name="movie" value="player/player.swf" />
<param name="FlashVars" value="playerID=1&amp;bg=0xf8f8f8&amp;leftbg=0xeeeeee&amp;lefticon=0x666666&amp;rightbg=0xcccccc&amp;rightbghover=0x999999&amp;righticon=0x666666&amp;righticonhover=0xffffff&amp;text=0x666666&amp;slider=0x666666&amp;track=0xFFFFFF&amp;border=0x666666&amp;loader=0x9FFFB8&amp;soundFile=<?=$mp3File_url?>&amp;autostart=<?=$autostart?>&amp;loop=<?=$loop?>" />
Get Flash!
</object>
