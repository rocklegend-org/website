/**
* Defines the Boot State (initial state) of rocklegends play
* This state loads the assets and then switches to the Run state
*/
RL.States.Editor = {
    dragBoxNoteContainerStartY: 0,
    dragStartX: false,
    dragStartY: false,
    dragBoxWidth: false,
    dragBoxHeight: false,
    $timer: $('#debug-container input[name="current-time"]'),

    preload: function(){

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
        game.stage.disableVisibilityChange = true;
        game.stage.backgroundColor = 0X2C2C2C;

        InteractionManager.init();

        HighwayManager.drawGrid();
        HighwayManager.createButtons();

        noteContainer = game.add.group(game, game.world, "noteContainer", false);
        //noteContainer.enableBody = true;
        noteContainer.inputEnabled = true;

        HighwayManager.drawNotes();

        EditorManager.init();

        // mouseevent listener
        game.input.onDown.add(EditorInteractionManager.handleCanvasDown);
        game.input.onUp.add(EditorInteractionManager.handleCanvasUp);

        squeak = game.add.sound('squeak');
        tick = game.add.sound('tick');

        _emitters = HighwayManager.emitter;
        _emitterY = RL.config.buttonY + RL.config.buttonHeight/2;

        for(var i = 1; i <= 5; ++i){
            _emitters.push(game.add.emitter(0, 0, 50));
            _emitters[i].makeParticles(['spritesheet'], 24+i);
            _emitters[i].gravity = 400;
            _emitters[i].x = RL.getPosXForLane(i);
            _emitters[i].y = _emitterY;
        }

        AudioManager.init();

        $('canvas').on("contextmenu", function(evt) {evt.preventDefault();});
            
        HighwayManager.hideLoadingScreen();

        dragSelectionBox = game.add.graphics(0,0);
        dragSelectionBox.z = 100;
        dragSelectionBox.renderable = false;
        dragSelectionPhysicsBox = game.add.sprite(0,0,null);
        dragSelectionPhysicsBox.renderable = false;

        game.physics.enable(dragSelectionPhysicsBox, Phaser.Physics.ARCADE);
        dragSelectionPhysicsBox.body.setSize(0,0,0,0);
        dragSelectionPhysicsBox.body.enable = false;
    },

    update: function()
    {
        currentPlaybackTime = AudioManager.getPosition();

        noteContainer.y = RL.config.buttonY + (currentPlaybackTime/1000 * RL.config.pxPerSecond);;

        if(game.time.now % 2 == 0)
        {
            this.$timer.val(currentPlaybackTime.toFixed(3));
        }

        if(EditorManager.positionSlider){
            EditorManager.positionSlider.slider('value', currentPlaybackTime.toFixed(3));
        }

        if(game.input.activePointer.isDown && !EditorManager.dragging){
            HighwayManager.setPhysics(true);

            if(game.input.activePointer.y <= 25){
                AudioManager.setPosition(currentPlaybackTime+game.input.activePointer.duration/75);
            }else if(game.input.activePointer.y >= RL.config.height-25){
                AudioManager.setPosition(currentPlaybackTime-game.input.activePointer.duration/75);
            }

            if(!EditorManager.dragging){
                if(this.dragStartX === false){
                    this.dragStartX = game.input.activePointer.x;
                    this.dragStartY = game.input.activePointer.y;
                    this.dragBoxNoteContainerStartY = noteContainer.y;
                }
        
                dragSelectionBox.endFill();
                dragSelectionBox.clear();
                dragSelectionBox.beginFill(0XCCCCCC,0.5);
                dragSelectionBox.lineStyle(1,0XFFFFFF,0.8);

                // calculate new selection width
                this.dragBoxWidth = game.input.activePointer.x - this.dragStartX;

                // calculate offset of repositioned noteContainer
                noteContainerDiff = noteContainer.y - this.dragBoxNoteContainerStartY;

                startY = this.dragStartY + noteContainerDiff;

                this.dragBoxHeight = game.input.activePointer.y - startY;

                dragSelectionBox.drawRect(this.dragStartX, startY, this.dragBoxWidth, this.dragBoxHeight);
            }
        }else{
            if(this.dragStartX !== false){
                dragSelectionBox.endFill();

                if((this.dragBoxWidth > 40 || this.dragBoxWidth < -40) && (this.dragBoxHeight > 20 || this.dragBoxHeight < -20)){
                    // calculate offset of repositioned noteContainer
                    noteContainerDiff = noteContainer.y - this.dragBoxNoteContainerStartY;

                    startY = this.dragStartY + noteContainerDiff;
                   
                    // set collision box
                    dragSelectionPhysicsBox.body.setSize(Math.abs(this.dragBoxWidth), Math.abs(this.dragBoxHeight), this.dragBoxWidth < 0 ? this.dragStartX + this.dragBoxWidth : this.dragStartX, this.dragBoxHeight < 0 ? startY + this.dragBoxHeight : startY);

                    if(game.input.keyboard.event != null){
                        var shiftKey = game.input.keyboard.event.shiftKey;
                    }else{
                        shiftKey = false;
                    }

                    /** if shiftkey is not pressed we start a new selection **/
                    if(!shiftKey){
                        EditorManager.resetSelectedNotes();
                    }

                    setTimeout(function(){
                        dragSelectionBox.clear(); // we want the selection to disappear after the notes are selected
                        
                        function noteSelectionCallback(note, box){ 
                            EditorManager.onNoteDown(note, null, true);
                        }

                        noteContainer.forEach(function(note){
                            game.physics.arcade.overlap(note, dragSelectionPhysicsBox, noteSelectionCallback);
                        });
                        
                        HighwayManager.setPhysics(false);              
                    }, 50);

                }else{
                    dragSelectionBox.clear();
                }

                this.dragStartX = false;
                this.dragStartY = false;
            }       
        }

        if(EditorManager.advancedMode){
            EditorManager.beatLineContainer.y = noteContainer.y;
            EditorManager.beatLineTextContainer.y = noteContainer.y;

            EditorManager.drawBeatLines();
        }
    },

    render: function(){
        //game.debug.body(dragSelectionPhysicsBox);
    }
}