/*! rocklegend note-highway 06-02-2016 */

var RL = {
	States: {}, // holds the games states
    sounds: {},

	hittableNotes: [false,false,false,false,false,false],
    pressedButtons: [false, false, false, false, false, false],
    rectangleContainer: false,
    playAdded: false,  

    instantRestart: false,
    typing: false,
    inputFields: $('input, textarea'),

    posXLanes: {},
    laneButtonX: {},

    init: function(instantRestart)
    {              
        this.instantRestart = typeof(instantRestart) == 'undefined' ? false : instantRestart;

        this.hitPosition = this.config.height - this.config.buttonY;

        this.editMode = this.isEditMode();
        this.playerHeightOnePercent = this.config.height/100;
        this.config.pxPerMs = this.config.pxPerSecond / 1000;
        this.negPxPerMs = -this.config.pxPerMs;

        this.maxHitY = RL.config.buttonY+RL.config.buttonHeight;
        this.minHitY = RL.config.buttonY-RL.config.noteHeight/1.25;

        this.halfNoteHeight = this.config.noteHeight/2,

        restart = false;

        if(game != null){
            if(!RL.instantRestart){
                rl.darkenPage(false);
            }

            RL.music.pos(0);
            RL.music.stop();

            RL.music = new Howl({
                src: [ soundFiles[0], soundFiles[1] ],
                preload: true,
                onend: function()
                {
                    ScoreManager.ended();
                }
            });
            
            AudioManager.startTime = 0;

            this.hittableNotes = [false,false,false,false,false,false];
            this.pressedButtons = [false,false,false,false,false,false];

            $('.counter-overlay').transition({ opacity: 1 });

            clearInterval(HighwayManager.counterInterval);

            noteContainer.destroy(true);

            $('.counter-overlay .count').hide().html(this.config.countSeconds);
            $('.counter-overlay .info').fadeIn();

            restart = true;
        }
        else
        {
            AudioManager = new RL.AudioManager();

            InteractionManager = new this.InteractionManager();
        }

        HighwayManager = new this.HighwayManager();
        HighwayManager.aNotes = aNotes;
        HighwayManager.sortNotes();

        ScoreManager = new this.ScoreManager();

        if(restart){
            game.state.start('Play');

            return;
        }

        //
        
        var displayMode = Phaser.AUTO;

        switch(this.config.displayMode){
            case 'AUTO':
                displayMode = Phaser.AUTO;
                break;
            case 'WEBGL':
                displayMode = Phaser.WEBGL;
                break;
            case 'CANVAS':
                displayMode = Phaser.CANVAS;
                break;
        }

        game = new Phaser.Game( 
            this.config.width, 
            this.config.height, 
            displayMode, 
            'main-canvas',
            null,
            false, //transparent
            true, //antialias
            null
        );

        game.state.add('Boot', this.States.Boot);
        game.state.add('Play', this.States.Play);
    
        game.state.start('Boot');
    },
    showLoadingScreen: function()
    {
        $('.large-player-loading-overlay').fadeOut();
        $('.loading-overlay').show();
        this.loadingStep = '-=360deg';
        this.loadingAnimation = setInterval(function(){
            $('.loading-overlay img').css({ 
                transformOrigin: '11px 10px'
            }).transition({
                rotate:RL.loadingStep,
                duration: 850
            });

            this.loadingStep = (RL.loadingStep == '-=360deg') ? '+=360deg' : '-=360deg'; 
        }, 1010);
    },

    hideLoadingScreen: function()
    {
        $('.loading-overlay').fadeOut();

        clearInterval(this.loadingAnimation);
    },

    showInfoScreen: function()
    {
        $('.counter-overlay').fadeIn();
    },

    hideInfoScreen: function()
    {
        $('.counter-overlay').fadeOut();
    },

	getPosXForLane: function(lane){
        if(this.posXLanes[lane]) return this.posXLanes[lane];

        this.posXLanes[lane] = RL.config.width / 6 * lane;
		return this.posXLanes[lane];
	},

    getXForLaneButton: function(lane){
        if(this.laneButtonX[lane]) return this.laneButtonX[lane];

        this.laneButtonX[lane] = RL.config.width / 6 * lane - RL.config.noteWidth/2;
        return this.laneButtonX[lane];
    },

    getYForTime: function(time){
        return time * RL.negPxPerMs + RL.config.noteHeightDifferenceToButton;
    },

    getTimeForY: function(y){
        return (y - RL.config.noteHeightDifferenceToButton) / RL.negPxPerMs;
    },

    addPlay: function()
    {
        $.post('/play/add/'+track_id);
    },

/************
    SETTINGS
*************/
    toggleSettings: function()
    {
        if($('.settings-overlay').css('display') == 'block'){
            $('.settings-overlay').fadeOut();
        }else{
            $('.settings-overlay').fadeIn();
        }
    },

/************

*************/

	sortNotesArray: function(){
		for(var i = 1; i < aNotes.length; i++){
	        lane = aNotes[i];
	        
	        for(var n = 0; n < lane.length; n++){
	            lane[n].ms = lane[n].ms;
	        }

	        lane.sort(RL.dynamicSort("ms"));
	    }
	},

	keyCodeToIndex: function(keyCode){
        switch(keyCode){
            case RL.config.buttonKeys[0]:
                return 0;
            case RL.config.buttonKeys[1]:
                return 1;
            case RL.config.buttonKeys[2]:
                return 2;
            case RL.config.buttonKeys[3]:
                return 3;
            case RL.config.buttonKeys[4]:
                return 4;
            case RL.config.buttonKeys[5]:
                return 5;
            case RL.config.buttonKeys[6]:
                return 6;
            case RL.config.buttonKeys[7]:
                return 7;
            case RL.config.buttonKeysAlt[0]:
                return 0;
            case RL.config.buttonKeysAlt[1]:
                return 1;
            case RL.config.buttonKeysAlt[2]:
                return 2;
            case RL.config.buttonKeysAlt[3]:
                return 3;
            case RL.config.buttonKeysAlt[4]:
                return 4;
            case RL.config.buttonKeysAlt[5]:
                return 5;
            case RL.config.buttonKeysAlt[6]:
                return 6;
            case RL.config.buttonKeysAlt[7]:
                return 7;
            default:
                return -1;
        }
	},

    isEditMode: function()
    {
        return (typeof(edit_mode) !== 'undefined' && edit_mode !== false) ? true : false;
    },

    dynamicSort: function(property) {
        var sortOrder = 1;
        if(property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a,b) {
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    },

    compare: function(a,b) {
      if (parseFloat(a.time) < parseFloat(b.time))
         return -1;
      if (parseFloat(a.time) > parseFloat(b.time))
        return 1;
      return 0;
    },

    str_pad: function(input, pad_length, pad_string, pad_type){
        var half = '',
            pad_to_go;

        var str_pad_repeater = function (s, len) {
            var collect = '',
                i;

            while (collect.length < len) {
                collect += s;
            }
            collect = collect.substr(0, len);

            return collect;
        };

        input += '';
        pad_string = pad_string !== undefined ? pad_string : ' ';

        if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
            pad_type = 'STR_PAD_RIGHT';
        }
        if ((pad_to_go = pad_length - input.length) > 0) {
            if (pad_type === 'STR_PAD_LEFT') {
                input = str_pad_repeater(pad_string, pad_to_go) + input;
            } else if (pad_type === 'STR_PAD_RIGHT') {
                input = input + str_pad_repeater(pad_string, pad_to_go);
            } else if (pad_type === 'STR_PAD_BOTH') {
                half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                input = half + input + half;
                input = input.substr(0, pad_length);
            }
        }

        return input;
    }
/************

************/
};;RL.config = {
	log: true, // enable/disable log

	mobile: false,
	editor: false,

	countSeconds: 3,

	// Canvas
	width: $('#main-canvas').width(),
	height: $('#main-canvas').height(),

	disableVisibilityChange: true,
	smoothSprites: false,
	stageBackgroundColor: 0X2C2C2C, //canvas background color

	// Loader
	loaderWidth: 40,
	loaderHeight: 40,

	// Sounds
	squeaks: 1, // amount of squeak sounds available
	musicPlaybackRate: 1.0,

	// Grid
	gridLineWidth: 2, // thickness of main grid lines
	lanes: 5, //number of note lines (move this to a difficulty config later)
	laneColors: [	// colors of the lanes
				   null, // just a filler, so the lanes numbering is correct
	               0XD12B4F,
	               0XD4C400,
	               0X88D700,
	               0X00BBE3,
	               0X8137F9
	],

	// Buttons	
	buttonWidth: 39.5,
	buttonHeight: 45,

	buttonY: $('#main-canvas').height()-80, //the vertical position of the buttons
	
	buttonKeys: [
				null,
	            49, //1
	            50, //2
	            51, //3
	            52, //4
	            53,  //5
	            13, // STRUM = ENTER
	            16, // STRUM = SHIFT
    ],

    // Notes
	noteWidth: 35,
	noteHeight: 35,
	sustainedWidth: 11.5,
	noteHeightDifferenceToButton: 8,

    // NoteHighway
    pxPerSecond: 250, // px : the amount of pixels the note highway scrolls down per second
    longNoteThreshold: 75, // ms : minimum difference between startTap and endTap for long notes    
    hitDetectThreshold: 50, // ms : the maximum difference between note ms and hit time to be detected as a hit


    // Performance Keys
    startKey: 32,
    restartKey: 82,

    // Editor Keys
    seekBackwardKey: 37,
    seekForwardKey:  39,

    speedUpKey: 38,
    speedDownKey: 40,

    deleteKey: 46,

    newLineKey: 187,

    mode: 'tap', // tap or strum
                 // 
    // performance
    maxNotes: 35,
    showBurst: true,
    burstCount: 8,
    animateHitLanes: false,
    displayMode: 'AUTO',
    enableCheering: true,
    cheeringVolume: 0.5
}

