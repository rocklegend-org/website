<?php
/****************************************************************************
 Default Player 
****************************************************************************/

$visible=true;

$w = $visible ? 160 : 0;
$h = $visible ? 16 : 2;
?>
<object 
 type="audio/midi"
 data="<?=$file?>" 
 width="<?=$w?>" 
 height="<?=$h?>"
 style="visibility:<?=$visible?'visible':'hidden'?>"
>
<param name="src" value="<?=$file?>" />
<param name="autostart" value="<?=$autostart?'true':'false'?>" />
<param name="loop" value="<?=$loop?'true':'false'?>" />
Get a MIDI player!
</object>
