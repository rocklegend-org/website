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
};