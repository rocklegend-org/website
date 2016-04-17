<?php
/****************************************************************************
 Quicktime Player
  
 supports: $visible, $loop, $autostart
 
****************************************************************************/

$w = $visible?160:2;
$h = $visible?16:2;
?>
<!--[if IE]>
<object 
 classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
 codebase="http://www.apple.com/qtactivex/qtplugin.cab"
 width="<?=$w?>"
 height="<?=$h?>"
>
<param name="src" value="<?=$file?>" />
<![endif]-->
<!--[if !IE]>-->
<object 
 type="video/quicktime" 
 data="<?=$file?>" 
 width="<?=$w?>" 
 height="<?=$h?>">
<!--<![endif]-->
<param name="controller" value="<?=$visible?'true':'false'?>" />
<param name="autoplay" value="<?=$autostart?'true':'false'?>" />
<param name="loop" value="<?=$loop?'true':'false'?>" />
<?=!$visible?'<param name="hidden" value="true" />':''?>
Get Quicktime!
</object>
