/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Boot = {
    soundsToLoad: 1, // the amount of sounds loaded by soundjs
    soundsLoaded: 0, // holds the current amount of loaded sounds by soundjs

    preload: function()
    {
        HighwayManager.showLoadingScreen();

        game.load.crossOrigin = 'anonymous';
        game.load.baseURL = ASSETS_BASE_URL;

        game.load.atlasJSONHash('spritesheet', '/assets/images/game/spritesheet-player.png?t='+(new Date()).getTime(), '/assets/images/game/spritesheet-hash.json?t='+(new Date()).getTime());

        game.load.audio('squeak', ['/assets/sounds/game/squeak1.mp3', '/assets/sounds/game/squeak1.ogg']);
        game.load.audio('tick', ['/assets/sounds/game/tick.mp3', '/assets/sounds/game/tick.ogg']);
        
        game.load.script('webfont', '/assets/js/plugins/webfont.js');

        createjs.Sound.registerPlugins([createjs.HTMLAudioPlugin, createjs.WebAudioPlugin, createjs.FlashPlugin]);
        createjs.Sound.registerSound(game.load.baseURL+soundFiles[0], "music");
        createjs.Sound.addEventListener("fileload", createjs.proxy(this.loadedSound, this));
    },

    // this function waits for the createjs sounds to be loaded and then switches to the next state
    update: function()
    {
        if(this.soundsToLoad <= this.soundsLoaded)
        {
            $('#main-canvas canvas').css('visibility', 'visible');
            
            if(typeof(RL.music) == 'undefined'){
                RL.music = createjs.Sound.createInstance('music');
            }else{
                AudioManager.stop();
            }
            
            RL.music.addEventListener("complete", createjs.proxy(ScoreManager.ended, this));

            RL.sounds.squeaks = [game.add.sound('squeak1')];

            $(document).on("keydown", function (e) {
              {
                if(e.which == 32 && !$('input,textarea').is(':focus')){ e.preventDefault(); }
              }
            });

            RL.sounds.ticks = [ false, game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick'), game.add.sound('tick') ];
            
            game.state.start("Editor");
        }
    },

    /* soundjs loadcheck*/
    loadedSound: function()
    {
        this.soundsLoaded ++;
    }
}