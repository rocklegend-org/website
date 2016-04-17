function keyDownHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if(RL.editMode && RL.config.trackTaps){
            EditorManager.addTap(index, AudioManager.currentTime, hopoNote);
        }else{
            HighwayManager.startHitDetection(index);
        }

        if(index <= 5){
            HighwayManager.aButtons[index].frame = 5*index-4;
        }
    }
}

function keyHoldHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if(RL.editMode && RL.config.trackTaps){
            EditorManager.holdTap(index, e.duration, AudioManager.currentTime, hopoNote);
        }else{
            HighwayManager.continueHitDetection(index, e.duration);
        }
    }
}

function keyUpHandler(e){
    if(!$('input, textarea').is(':focus')){
        var index = RL.keyCodeToIndex(e.keyCode);
        var hopoNote = e.ctrlKey;

        if( RL.editMode && 
            RL.config.trackTaps && 
            e.duration >= RL.config.longNoteThreshold)
        {
            EditorManager.finishTap(index, e.duration, AudioManager.currentTime, hopoNote);
        }
        else if( !RL.config.trackTaps || !RL.editMode )
        {
            HighwayManager.endHitDetection(index);
        }

        if(index <= 5){
            HighwayManager.aButtons[index].frame = 5*index-5;
        }
    }
}
/** TOUCH EVENtS
function touchDownHandler(button, e){
    RL.HighwayManager.aButtons[button.lane-1].frame = 1;

    if(typeof(edit_mode) != 'undefined' && edit_mode && RL.config.trackTaps){
    	RL.managers.EditorManager.addTap(button.lane-1, RL.AudioManager.getPosition());
    }else{
    	noteControl.startHitDetection(button.lane-1, RL.AudioManager.getPosition());
    }
}

function touchUpHandler(button, e){
    RL.HighwayManager.aButtons[button.lane-1].frame = 0;

    if(typeof(edit_mode) != 'undefined' && edit_mode && RL.config.trackTaps && e.timeUp - e.timeDown >= RL.config.longNoteThreshold){
    	RL.managers.EditorManager.finishTap(button.lane-1, e.timeUp-e.timeDown);
    }
}
**/

/**
 * Interaction manager for general rocklegend functions
 *
 * @module RL.InteractionManager
 */
RL.InteractionManager = function() {
return {
    playing: false,
    aKeyboardEvents: [],
    keyboardPresses: [0,0,0,0,0,0],
    strumDuration: [0,0,0,0,0,0],

	init: function(){
        game.input.touch.preventDefault = false;

        var startPlayKey = game.input.keyboard.addKey(32);
        startPlayKey.onDown.add(this.togglePlayback, this);
	},

	togglePlayback: function(){
		if(RL.editMode){
            if(this.playing){
                AudioManager.pause();
                jQuery('.audio-controls .toggle-playback').addClass('paused');
                this.playing = false;
             }else{
                AudioManager.play();
                jQuery('.audio-controls .toggle-playback').removeClass('paused');
                this.playing = true;
             }
		}else{
            if(!this.playing && !$('input, textarea').is(':focus')){
                this.playing = true;
                HighwayManager.countIn(true);
            }
		}
	}
}
};