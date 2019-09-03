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
    aNoteObjects: [],
    secondsOnScreen : RL.config.height / RL.config.pxPerSecond,
    topSecondsDistance : RL.config.buttonY / RL.config.pxPerSecond,

    animateNoteDistanceInterval: false,
    progressBar: document.getElementById('progress-bar'),

    sortNotes: function()
    {
        var normalizedNotes = [];

        for(var lane = 1; lane <= RL.config.lanes; lane++)
        {
            laneNotes = this.aNotes[lane];

            for(var i = 0; i < laneNotes.length; i++)
            {
                duration = laneNotes[i].duration;

                if(typeof(laneNotes[i].time) !== 'undefined'){
                    t = laneNotes[i].time;
                }else if(typeof(laneNotes[i].start) !== 'undefined'){
                    t = laneNotes[i].start*1000;
                    duration = laneNotes[i].duration * 1000;
                }else{
                    t = laneNotes[i].ms;
                }

                if(t === null){
                    this.aNotes[lane].splice(i,1);
                    continue;
                }

                var note = {
                    time: t,
                    duration: duration,
                    lane: lane, 
                    cb: typeof(laneNotes[i].cb) != 'undefined' ? laneNotes[i].cb : false,
                    hitcb: typeof(laneNotes[i].hitcb) != 'undefined' ? laneNotes[i].hitcb : false,
                    hopo: laneNotes[i].hopo && typeof(laneNotes[i].hopo) != 'undefined' ? laneNotes[i].hopo : false
                };

                normalizedNotes.push(note);
            }
        }

        normalizedNotes.sort(RL.compare);
        this.aNotes = normalizedNotes;
    },

    drawNotes: function(removeFromContainer){
        var removeFromContainer = typeof(removeFromContainer) != 'undefined' ? removeFromContainer : true;

        if(removeFromContainer){
    	   noteContainer.removeAll(true);
        }

        RL.config.maxNotes = this.aNotes.length + 1000;

        for(var i = 0; i < this.aNotes.length; i++){
            noteObject = this.aNotes[i];

            var note = new RL.Note(game, {
                time: noteObject.time,
                lane: noteObject.lane,
                duration: noteObject.duration,
                cb: typeof(noteObject.cb) != 'undefined' ? noteObject.cb : false,
                hitcb: typeof(noteObject.hitcb) != 'undefined' ? noteObject.hitcb : false,
                hopo: noteObject.hopo && typeof(noteObject.hopo) != 'undefined' ? noteObject.hopo : false
            });

            noteContainer.add(note);
        }
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
        ga('send', 'event', 'Song', 'play', '0'); 

        HighwayManager.counterOverlay = $('.counter-overlay');
        HighwayManager.counterOverlay.css({ opacity: 0 }).show();
        HighwayManager.counterOverlay.transition({ opacity: 0.5 });
        HighwayManager.counterOverlay.find('.info').hide();
        HighwayManager.counterOverlay.find('.count').show();

        this.counter = { start: (new Date()).getTime(), count: RL.config.countSeconds };

        $('.counter-overlay .count').html(this.counter.count);

        RL.music.stop();
        
        this.counterInterval = setInterval(function(){
            HighwayManager.counter.count --;
              RL.sounds.drumstick.play();

            if(HighwayManager.counter.count == 2){
                rl.darkenPage(true);
            }

            if(HighwayManager.counter.count <= 0){
                RL.sounds.drumstick.stop();
                $('.counter-overlay').hide();
                clearInterval(HighwayManager.counterInterval);
                $('.reloadSong').fadeIn();

                AudioManager.play();
            }else{
              $('.counter-overlay .count').html(HighwayManager.counter.count);
            }

        }, 1000);
    },

    instantStart: function()
    {
        /*rl.darkenPage(true);
        $('.reloadSong').fadeIn();

        setTimeout(function(){
            RL.music.seek(0);

            AudioManager.play();
        }, 500);*/
        this.countIn();
    },

    drawGrid: function(){
        grid = game.add.image(0, 0, 'spritesheet', 35);
        grid.alpha = 0.5;

        grid.scaleY = 2;
    },

    drawProgressbar: function(height){
        this.progressBar.style.height = height+'px';
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
            button.lane = i;
            button.z = 5;

            if(typeof(mobile) != 'undefined' && mobile){
                button.inputEnabled = true;
                button.events.onInputDown.add(touchDownHandler);
                button.events.onInputUp.add(touchUpHandler);

                button.update = function()
                {
                    if(this.isPressed)
                    {
                        HighwayManager.continueHitDetection(this.lane, game.time.now - this.started);
                    }
                }
            }

            var key = game.input.keyboard.addKey(RL.config.buttonKeys[i]);
            
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);

            if(RL.config.buttonKeysAlt[i] != RL.config.buttonKeys[i]){
                var key = game.input.keyboard.addKey(RL.config.buttonKeysAlt[i]);
                
                key.onDown.add(keyDownHandler, this);
                key.onUp.add(keyUpHandler, this);
                key.onHoldCallback = keyHoldHandler;
                
                InteractionManager.aKeyboardEvents.push(key);
            }

        }

        if(RL.config.mode == 'strum'){
            var key = game.input.keyboard.addKey(RL.config.buttonKeys[6]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);

            var key = game.input.keyboard.addKey(RL.config.buttonKeys[7]);
            key.onDown.add(keyDownHandler, this);
            key.onUp.add(keyUpHandler, this);
            key.onHoldCallback = keyHoldHandler;

            InteractionManager.aKeyboardEvents.push(key);
        }

        // quick restart key
        var key = game.input.keyboard.addKey(RL.config.restartKey);
        key.onUp.add(InteractionManager.restart, this);

        InteractionManager.aKeyboardEvents.push(key);

        game.input.keyboard.clearCaptures();
    },
    
	particleBurst: function(lane, longNote)
    {
        if(RL.config.showBurst && (typeof(mobile) == 'undefined' || mobile == false))
        {
    	    //  The first parameter sets the effect to "explode" which means all particles are emitted at once
    	    //  The second gives each particle a ms lifespan
    	    //  The third is ignored when using burst/explode mode
    	    //  The final parameter (10) is how many particles will be emitted in this single burst
            if(longNote == false || typeof(longNote) == 'undefined')
            {
                this.emitter[lane].setAllChildren('renderable', false);
            }
            this.emitter[lane].explode(1000, RL.config.burstCount);
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
            if(lane == 6 || lane == 7){
                // strum held notes
                // check each string if a note is being held down
                var count_hit = 0;

                for(var i = 1; i <= 5; i++){
                    if(RL.hittableNotes[i] && 
                        RL.pressedButtons[i] && 
                        !RL.hittableNotes[i].hit)
                    {
                        this.hitNote(RL.hittableNotes[i], i);

                        count_hit++;
                    }else if(RL.hittableNotes[i] && i == lane){
                        ScoreManager.reset();
                        count_hit = -1;
                    }else if(RL.pressedButtons[i] && !RL.hittableNotes[i].hit && count_hit > 0){
                        ScoreManager.reset();
                    }
                }

                if(count_hit <= 0){
                    ScoreManager.reset();

                    for(var i = 1; i <= 5; i++){
                        if(InteractionManager.keyboardPresses[i] != 0)
                        {
                            InteractionManager.keyboardPresses[i].endTap();
                        }
                    }
                }
            }else{
                RL.pressedButtons[lane] = true;

                if(RL.hittableNotes[lane] && 
                    RL.hittableNotes[lane].hopo && 
                    ScoreManager.streak > 0 && 
                    !RL.hittableNotes[lane].hit)
                {
                    this.hitNote(RL.hittableNotes[lane], lane);
                }
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

    // ONLY FOR STRUM MODE 
    hitNote: function(note, lane){
        InteractionManager.strumDuration[lane] = { start: (new Date()).getTime(), duration: 0 };

        InteractionManager.keyboardPresses[lane] = note;
        InteractionManager.keyboardPresses[lane].renderable = false;
        InteractionManager.keyboardPresses[lane].burst();

        ScoreManager.sustainedCache[lane] = 0;
        ScoreManager.notes_hit++;
    },

    /**
    * This function continues hit detection
    *
    * (int) lane - The string to be tested for a hittable note
    * returns (boolean) true|false
    */
    continueHitDetection: function(lane, duration)
    {
        if(InteractionManager.keyboardPresses[lane] !== 0){
            if(RL.config.mode == 'strum' && lane != 6 && lane != 7){
                if(InteractionManager.keyboardPresses[lane].alive == false){
                    InteractionManager.keyboardPresses[lane] = 0;
                }else{
                    duration = (new Date()).getTime() - InteractionManager.strumDuration[lane].start;
                    InteractionManager.keyboardPresses[lane].burstLong(duration, game.time.now - AudioManager.startTime);
                }                    

                /*RL.pressedButtons[lane] = true;

                if(RL.hittableNotes[lane] && 
                    RL.hittableNotes[lane].hopo && 
                    ScoreManager.streak > 0 && 
                    !RL.hittableNotes[lane].hit)
                {
                    HighwayManager.hitNote(RL.hittableNotes[lane], lane);
                }*/
            }else if(RL.config.mode == 'tap'){
                InteractionManager.keyboardPresses[lane].burstLong(duration, game.time.now - AudioManager.startTime);
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
        if(InteractionManager.keyboardPresses[lane] !== 0 && typeof(InteractionManager.keyboardPresses[lane]) !== 'undefined'){
            InteractionManager.keyboardPresses[lane].endTap();
            InteractionManager.keyboardPresses[lane] = 0;
        }

        if(RL.config.mode == 'strum' && lane != 6 && lane != 7 )
        {
            RL.pressedButtons[lane] = false;
        }
        else if(RL.config.mode == 'tap')
        {
            ScoreManager.resetSustainedCache(lane);
        }
    }
}
};