function keyDownHandler(e){
    var index = RL.keyCodeToIndex(e.keyCode);

    HighwayManager.startHitDetection(index);

    if(index <= 5){
        HighwayManager.aButtons[index].frame = 5*index-4;
    }
}

function keyHoldHandler(e){
    var index = RL.keyCodeToIndex(e.keyCode);
    
    HighwayManager.continueHitDetection(index, e.duration);
}

function keyUpHandler(e){
    var index = RL.keyCodeToIndex(e.keyCode);
    
    HighwayManager.endHitDetection(index);

    if(index <= 5){
        HighwayManager.aButtons[index].frame = 5*index-5;
    }
}

function touchDownHandler(button, e){
    button.frame = 5*(button.lane)-4;
    button.isPressed = true;
    button.started = game.time.now;
   	HighwayManager.startHitDetection(button.lane);
}

function touchUpHandler(button, e){    
    button.frame = 5*(button.lane)-5;
    button.isPressed = false;   
    button.started = false; 
    HighwayManager.endHitDetection(button.lane);
}

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
    restartLastHit: 0,
    initialized: false,

	init: function(){
        var self = this;

        this.initialized = true;

        game.input.touch.preventDefault = false;

        var startPlayKey = game.input.keyboard.addKey(32);
        startPlayKey.onDown.add(this.togglePlayback, this);

        $('.counter-overlay').unbind().on('click', function(e){
            e.preventDefault();

            if(e.target.nodeName != 'I' && e.target.nodeName != 'A' && e.target.nodeName != 'SPAN'){
                if(!self.playing && !$('input, textarea').is(':focus')){
                    self.playing = true;
                    HighwayManager.countIn(true);
                }
            }
        });

        $('#change-playmode').unbind().on('click', function(e){
            e.preventDefault();

            RL.config.mode = (RL.config.mode == 'strum') ? 'tap' : 'strum';

            $('.var-mode').text(RL.config.mode);
            $('.var-mode-alt').text(RL.config.mode == 'strum' ? 'tap' : 'strum');

            RL.init();
        });
	},

	togglePlayback: function()
    {
        if(!this.playing && !$('input, textarea').is(':focus')){
            this.playing = true;
            HighwayManager.countIn(true);
		}
	},

    restart: function()
    {
        if(!RL.typing && !RL.inputFields.is(':focus')){
            var t = (new Date()).getTime();
            if(InteractionManager.restartLastHit === 0 || t - InteractionManager.restartLastHit > 700){
                InteractionManager.restartLastHit = t;
            }else{
                InteractionManager.restartLastHit = 0;

                this.playing = true;
                RL.init(true);
            }
        }
    }
}
};