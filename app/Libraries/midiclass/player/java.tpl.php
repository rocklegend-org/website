<?php
/****************************************************************************
 Java Applet Player
  
 supports: $visible, $loop, $autostart
 
****************************************************************************/

$w = $visible?32:0;
$h = $visible?32:0;
?>
<object
 classid="clsid:CAFEEFAC-0014-0002-0000-ABCDEFFEDCBA" 
 width="<?=$w?>" 
 height="<?=$h?>" 
 codebase="http://java.sun.com/products/plugin/autodl/jinstall-1_4_2-windows-i586.cab#Version=1,4,2,0"
>
<param name="code" value="MidiApplet.class" />
<param name="type" value="application/x-java-applet;jpi-version=1.4.2" />
<param name="src" value="<?=$file?>" />
<param name="autostart" value="<?=$auto?1:0?>" />
<param name="loop" value="<?=$loop?1:0?>" />
<comment>
<embed type="application/x-java-applet;jpi-version=1.4.2"
 code="MidiApplet.class" 
 width="<?=$w?>" 
 height="<?=$h?>" 
 pluginspage="http://java.sun.com/products/plugin/index.html#download" 
 autostart="<?=$auto?1:0?>" 
 loop="<?=$loop?1:0?>">
</embed>
</comment>
</object>
