<?php
/****************************************************************************
 Crescendo Player
 
 win only!
 
 supports: $visible, $loop
 doesn't support: $autostart
 
****************************************************************************/
$w = $visible ? 200 : 0;
$h = $visible ? 55 : 2;
?>
<!--[if IE]>
<object 
 classid="clsid:0FC6BF2B-E16A-11CF-AB2E-0080AD08A326" 
 codebase="http://dasdeck.de/crescendo/cres.cab"
 width="<?=$w?>" 
 height="<?=$h?>"
>
<param name="song" value="<?=$file?>" /> 
<![endif]-->
<!--[if !IE]>-->
<object 
 type="application/x-midi"
 data="<?=$file?>" 
 width="<?=$w?>" 
 height="<?=$h?>"
>
<!--<![endif]-->
<param name="loop" value="<?=$loop?'true':'false'?>" />
<a href="http://dasdeck.de/crescendo/c51unimx.exe">Download Crescendo Player</a>
</object>
