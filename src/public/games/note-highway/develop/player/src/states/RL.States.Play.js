/**
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
        
            if(game.time.now % 4 == 0)
            {
                ScoreManager.renderScore();         
                HighwayManager.drawProgressbar((RL.playerHeightOnePercent * currentPlaybackTime)/AudioManager.onePercent);
            }
        }
    }
}