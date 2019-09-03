/**
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
}