jQuery.extend(RL.config, user_config);;function keyDownHandler(e){
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
};;/**
 * This manages audio stuff.
 * It's to be used as a wrapper for any sound framework that might be used
 *
 * @module RL.AudioManager
 */

RL.AudioManager = function(){
	return {
		startTime: 0,
		initialized: false,
		duration: 0,
		ended: false,

		init: function()
		{
			this.initialized = true;
			this.duration = RL.music._duration;
			this.onePercent = this.duration*10;
		},

		getPosition: function()
		{
			return RL.music.seek()*1000;
		},

		play: function()
		{
			RL.music.play();
			this.startTime = game.time.now;
		},

		pause: function()
		{
			RL.music.pause();
		},

		stop: function()
		{
			RL.music.stop();
			this.startTime = 0;
		}
	}
};;/**
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
};;RL.ScoreManager = function(){
	var scoreManagerObject = {
		_score: 0,
		score: 0,
		multiplier: 1,
		streak: 0,
		max_streak: 0,
		max_multiplier: 0,
		notes_hit: 0,
		notes_missed: 0,
		percent: 0,

		prev_streak: 0,
		prev_multiplier: 0,
		prev_score: 0,

		score_highest: 0,
		score_user_highest: 0,
		score_friend_highest: 0,
		score_bar_percent: 0,

		score_bar_current_element: 0,

		sustainedCache: [0,0,0,0,0,0],

		cheeringStreak: [25, 50, 100, 150, 200, 300, 400, 500],

		singleNotePoints: 50,
		friendScoreInterval: false,

		scoreTracking: [{t:0,str:0,score:0,multiplier:1}],

		$score: document.getElementById('score-num'),//$('.score-display .score'),
		$streak: document.getElementById('streak-num'),// $('.score-display .streak'),
		$multiplier: document.getElementById('multiplier-num'),//$('.score-display .multiplier'),

		friendScoreBar: document.getElementById('bar-score-friend'),

		init: function(){
			this.$score.innerHTML = '0';
			this.$streak.innerHTML = '0';
			this.$multiplier.innerHTML = 'x1';

			// init score bars
			if(max_user_score > 0){
				this.score_highest = max_score;

				var user_scorebar_height = max_user_score / max_score * 100;
				$('.bar-user-highscore').css('height',user_scorebar_height+'%').show();

			}

			if(max_friend_score > 0){
				var friend_scorebar_height = max_friend_score / max_score * 100;
				$('.bar-friend-score').css('height',friend_scorebar_height+'%').show();
			}

			if(friend_score_tracked)
			{
				var friend_scorebar_height = 0;
				$('.bar-friend-score').css('height',friend_scorebar_height+'%').show();
			}

			this.score_bar_current_element = document.getElementById('bar-score-current');
			this.score_bar_current_element.style.height = '0%';
			this.score_bar_current_element.style.display = 'block';

			$('.repeat-song').unbind().on('click', function(e){
				e.preventDefault();

	        	ga('send', 'event', 'Song', 'repeat', '1');

				$('.score-overlay').fadeOut();

				ScoreManager.animateFinishBack('.score-points-wrap', 0);
				ScoreManager.animateFinishBack('.score-streak-wrap', 1);
				ScoreManager.animateFinishBack('.score-multiplier-wrap', 0);

				RL.init();
			});

			$('.share-score').unbind().on('click', function(e){
	        	ga('send', 'event', 'Share', 'facebook - share score', 'score', ScoreManager.score);

				FB.ui({
					method: 'feed',
					caption: 'Can you beat my score?',
					name: share_title,
					description: 'I just scored '+numberWithDots(ScoreManager.score)+' points on "'+song_name+'" by '+artist_name+'! A max streak of '+numberWithDots(ScoreManager.max_streak)+', '+
									numberWithDots(ScoreManager.notes_hit)+' notes hit and a completion of '+ScoreManager.percent+'%. #thisisrocklegend',
					link: share_url,
					picture: thumbnail_url
				});
			});
		},

		ended: function(){
			if(!RL.editMode){
				AudioManager.ended = true;
				AudioManager.stop();

	        	ga('send', 'event', 'Song', 'play', '1');

	        	$('.reloadSong').fadeOut();

				// here we should switch to the next state -> "ENDED"
				if(!testMode && Object.isFrozen(ScoreManager) === false){
					var tracked_score = [{t:0,str:0,score:0,multiplier:1}];
					var previousTime = 0;

					$.each(ScoreManager.scoreTracking, function(i, o)
					{
						if(o.t < previousTime)
						{
							tracked_score = [{t:0,str:0,score:0,multiplier:1}];
						}

						if(o.t >= tracked_score[tracked_score.length-1].t+500 || i >= tracked_score.length-1)
						{
							tracked_score.push(o);
						}

						previousTime = o.t;
					});

					var tracked_string = lzw_encode(JSON.stringify({ data: tracked_score}));

					$.post('/play/score/'+track_id+'/save',
					{
						score: ScoreManager.score,
						max_streak: ScoreManager.max_streak,
						max_multiplier: ScoreManager.max_multiplier,
						notes_missed: ScoreManager.notes_missed,
						notes_hit: ScoreManager.notes_hit,
						ts: tracked_string,
						mode: RL.config.mode,
						devMode: false, //window.devtools.open,
						_token: csrf
					}, function(data){
						if(data.badge){
							rl.badge.showBadgeInfo(parseInt(data.badge));
						}
						ScoreManager.showScoreScreen(data);
					});
				}else{
					ScoreManager.showScoreScreen();
				}
			}
		},

		showScoreScreen: function(data)
		{
			$('.score-overlay').fadeIn();

			var total_notes = notes_count;
			var percent_hit = (ScoreManager.notes_hit / total_notes * 100).toFixed(2);

			ScoreManager.percent = percent_hit;

	    	ga('send', 'event', 'Score', 'new', 'points', ScoreManager.score);
	    	ga('send', 'event', 'Score', 'new', 'percentage', ScoreManager.percent);
	    	ga('send', 'event', 'Score', 'new', 'max streak', ScoreManager.max_streak);

			ScoreManager.animateFinish('.score-points-wrap', 2, function(){});

			setTimeout(function(){
				ScoreManager.animateFinish('.score-streak-wrap',1.5, function(){
					$('.score-streak-wrap h1').eq(2).not('.streak').html('Max Streak');
					$('.score-streak-wrap h1.streak').eq(1).html(ScoreManager.max_streak);
				});
			}, 270);

			setTimeout(function(){
				ScoreManager.animateFinish('.score-multiplier-wrap',3.5, function(){
					$('.score-multiplier-wrap h1').eq(2).not('.multiplier').html('Percent');
					$('.score-multiplier-wrap h1.multiplier').eq(1).html(percent_hit+'%');
				});
			}, 540);

			setTimeout(function(){
				$('.score-button-wrap').fadeIn();
			}, 1010);

			setTimeout(function(){
				rl.darkenPage(false);
			}, 1500);

			RL.sounds.crowds[0].play();

			scores.fetch();
		},

		animateFinish: function(selector, indent, cb)
		{
			var indent = typeof(indent) != 'undefined' ? indent : 0;

			var $scoreWrap = $(selector);
			var $scoreClone = $scoreWrap.clone();

			$scoreClone
				.css({
					position: 'absolute',
					top: $scoreWrap.offset().top-1,
					left: $scoreWrap.offset().left
				})
				.appendTo('body')
				.transition({
					left: $('.score-overlay').offset().left + $('.score-overlay').width()/2 - $scoreClone.width() + indent * 20,
					duration: 500
				}, 500, 'ease-in-out');

			$scoreWrap.fadeOut(0).css({ display: 'inline-block', visibility : 'hidden'});

			cb();
		},

		animateFinishBack: function(selector, indent)
		{
			var $scoreWrap = $(selector).eq(0);
			var $scoreClone = $(selector).eq(1);

			$scoreClone
				.transition({
					left: $scoreWrap.offset().left - indent*20,
					duration: 500
				}, 500, 'ease-in-out');

			setTimeout(function(){
				$scoreClone.fadeOut(200,function(){ $scoreClone.remove(); });
				$scoreWrap.css('visibility', 'visible').fadeOut(0).fadeIn(200);
			}, 500);
		},

		adjustScoreBox: function(){
			$('.scoreBox').css({
				position: 'absolute',
				left: $('#main-canvas canvas').offset().left + RL.config.width,
				top: $('#main-canvas canvas').offset().top + 60,
			});
		},

		scoreSingleNote: function(){
			this.score += this.singleNotePoints * this.multiplier;
			this.increaseStreak();

			if(this.streak % 10 == 0){
				this.increaseMultiplier();
			}

			this.trackScore();
		},

		scoreSustainedNote: function(duration, currentDuration, lane)
		{
			perc = Math.ceil((currentDuration / (duration/100))/1000 * duration * this.multiplier);
			this.score -= this.sustainedCache[lane];

			if(this.sustainedCache[lane] <= 0){
				this.increaseStreak();

				if(this.streak % 10 == 0){
					this.increaseMultiplier();
				}
			}

			this.sustainedCache[lane] = perc;
			this.score += perc;

			this.trackScore();
		},

		resetSustainedCache: function(lane)
		{
			this.sustainedCache[lane] = 0;
		},

		increaseMultiplier: function(){
			// maximum multiplier: 4
			if(this.multiplier <= 3){
				this.multiplier++;

				if(this.max_multiplier < this.multiplier){
					this.max_multiplier = this.multiplier;
				}
			}
		},

		increaseStreak: function(){
			this.streak++;

			if(this.max_streak < this.streak){
				this.max_streak = this.streak;
			}

			if(RL.config.enableCheering && this.cheeringStreak.indexOf(this.streak) > -1){
				rand = Math.floor(Math.random() * RL.sounds.crowds.length);
				RL.sounds.crowds[rand].play();
			}
		},

		renderScore: function()
		{
			if(this.prev_streak != this.streak)
			{
				this.$streak.innerHTML = this.streak;
				this.prev_streak = this.streak;
			}

			if(this.prev_multiplier != this.multiplier)
			{
				this.$multiplier.innerHTML = 'x'+this.multiplier;
				this.prev_multiplier = this.multiplier;
			}

			if(this.prev_score != this.score)
			{
				this.$score.innerHTML = numberWithDots(this.score);
				this.prev_score = this.score;
				this.score_bar_current_element.style.height = (this.score / max_score * 100)+'%';
			}

			if(friend_score_tracked)
			{
				this.renderFriendScore();
			}
		},

		reset: function(){
			this.multiplier = 1;
			this.streak = 0;

			this.renderScore();
			this.trackScore();
		},

		trackScore: function()
		{
			var previousScore = this.scoreTracking[this.scoreTracking.length-1];

			var newScore = { };

			var filled = false;

			if(previousScore.score != this.score){
				newScore.score = this.score;
				filled = true;
			}

			if(previousScore.mp != this.multiplier){
				newScore.mp = this.multiplier;
				filled = true;
			}

			if(previousScore.str != this.streak){
				newScore.str = this.streak;
				filled = true;
			}

			if(filled)
			{
				newScore.t = game.time.now - AudioManager.startTime;
				this.scoreTracking.push(newScore);
			}
		},

		renderFriendScore: function()
		{
			if(friend_score_tracked.length && AudioManager.startTime > 0)
			{
				do{
					var updateData = friend_score_tracked[0];

					if(updateData.t <= game.time.now - AudioManager.startTime)
					{
						if(typeof(updateData.score) !== 'undefined')
						{
							ScoreManager.friendScoreBar.style.height = (updateData.score / max_score * 100)+'%';
						}

						friend_score_tracked.shift();
					}
					else
					{
						break;
					}
				}while(friend_score_tracked.length)
			}
		}
	};

	scoreManagerObject.__defineSetter__('score', function(val)
	{
		if(arguments.callee.caller != null &&
			arguments.callee.caller.toString().indexOf('trackScore') > -1 &&
			Object.isFrozen(this) === false)
		{
			this._score = val;
		}
		else
		{
			this._score = 0;
		}
	});

	scoreManagerObject.__defineGetter__('score', function()
	{
		return scoreManagerObject._score;
	});

	return scoreManagerObject;
};

function numberWithDots(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
;/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Boot = {
    musicLoaded: false,

    preload: function()
    {
        var self = this;

        RL.showLoadingScreen();

        game.load.crossOrigin = 'anonymous';
        game.load.baseURL = ASSETS_BASE_URL;

        game.load.atlasJSONHash('spritesheet', '/assets/images/game/spritesheet-player.png?t='+(new Date()).getTime(), '/assets/images/game/spritesheet.json?t='+(new Date()).getTime());

        game.load.audio('squeak', ['/assets/sounds/game/squeak1.mp3', '/assets/sounds/game/squeak1.ogg']);
        game.load.audio('tick', ['/assets/sounds/game/tick.mp3', '/assets/sounds/game/tick.ogg']);
        game.load.audio('drumstick', ['/assets/sounds/game/drumstick_twice_one_second.mp3', '/assets/sounds/game/drumstick_twice_one_second.ogg']);

        // crowds
        game.load.audio('crowd1', ['/assets/sounds/game/fans/small_crowd_40.mp3', '/assets/sounds/game/fans/small_crowd_40.ogg']);
        game.load.audio('crowd2', ['/assets/sounds/game/fans/small_crowd_40_2.mp3', '/assets/sounds/game/fans/small_crowd_40_2.ogg']);
        game.load.audio('crowd3', ['/assets/sounds/game/fans/medium_crowd.mp3', '/assets/sounds/game/fans/medium_crowd.ogg']);

        RL.music = new Howl({
            src: [ soundFiles[0], soundFiles[1] ],
            preload: true,
            //html5: true,
            onload: function(){
                self.musicLoaded = true;
            },
            onend: function()
            {
                ScoreManager.ended();
            }
        });

        if(mobile)
        {
            $('.button-overlay').remove();
        }
    },

    update: function()
    {
        if(this.musicLoaded)
        {
            $('#main-canvas canvas').css('visibility', 'visible');
            
            RL.sounds.drumstick = game.add.sound('drumstick');
            RL.sounds.drumstick.volume = 0.24;

            RL.sounds.squeaks = [game.add.sound('squeak1')];
            RL.sounds.crowds = [game.add.sound('crowd1'),game.add.sound('crowd2')];

            for(var i = 0; i < RL.sounds.crowds.length; i++)
            {
                RL.sounds.crowds[i].volume = RL.config.cheeringVolume;
            }

            $(document).on("keydown", function (e) {
              {
                if(e.which == 32 && !$('input,textarea').is(':focus')){ e.preventDefault(); }
              }
            });
            
            game.state.start("Play");
        }
    },
};/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Play = {
    preload: function(){
        //game.time.advancedTiming = true;
        RL.config.calculations = 'clean';
        this.HighwayManager = HighwayManager;
    },

    /**
     * Creates the basic canvas for the note highway
     * triggers function calls for drawing the grid
     * drawing the hit buttons
     * drawing the note container
     * and initializing the interaction handler
     *
     * it also starts the song and adds emitters and squeak sounds
     *
     * @author lst
     * @author pne
     */
    create: function()
    {
        // if this is a mobile phone we want to allow up to 5 fingers!
        if(mobile)
        {
            game.input.addPointer();
            game.input.addPointer();
            game.input.addPointer();
        }

        game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT;

        // keep playing on window focusout
        game.stage.disableVisibilityChange = true;
        game.stage.backgroundColor = 0X2C2C2C;

        if(InteractionManager.initialized === false)
        {
            InteractionManager.init();
        }

        HighwayManager.drawGrid();
        HighwayManager.createButtons();

        noteContainer = game.add.group(game, game.world, "noteContainer", false);
        noteContainer.inputEnabled = true;
        noteContainer.z = 50;

        HighwayManager.drawNotes(true);

        ScoreManager.init();

        _emitters = HighwayManager.emitter;
        _emitterY = RL.config.buttonY + RL.config.buttonHeight/2;

        for(var i = 1; i <= 5; ++i){
            _emitters.push(game.add.emitter(0, 0, 350));
            _emitters[i].makeParticles(['spritesheet'], 24+i);
            _emitters[i].gravity = 400;
            _emitters[i].x = RL.getPosXForLane(i);
            _emitters[i].y = _emitterY;
        }

        if(!AudioManager.initialized)
        {
          AudioManager.init();
        }

        $('canvas').on("contextmenu", function(evt) {evt.preventDefault();});
            
        RL.hideLoadingScreen();

        if(RL.instantRestart){
            RL.hideInfoScreen();
            HighwayManager.instantStart();
            RL.instantRestart = false;
        }else{
            RL.showInfoScreen();
        }
    },

    update: function()
    {
        if(AudioManager.startTime)
        {
            currentPlaybackTime = game.time.now - AudioManager.startTime; //AudioManager.getPosition();
            noteContainer.y = RL.config.buttonY + (currentPlaybackTime * RL.config.pxPerMs);
        
            if(game.time.now % 2 == 0)
            {
                ScoreManager.renderScore();         
                HighwayManager.drawProgressbar((RL.playerHeightOnePercent * currentPlaybackTime)/AudioManager.onePercent);
            }
        }
    }
};/**
* Represents a note object
* Contains all data for the note, e.g. time, duration, lane etc.
*
* @class RL.Note
* @constructor
*/

