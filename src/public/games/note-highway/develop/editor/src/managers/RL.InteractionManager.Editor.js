/**
 * Interaction manager for editor functions
 *
 * @module RL.InteractionManager.Editor
 */

RL.InteractionManager.Editor = function(){
return {
	init: function(){
		$('body').on('copy', function(e)
		{
			EditorManager.copyNotes(e);
		});
		$('body').on('paste', function(e)
		{
			EditorManager.pasteNotes(e);
		});
		$('#grid').on('change', function(){
			EditorManager.grid = parseFloat($(this).find('option:selected').val());
			EditorManager.drawBeatLines(true);
		});

		$('#ticksCB').on('change', function(){
			EditorManager.playTicks = $('#ticksCB:checked').length > 0 ? true : false;
		});

		$('#toggleLines').on('change', function(){
			if($('#toggleLines:checked').length > 0){
				EditorManager.advancedMode = true;
			}else{
				EditorManager.advancedMode = false;
				EditorManager.deleteBeatLines();
			}
		});

		$('#move_notes').on('click', function(e){
			e.preventDefault();

			var ms = $('input[name="move_notes_ms"]').val();
			if(confirm('Are you sure you want to move all notes of this track by '+ms+'ms?')){
				EditorManager.notesChanged = 0;
				EditorManager.moveAllByMs(ms);
			}
		});

		$('#sel-note-time').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].time = parseFloat($(this).val());
					EditorManager.aSelectedNotes[i].updateY();
				}
			}
		});

		$('#sel-note-lane').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].updateLane($(this).val());
				}
			}
		});

		$('#sel-note-duration').on('change', function(){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].updateDuration($(this).val());
				}
			}
		});

		$('#sel-note-distance').on('change', function(){
			var num = $(this).val();
			if(!isNaN(num)){
				EditorManager.aSelectedNotes[0].cb = 'HighwayManager.animateNoteDistance('+num+')';
			}else{
				$(this).val('-');
				EditorManager.aSelectedNotes[0].cb = '';
			}
		});

		$('#sel-note-hopo').on('change', function(){
			var state = $('#sel-note-hopo:checked').length;

			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i]){
					EditorManager.aSelectedNotes[i].setHOPO(state);
				}
			}
		});

		$('#deselect-all').on('click', function(e){
			e.preventDefault();

			EditorManager.resetSelectedNotes();
		});

		$('#copy-selected a').on('click', function(e){
			e.preventDefault();

			EditorManager.copyNotes(e);
		});

		$('#paste-copied a').on('click', function(e){
			e.preventDefault();

			EditorManager.pasteNotes(e);
		});

		$('#previous-selection a').on('click', function(e){
			e.preventDefault();

			EditorManager.activatePreviousSelection(e);
		});

		jQuery('#autoSaveCB').on('change', EditorManager.toggleAutoSave);

		jQuery('.toggle-playback').on('click', InteractionManager.togglePlayback);

		var seekForwardKey = game.input.keyboard.addKey(RL.config.seekForwardKey);
		seekForwardKey.onHoldCallback = EditorInteractionManager.seekForward;

		var seekBackwardKey = game.input.keyboard.addKey(RL.config.seekBackwardKey);
		seekBackwardKey.onHoldCallback = EditorInteractionManager.seekBackward;

		var speedUpKey = game.input.keyboard.addKey(RL.config.speedUpKey);
		speedUpKey.onHoldCallback = EditorInteractionManager.speedUp;

		var speedDownKey = game.input.keyboard.addKey(RL.config.speedDownKey);
		speedDownKey.onHoldCallback = EditorInteractionManager.speedDown;

		var deleteKey = game.input.keyboard.addKey(RL.config.deleteKey);
		deleteKey.onDown.add(EditorManager.deleteNotes, this);

		var newLineKey = game.input.keyboard.addKey(RL.config.newLineKey);
		newLineKey.onDown.add(EditorManager.newLine, this);

		jQuery('.mute').on('click', EditorInteractionManager.toggleMute);

		jQuery('#btn-finish').on('click', EditorManager.finish);
		jQuery('#btn-save').on('click', EditorManager.save);

		/** config values **/

		jQuery('input[name="destroyNotes"]').on('change', function(){
			jQuery(this).is(':checked') ? RL.config.destroyNotes = true : RL.config.destroyNotes = false;
		});

		EditorManager.autoSaveSlider = jQuery('#slider-autoSave').slider({
			value: EditorManager.auto_save_interval,
			range: "min",
			min: 5,
			max: 1800,
			step: 5,
			slide: function(event, ui){
				tval = ui.value+' seconds';
				if(ui.value >= 60){
					tval = parseFloat(ui.value/60).toFixed(1)+' minutes';
				}
				jQuery('#auto-save-interval').html(tval);
				EditorManager.auto_save_interval = ui.value;
				EditorManager.toggleAutoSave(null, true);
			}
		});

		EditorManager.pxPerSecondSlider = jQuery('#slider-pxPerSecond').slider({
			value: RL.config.pxPerSecond,
			range: "min",
			min: 30,
			max: 1000,
			step: 1,
			slide: function(event, ui){
				jQuery('#pxPerSecond').html(ui.value);
				RL.config.pxPerSecond = ui.value;
		        RL.config.pxPerMs = RL.config.pxPerSecond / 1000;
		        RL.negPxPerMs = -RL.config.pxPerMs;
        		RL.msOnScreen = RL.config.height / RL.config.pxPerMs;

				if(EditorManager.advancedMode){
					EditorManager.drawBeatLines(true);
				}
				
				HighwayManager.updateNotes(HighwayManager.aNotes);
			}
		});

		setTimeout(function(){
			jQuery('#slider-position').html('');
			EditorManager.positionSlider = jQuery('#slider-position').slider({
				value: 0,
				range: "min",
				min: 0,
				max: AudioManager.getDuration(),
				step: 1,
				slide: function(event, ui){
					AudioManager.setPosition(ui.value);
				}
			});
		}, 500)

		EditorManager.playbackRateSlider = jQuery('#slider-playbackRate').slider({
			value: RL.config.playbackRate,
			range: "min",
			min: 0.5,
			max: 4,
			step: 0.1,
			slide: function(event, ui){
				jQuery('#playbackRate').html(ui.value);
				RL.config.playbackRate = ui.value;
				AudioManager.setPlaybackRate(ui.value);
			}
		});

		jQuery('input[name="tracking"]').on('click', function(){
			EditorManager.toggleTracking();
		});

		jQuery('input[type="text"]').on('focus', function(){
			if(RL.config.trackTaps){
				EditorManager.toggleTracking();
				jQuery(this).data('trackTaps', true);
			}else{
				jQuery(this).data('trackTaps', false);
			}
		});

		jQuery('input[type="text"]').on('focusout', function(){
			if(jQuery(this).data('trackTaps')){
				EditorManager.toggleTracking();
			}
		})
	},
	seekForward: function(e, time){
		if(typeof(time) == 'undefined') time = typeof(e.duration) != 'undefined' ? e.duration/10 : 1;
		AudioManager.setPosition(AudioManager.getPosition()+time);
	},

	seekBackward: function(e, time){
		if(typeof(time) == 'undefined') time = typeof(e.duration) != 'undefined' ? e.duration/10 : 1;
		AudioManager.setPosition(AudioManager.getPosition()-time);
	},

	speedUp: function(e, speed){
		if(typeof(speed) == 'undefined') speed = AudioManager.getPlaybackRate() + 0.005;
		if(speed > 4) speed = 4;
		AudioManager.setPlaybackRate(speed);
		EditorManager.playbackRateSlider.slider('value', speed);
		jQuery('#playbackRate').html(speed.toFixed(2));
	},

	speedDown: function(e, speed){
		if(typeof(speed) == 'undefined') speed = AudioManager.getPlaybackRate() - 0.005;
		if(speed < 0.5) speed = 0.5;
		AudioManager.setPlaybackRate(speed);
		EditorManager.playbackRateSlider.slider('value', speed);
		jQuery('#playbackRate').html(speed.toFixed(2));
	},

	// TODO: change for soundjs -- add mute function to audiomanager
	toggleMute: function(){
		if(typeof(AudioManager.muted) != 'undefined'){
			AudioManager.toggleMute();
			AudioManager.muted ? jQuery('.audio-controls .mute').removeClass('unmute') : jQuery('.audio-controls .mute').addClass('unmute');
		}
	},

	resetSpeed: function(e, speed){
		AudioManager.setPlaybackRate(1);
	},
	handleCanvasUp: function(e)
	{
	    HighwayManager.containerDragStart = 0;
	},
	handleCanvasDown: function(e)
	{
	    if(e.button == 0){
	        HighwayManager.containerDragStart = e.positionDown.y;
	    }else if(e.button == 2){
	        dist = (( RL.config.buttonY - e.positionDown.y) / RL.config.pxPerSecond);
	        time = AudioManager.getPosition() + dist + 0.1;
	        /*if(time > 0)
	            RL.managers.EditorManager.addTap(RL.Note.prototype.setLaneForX(e.positionDown.x, true)-1, time);*/
	    }
	}
}
};