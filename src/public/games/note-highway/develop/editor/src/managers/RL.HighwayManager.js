/**
 * The HighwayManager is responsible for drawing stuff on the canvas
 * It also contains methods for hit detection
 *
 * @module RL.HighwayManager
 */

RL.HighwayManager = function() {
return {
    aButtons: [false],
    aLanes  : [false],
    emitter : [false],
    progressBar: false,
    secondsOnScreen : RL.config.height / RL.config.pxPerSecond,
    topSecondsDistance : RL.config.buttonY / RL.config.pxPerSecond,
    containerDragStart: 0,
    containerDragEnd: 0,

    animateNoteDistanceInterval: false,

    drawNotes: function(){
    	noteContainer.removeAll(true);

        for(var lane = 1; lane <= RL.config.lanes; lane++){
            notes = this.aNotes[lane] || [];

            for(var i = 0; i < notes.length; i++){
                duration = notes[i].duration;

                if(typeof(notes[i].time) !== 'undefined'){
                    t = notes[i].time;
                }else if(typeof(notes[i].start) !== 'undefined'){
                    t = notes[i].start*1000;
                    duration = notes[i].duration * 1000;
                }else{
                    t = notes[i].ms;
                }

                if(t === null){
                    this.aNotes[lane].splice(i,1);
                    continue;
                }

                notes[i] = new RL.Note(game, {
                    time: t,
                    lane: lane,
                    duration: duration,
                    cb: typeof(notes[i].cb) != 'undefined' ? notes[i].cb : false,
                    hitcb: typeof(notes[i].hitcb) != 'undefined' ? notes[i].hitcb : false,
                    hopo: notes[i].hopo      
                })

                notes[i].exists = true;

                noteContainer.add(notes[i]);

                if(RL.editMode)
                	notes[i].initEditorFunctions();
            }
        }

        this.drawHitArea();
    },

    updateNotes: function(notes){
        notes = $.map(notes, function(value, index){
            return [value];
        });

        for(var lane = 1; lane < notes.length; lane++){
            laneNotes = notes[lane];
            for(var n = 0; n < laneNotes.length; n++){
                currNote = laneNotes[n].updateY();
            }
        }
    },

    animateNoteDistance: function(to)
    {
        if(HighwayManager.animateNoteDistanceInterval){
            clearInterval(HighwayManager.animateNoteDistanceInterval);
        }

        HighwayManager.animateNoteDistanceFrom = RL.config.pxPerSecond;

        /*HighwayManager.animateNoteDistanceInterval = setInterval(function(){
            if(HighwayManager.animateNoteDistanceFrom > to && RL.config.pxPerSecond > to){
                RL.config.pxPerSecond-=2;
            }else if(RL.config.pxPerSecond < to){
                RL.config.pxPerSecond+=2;
            }else{
                clearInterval(HighwayManager.animateNoteDistanceInterval);
            }

            HighwayManager.updateNotes(HighwayManager.aNotes);

            if(RL.editMode){
                $('#slider-pxPerSecond').slider('value',RL.config.pxPerSecond);
                $('span#pxPerSecond').html(RL.config.pxPerSecond);
            }
        }, 50);*/

        RL.config.pxPerSecond = to;

        HighwayManager.updateNotes(HighwayManager.aNotes);

        if(RL.editMode){
            $('#slider-pxPerSecond').slider('value',RL.config.pxPerSecond);
            $('span#pxPerSecond').html(RL.config.pxPerSecond);
        }
    },

    countIn: function(play)
    {
        RL.HighwayManager.counterOverlay = $('.counter-overlay');
        RL.HighwayManager.counterOverlay.transition({ opacity: 0.5 });
        RL.HighwayManager.counterOverlay.find('.info').hide();
        RL.HighwayManager.counterOverlay.find('.count').show();

        this.counter = { start: (new Date()).getTime(), count: RL.config.countSeconds };

        $('.counter-overlay .count').html(this.counter.count);

        this.counterInterval = setInterval(function(){
            HighwayManager.counter.count --;
              RL.sounds.drumstick.play();

            if(HighwayManager.counter.count <= 0){
                RL.sounds.drumstick.stop();
                $('.counter-overlay').hide();
                clearInterval(HighwayManager.counterInterval);
                AudioManager.play();
            }else{
              $('.counter-overlay .count').html(HighwayManager.counter.count);
            }

        }, 1000);
    },

    drawGrid: function(){
        grid = game.add.image(0, 0, 'spritesheet', 35);
        grid.alpha = 0.5;
    },

    createButtons: function(){
        for(var i = 1; i <= 5; i++){
            var button = game.add.sprite(RL.getPosXForLane(i)-RL.config.buttonWidth/2, 
                                            RL.config.buttonY, 
                                            "spritesheet", 
                                            5*i-5
                                        );

            if(i > RL.config.lanes){
                button.alpha = 0.25;
            }
            
            this.aButtons.push(button);
            button.inputEnabled = true;
            button.lane = i;
            button.z = 5;

            var key = game.input.keyboard.addKey(RL.config.buttonKeys[i]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);
        }

        if(RL.config.mode == 'strum'){
            var key = game.input.keyboard.addKey(RL.config.buttonKeys[6]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);
        }

        game.input.keyboard.clearCaptures();
    },

    showLoadingScreen: function()
    {
        $('.large-player-loading-overlay').fadeOut();
        $('.loading-overlay').show();
        RL.loadingStep = '-=360deg';
        RL.loadingAnimation = setInterval(function(){
            $('.loading-overlay img').css({ 
                transformOrigin: '11px 10px'
            }).transition({
                rotate:RL.loadingStep,
                duration: 850
            });

            RL.loadingStep = (RL.loadingStep == '-=360deg') ? '+=360deg' : '-=360deg'; 
        }, 1010);
    },

    hideLoadingScreen: function()
    {
        $('.loading-overlay').fadeOut();

        clearInterval(RL.loadingAnimation);
    },

    showInfoScreen: function()
    {
        $('.counter-overlay').fadeIn();
    },

    hideInfoScreen: function()
    {
        $('.counter-overlay').fadeOut();
    },
    
    drawHitArea: function()
    {
        max = RL.config.buttonY+RL.config.noteHeight+10;
        min = RL.config.buttonY-2;

        grid = game.add.graphics(0, 0);
        grid.lineStyle(RL.config.gridLineWidth, RL.config.laneColors[1]);
        grid.moveTo(0, max);
        grid.alpha = 0.5;
        grid.lineTo(RL.config.width, max);

        grid = game.add.graphics(0, 0);
        grid.lineStyle(RL.config.gridLineWidth, RL.config.laneColors[1]);
        grid.moveTo(0, min);
        grid.alpha = 0.5;
        grid.lineTo(RL.config.width, min);
    },

	particleBurst: function(lane)
    {
        if(RL.config.showBurst)
        {
    	    //  The first parameter sets the effect to "explode" which means all particles are emitted at once
    	    //  The second gives each particle a ms lifespan
    	    //  The third is ignored when using burst/explode mode
    	    //  The final parameter (10) is how many particles will be emitted in this single burst
    	    this.emitter[lane].start(true, 700, null, 5);
        }
	},

    /**
    * This function starts hit detection
    *
    * (int) lane - The string to be tested for a hittable note
    * returns (boolean) true|false
    */
    startHitDetection: function(lane)
    {        
        if(RL.config.mode == 'strum'){
            if(lane === 6){
                // strum held notes
                // check each string if a note is being held down
                var count_hit = 0;

                for(var i = 1; i <= 5; i++){
                    if(RL.hittableNotes[i] && RL.pressedButtons[i]){
                        InteractionManager.strumDuration[i] = { start: (new Date()).getTime(), duration: 0 };

                        InteractionManager.keyboardPresses[i] = RL.hittableNotes[i];
                        InteractionManager.keyboardPresses[i].burst();

                        ScoreManager.sustainedCache[i] = 0;
                        ScoreManager.notes_hit++;

                        count_hit++;
                    }else if(RL.hittableNotes[i]){
                        ScoreManager.reset();
                        count_hit = -1;
                    }
                }

                if(count_hit <= 0){
                    ScoreManager.reset();
                }
            }else{
                RL.pressedButtons[lane] = true;
            }
        }else if(RL.config.mode == 'tap'){
            if(RL.hittableNotes[lane]){
                InteractionManager.keyboardPresses[lane] = RL.hittableNotes[lane];
                InteractionManager.keyboardPresses[lane].burst();
                ScoreManager.notes_hit++;
            }else{
                ScoreManager.reset();
            }
        }
    },

    /**
    * This function continues hit detection
    *
    * (int) lane - The string to be tested for a hittable note
    * returns (boolean) true|false
    */
    continueHitDetection: function(lane, duration)
    {
        if(RL.config.mode == 'strum'){
            if(lane != 6){              
                if(InteractionManager.keyboardPresses[lane] != 0){
                    if(!InteractionManager.keyboardPresses[lane].alive){
                        /*if(RL.hittableNotes[lane]){
                            InteractionManager.keyboardPresses[lane] = RL.hittableNotes[lane];
                            InteractionManager.keyboardPresses[lane].burst();
                        }*/
                        InteractionManager.keyboardPresses[lane] = 0;
                    }else{

                        duration = (new Date()).getTime() - InteractionManager.strumDuration[lane].start;
                        InteractionManager.keyboardPresses[lane].burstLong(duration, AudioManager.getPosition());
                    }
                }
            }
        }else if(RL.config.mode == 'tap'){
            if(InteractionManager.keyboardPresses[lane] !== 0){
                InteractionManager.keyboardPresses[lane].burstLong(duration, AudioManager.getPosition());
            }
        }
    },

    /**
    * This function ends hit detection
    *
    * (int) lane - The string where hitdetection ends
    * returns (boolean) true|false
    */
    endHitDetection: function(lane)
    {
        if(RL.config.mode == 'strum'){
            if(lane === 6){
                // strum holded notes
            }else{
                RL.pressedButtons[lane] = false;

                if(InteractionManager.keyboardPresses[lane] !== 0){
                    InteractionManager.keyboardPresses[lane].endTap();
                }

                InteractionManager.keyboardPresses[lane] = 0;
            }
        }else if(RL.config.mode == 'tap'){
            if(InteractionManager.keyboardPresses[lane] !== 0){
                InteractionManager.keyboardPresses[lane].endTap();
                InteractionManager.keyboardPresses[lane] = 0;
            }
            ScoreManager.resetSustainedCache(lane);
        }
    }
}
};