RL.Note = function(game, opts){
	this.className = 'RL.Note';
 	this.game = game;

	Phaser.Image.call(this, this.game, 0, 0, 'spritesheet', 0);

	this.initialize(opts);

	//this.game.add.existing(this);
}

RL.Note.prototype = Object.create(Phaser.Image.prototype);
RL.Note.prototype.constructor = RL.Note;

RL.Note.prototype.create = function(){}

RL.Note.prototype.initialize = function(opts)
{
	this.y = RL.getYForTime(opts.time);
	this.x = RL.getXForLaneButton(opts.lane);
	this.enableBody = false;

	this.lane = opts.lane;

	this.time = parseFloat(opts.time);
	this.originalTime = this.time;

	this.duration = parseFloat(opts.duration);
	this.originalDuration = this.duration;
	this.endTime = this.time + this.duration;

	this.hopo = opts.hopo;

	if(this.hopo && RL.config.mode == 'strum'){
		this.loadTexture('spritesheet',5*this.lane-1);
	}else{
		this.loadTexture('spritesheet',5*this.lane-3);
	}

	this.hit = false;
	this.missed = false;
	this.removed = false;

	this.burstCounter = 0;

	this.maxHitY = RL.maxHitY;
	this.minHitY = RL.minHitY;
	this.shortMaxHitY = this.maxHitY;

	this.negativeNoteHeight = -RL.config.noteHeight;

	if(this.duration >= RL.config.longNoteThreshold){
		this.drawRect();
	}else if(typeof(this.rect) !== 'undefined'){
		this.rect.destroy();
		this.rect =  undefined;
	}

	this.killMaxY = this.maxHitY + 50;
	this.exists = false;

	this.rectMinHeightToShow = this.negativeNoteHeight+RL.config.noteHeight;
}

