<?php
/****************************************************************************
 BgSound Player
 
 IE win only!
 
 supports: $visible, $loop, $autostart
 
****************************************************************************/
?>
<!--[if IE]>
<bgsound id="midiBg" src="<?=$autostart?$file:''?>"<?=$loop?' loop="infinite"':''?> />
<script type="text/javascript">
function toggleMidi(){
	var bg = document.getElementById('midiBg');
  var ctrl = document.getElementById('midiCtrl');
  if(bg.src==''){
  	bg.src='<?=$file?>';
  	ctrl.innerHTML='[Stop MIDI]';
  }else{
  	bg.src='';
  	ctrl.innerHTML='[Play MIDI]';
  }
	return false;
}
</script>
<? if ($visible){ ?>
<a id="midiCtrl" href="#" onclick="return toggleMidi()">[<?=$autostart?'Stop MIDI':'Play MIDI'?>]</a>
<? } ?>
<![endif]-->
<!--[if !IE]>-->
BgSound-Element not supported by this Browser!
<!--<![endif]-->
