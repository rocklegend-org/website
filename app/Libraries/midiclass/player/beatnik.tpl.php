<?php
/****************************************************************************
 Beatnik Player
  
 Win only?
 
 supports: $visible, $loop, $autostart
 
****************************************************************************/

$w = $visible?144:2;
$h = $visible?15:0;
?>
<!--[if IE]>
<object
 classid="CLSID:B384F118-18EE-11D1-95C8-00A024330339"
 codebase="http://dasdeck.de/beatnik/beatnik.cab"
 width="<?=$w?>"
 height="<?=$h?>"
>
<param name="src" value="<?php echo $file?>" />
<param name="type" value="audio/midi" />
<param name="width" value="<?=$w?>" />
<param name="height" value="<?=$h?>" />
<param name="display" value="song" />
<param name="autostart" value="<?=$autostart?'true':'false'?>" />
<param name="loop" value="<?=$loop?'true':'false'?>" />
<![endif]-->
<!--[if !IE]>-->
<object 
 type="audio/rmf" 
 data="<?=$file?>" 
 width="<?=$w?>" 
 height="<?=$h?>">
<!--<![endif]-->
<param name="display" value="song" />
<param name="autostart" value="<?=$autostart?'true':'false'?>" />
<param name="loop" value="<?=$loop?'true':'false'?>" />
<?=!$visible?'<param name="hidden" value="true" />':''?>
Download Beatnik Player:
<a href="http://dasdeck.de/beatnik/beatnik_ie.exe">IE</a>
<a href="http://dasdeck.de/beatnik/beatnik_firefox.exe">Firefox</a>
</object>