RL.Note.prototype.drawRect = function(shorter){
	if(typeof shorter === 'undefined') shorter = false;

	var rectangleHeight = this.duration * RL.config.pxPerMs + RL.halfNoteHeight;

	rectangleY =  this.y - rectangleHeight + RL.halfNoteHeight;

	if(typeof(this.rect) === 'undefined')
	{
		var rectangle = game.add.image(RL.getPosXForLane(this.lane) - 11,rectangleY,'spritesheet',29+this.lane);

		rectangle.scale.setTo(1, rectangleHeight/30); // divide through rect height

		if(shorter === false)
		{
			rectangle.exists = false;
			rectangle.alpha = 0.5;
		}

		noteContainer.add(rectangle);
		noteContainer.sendToBack(rectangle);

		this.rect = rectangle;
	}
	else
	{
		if(shorter)
		{
			this.rect.alpha = 1;
			this.rect.scale.setTo(1, rectangleHeight/30);
		}
	}

	this.rectHeight = rectangleHeight;
	this.maxHitY = RL.config.buttonY+RL.config.noteHeight+10+rectangleHeight;
	this.killMaxY = this.maxHitY + 50;
}

RL.Note.prototype.update = function(){
	realY = this.y + noteContainer.y;

	if(realY > this.shortMaxHitY)
	{
		if(realY > this.killMaxY)
		{
    	this.kill(true);
    }

    if(this.missed == false)
    {
    	this.missed = true;
    	ScoreManager.notes_missed++;
    	ScoreManager.reset();
    }
	}
	else
	{
		if(realY > this.negativeNoteHeight){
			this.exists = true;

			if(typeof(this.rect) !== 'undefined' && realY > this.rectMinHeightToShow){
				this.rect.exists = true;
			}
		}

		if(this.time <= game.time.now - AudioManager.startTime + 350){
			if(!this.removed &&
			   realY >= this.minHitY &&
			   realY <= this.shortMaxHitY)
			{
				RL.hittableNotes[this.lane] = this;
			}
			else
			{
				if(typeof(this.rect) !== 'undefined' && this.hit && realY <= this.maxHitY){
					if(!this.removed){
						RL.hittableNotes[this.lane] = this;
					}else{
						RL.hittableNotes[this.lane] = false;
					}
				}else{
					if(RL.hittableNotes[this.lane] == this){
						RL.hittableNotes[this.lane] = false;
					}
				}
			}
		}
	}
}

