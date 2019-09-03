<?php
/****************************************************************************
 Windows Media Player
  
 Win only!
 
 supports: $visible, $loop, $autostart
 
****************************************************************************/

$w = $visible?300:2;
$h = $visible?44:0;
?>
<!--[if IE]>
<object
 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" 
 codebase="http://www.microsoft.com/ntserver/netshow/download/en/nsmp2inf.cab#Version=5,1,51,415" 
 type="application/x-oleobject" 
 width="<?=$w?>"
 height="<?=$h?>"
>
<param name="FileName" value="<?=$file?>" />
<param name="ControlType" value="1" />
<param name="AutoStart" value="<?=$autostart?'true':'false'?>" />
<param name="Loop" value="<?=$loop?'true':'false'?>" />
<param name="ShowControls" value="<?=$visible?'true':'false'?>" />
<![endif]-->
<!--[if !IE]>-->
<object 
 type="video/x-ms-asf-plugin" 
 data="<?=$file?>" 
 width="<?=$w?>" 
 height="<?=$h?>">
<!--<![endif]-->
<param name="AutoStart" value="<?=$autostart?'true':'false'?>" />
<param name="Loop" value="<?=$loop?'true':'false'?>" />
<param name="ShowControls" value="<?=$visible?'true':'false'?>" />
Get Windows Media Player (Plugin)!
</object>
