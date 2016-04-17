var RL = {
	States: {}, // holds the games states
    sounds: {},

	hittableNotes: [false,false,false,false,false,false],
    pressedButtons: [false, false, false, false, false, false],
    playAdded: false,

    init: function()
    {         

        RL.editMode = RL.isEditMode();
        RL.playerHeightOnePercent = RL.config.height/100;
      
        restart = false;
        if(game != null){
            game.destroy();
            AudioManager.stop();
            createjs.Sound.removeAllSounds();
            RL.hittableNotes = [false,false,false,false,false,false];
            RL.pressedButtons = [false,false,false,false,false,false];
            $('#main-canvas canvas').remove();
            $('.counter-overlay .count').hide().html(RL.config.countSeconds);
            $('.counter-overlay .info').fadeIn();
            game = null;
            restart = true;
        }

        RL.config.pxPerMs = RL.config.pxPerSecond / 1000;
        RL.negPxPerMs = -RL.config.pxPerMs;
        RL.msOnScreen = RL.config.height / RL.config.pxPerMs;

        EditorManager = new RL.EditorManager();
        AudioManager = new RL.AudioManager();

        HighwayManager = new RL.HighwayManager();
        HighwayManager.aNotes = aNotes;

        InteractionManager = new RL.InteractionManager();

        if(RL.editMode){
            EditorInteractionManager = new RL.InteractionManager.Editor();
        }

        ScoreManager = new RL.ScoreManager();

        //
        
        var displayMode = Phaser.AUTO;

        switch(RL.config.displayMode){
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

        game.state.add('Boot', RL.States.Boot);
        game.state.add('Play', RL.States.Play);
        game.state.add('Editor', RL.States.Editor);

        WebFontConfig = {
            active: function() { game.time.events.add(Phaser.Timer.SECOND, RL.HighwayManager.createText, this); },
            google: {
                families: ['Roboto']
            }
        };

        game.state.start('Boot');
    },

	getPosXForLane: function(lane){
		return RL.config.width / (RL.config.lanes+1) * lane;
	},

    getLaneForX: function(x, mouse){
        for(var i = 0 ; i <= RL.config.lanes; ++i){
            var laneX= RL.config.width / (RL.config.lanes) * i - RL.config.buttonWidth/2;
            var laneX = laneX + RL.config.noteWidth;
            if(laneX >= x){
                return i;
            }
        }
        return 6;
    },

    getTimeForY: function(y){
        return (y - RL.config.noteHeightDifferenceToButton) / RL.negPxPerMs;
    },

    getPosXForLane: function(lane){
        return RL.config.width / 6 * lane;
    },

    getXForLaneButton: function(lane){
        return RL.config.width / 6 * lane - RL.config.noteWidth/2;
    },

    getYForTime: function(time){
        return time * RL.negPxPerMs + RL.config.noteHeightDifferenceToButton;
    },

    getSpriteForLane: function(lane){
        return game.cache.getImage('note_lane'+lane);
    },

    addPlay: function()
    {
        $.post('/play/add/'+track_id);
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
		var index = 0;

        switch(keyCode){
            case RL.config.buttonKeys[0]:
                index = 0;
                break;
            case RL.config.buttonKeys[1]:
                index = 1;
                break;
            case RL.config.buttonKeys[2]:
                index = 2;
                break;
            case RL.config.buttonKeys[3]:
                index = 3;
                break;
            case RL.config.buttonKeys[4]:
                index = 4;
                break;
            case RL.config.buttonKeys[5]:
                index = 5;
                break;
            case RL.config.buttonKeys[6]:
                index = 6;
                break;
            default:
                index = -1;
                break;
        }

        return index;
	},

    isEditMode: function()
    {
        return (typeof(edit_mode) != 'undefined' && edit_mode) ? true : false;
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

Array.prototype.AllValuesSame = function(){

    if(this.length > 0) {
        for(var i = 1; i < this.length; i++)
        {
            if(this[i] !== this[0])
                return false;
        }
    } 
    return true;
}