RL.Note.prototype.burst = function()
{
	RL.hittableNotes[this.lane] = false;

	this.hit = true;

	// this ensures that a note can't be hit twice (fast tapping)
	this.removed = true;

	if(typeof this.rect === 'undefined'){
		HighwayManager.particleBurst(this.lane, this.world.y);
		ScoreManager.scoreSingleNote();
		this.kill();
	}
}

RL.Note.prototype.burstLong = function(duration, time){
	if(this.hit && typeof(this.rect) !== 'undefined')
	{
		// update duration for note to adjust note rectangle height
		this.duration = this.endTime - time;

		// if new duration is negative or 0 we stop bursting
		if(this.duration <= 0 || time > this.endTime || this.originalDuration <= duration){
			ScoreManager.scoreSustainedNote(this.originalDuration, duration, this.lane);
			this.kill(true);
			return false;
		}

		// lock note onto hitarea (long note behavior)
		this.time = game.time.now - AudioManager.startTime;//AudioManager.getPosition();
		this.y = RL.config.buttonY + RL.config.noteHeightDifferenceToButton - noteContainer.y;

		// show particle burst
		if(this.burstCounter == 0 || this.burstCounter % 4 == 0){
			HighwayManager.particleBurst(this.lane, true);
			ScoreManager.scoreSustainedNote(this.originalDuration, duration, this.lane);
		}

		if(this.burstCounter % 3 == 0){
			// update rectangle
			this.drawRect(duration);
		}

		this.burstCounter++;
	}
}

RL.Note.prototype.endTap = function(){
	if(this.hit){
		this.kill();
	}
}

RL.Note.prototype.kill = function(force){
	//force = typeof(force) != 'undefined' ? force : false;

	RL.hittableNotes[this.lane] = false;
	InteractionManager.keyboardPresses[this.lane] = 0;

	if(typeof(this.rect) !== 'undefined'){
		this.rect.destroy(true);
	}

	this.destroy(true);
}
;/** game stuff **/
var game = null;

jQuery(function($) {
    /** SETTINGS **/
    max_sparkles_slider = $('#slider--max-sparkles').slider({
      value: RL.config.burstCount,
      range: "min",
      min: 1,
      max: 99,
      step: 1,
      slide: function(event, ui){
        $('#slider-value--max-sparkles').html(ui.value);
        $('input[name="player_burst_count"]').val(ui.value);
        RL.config.burstCount = ui.value;
      }
    });

    cheering_volume_slider = $('#slider--cheering-volume').slider({
      value: RL.config.cheeringVolume,
      range: "min",
      min: 0.0,
      max: 1,
      step: 0.1,
      slide: function(event, ui){
        $('#slider-value--cheering-volume').html(ui.value);
        $('input[name="player_cheering_volume"]').val(ui.value);
        RL.config.cheeringVolume = ui.value;
      }
    });

    $('input[name="player_enable_cheering"]').on('change', function(e){
      if($('input[name="player_enable_cheering"]:checked').length > 0){
        RL.config.enableCheering = 1;
      }else{
        RL.config.enableCheering = 0;
      }
    });

    $('#player-settings-form input[type="button"]').on('click', function(e){
      e.preventDefault();

      RL.toggleSettings();

      RL.init();
    });

    $('select[name="player_display_mode"]').on('change', function(e){
      e.preventDefault();
      RL.config.displayMode = $('select[name="player_display_mode"] option:selected').val();
    });

    $('.settings-button a').on('click', function(e){
        e.preventDefault();

        RL.toggleSettings();
    });
    $('.settings-overlay .fa-stack').on('click', function(e){
      RL.toggleSettings();
    });
});

function settingsSaved(response){
  $('#player-settings-form .success').fadeIn();

  setTimeout(function(){
    $('#player-settings-form .success').fadeOut();
  }, 2000);
}

/***/

Number.prototype.roundTo = function(num) {
    var resto = this%num;
    if (resto <= (num/2)) {
        return this-resto;
    } else {
        return this+num-resto;
    }
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

/*!
 devtools-detect
 Detect if DevTools is open
 https://github.com/sindresorhus/devtools-detect
 by Sindre Sorhus
 MIT License
 *
(function () {
    var devtools = {open: false};
    var threshold = 160;
    var emitEvent = function (state) {
        if(state)
        {
          if(typeof(ScoreManager) != 'undefined' && Object.isFrozen(ScoreManager) === false)
          {
            ScoreManager.init();

            Object.freeze(ScoreManager);
          }
        }
    };

    var checkDevtoolsOpen = function(){
       if ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || window.outerWidth - window.innerWidth > threshold ||
            window.outerHeight - window.innerHeight > threshold) {
            emitEvent(true);
            devtools.open = true;
        } else {
            emitEvent(false);
            devtools.open = false;
        }
    }

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = devtools;
    } else {
        window.devtools = devtools;
    }

    var checkDevToolsInterval = setInterval(checkDevtoolsOpen, 2500);
})();*/
