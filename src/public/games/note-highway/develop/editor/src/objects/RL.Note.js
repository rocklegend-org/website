/**
* Represents a note object
* Contains all data for the note, e.g. time, duration, lane etc.
*
* @class RL.Note
* @constructor
*/

RL.Note = function(game, opts){
	this.className = 'RL.Note';
 	this.game = game;

 	if(typeof(opts.y) == 'undefined' || opts.y == null){
 		var y = RL.getYForTime(opts.time);
 	}else{
 		var y = opts.y;
 	}	

	var x = RL.getXForLaneButton(opts.lane);
	var lane = opts.lane;
	var time = opts.time;
	var duration = opts.duration;
	var frame = opts.hopo ? 2 : 0;
	var self = this;

	var cb = typeof(opts.cb) != 'undefined' ? opts.cb:false;
	var hitcb = typeof(opts.hitcb) != 'undefined' ? opts.hitcb:false;

	Phaser.Sprite.call(this, this.game, x, y, 'spritesheet', 0);

	this.showRect = typeof(opts.showRect) !== 'undefined' ? opts.showRect : false;
	this.hopo = typeof(opts.hopo) != 'undefined' ? opts.hopo : false;
	this.hit = false;
	this.lane = lane;
	this.time = parseFloat(time);
	this.removed = false;
	this.originalTime = parseFloat(time);
	this.duration = typeof(duration) != 'undefined' ? parseFloat(duration) : 0;
	this.originalDuration = parseFloat(this.duration);
	this.endTime = this.time + this.duration;

	this.cb_fired = false;
	this.hitcb_fired = false;
	this.cb = cb;
	this.hitcb = hitcb;

	this.maxHitY = RL.config.buttonY+RL.config.buttonHeight;
	this.minHitY = RL.config.buttonY-RL.config.noteHeight/1.5;
	this.shortMaxHitY = this.maxHitY;

	if(this.duration >= RL.config.longNoteThreshold){
		this.drawRect(this.showRect);
	}

	this.exists = false;

	this.setDefaultTexture();

	this.game.add.existing(this);
}

RL.Note.prototype = Object.create(Phaser.Sprite.prototype);
RL.Note.prototype.constructor = RL.Note;

RL.Note.prototype.create = function(){}

RL.Note.prototype.drawRect = function(shorter){
	if(typeof shorter === 'undefined') shorter = false;

	var rectangleHeight = this.duration/1000 * RL.config.pxPerSecond + RL.config.noteHeight/2;

	rectangleY =  this.y - rectangleHeight + RL.config.noteHeight/2;

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
		if (this.rect.y !== rectangleY) {
			this.rect.scale.setTo(1, 1);
			this.rect.y = rectangleY;
			this.rect.scale.setTo(1, rectangleHeight/30);
		}

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
	if(this.time > AudioManager.currentTime + RL.msOnScreen || 
		this.time < AudioManager.currentTime - this.duration - 250 ||
		!this.alive){
		this.exists = false;

		if(typeof this.rect !== 'undefined')
		{
			this.rect.exists = false;
		}		
	}else{
		this.exists = true;

		if(typeof this.rect !== 'undefined')
		{
			this.rect.exists = true;
		}
	}

	if(this.input != null && this.input.isDragged){
		var pointerDiff = game.input.activePointer.y;

		this.input.updateDrag(game.input.activePointer);

		lane = this.setLaneForX(this.x) - 1;

		time = RL.getTimeForY(this.y);

		// if advanced editor is active and grid snapping is activated 
		// the notes y position should snap to the grid
		if(	EditorManager.beatsInitialized &&
			EditorManager.grid_snap)
		{
			snap = EditorManager.secondsPerNote*1000;

			time = time.roundTo(snap);
		}

		this.isSelected = true;
		this.setDefaultTexture();

		this.time = time;
		this.y = RL.getYForTime(time);

		/** MOVE CORRESPONDING SUSTAINED RECTANGLE! **/
		if(typeof this.rect !== 'undefined'){
			this.rect.destroy();
			this.rect = undefined;
			this.drawRect(true);
		}
	}
}

RL.Note.prototype.kill = function(force){
	force = typeof(force) != 'undefined' ? force : false;

	RL.hittableNotes[this.lane] = false;

	if(force){
		if(force && typeof this.rect !== 'undefined') this.rect.destroy(true);
	}

	noteContainer.remove(this, true, true);
}

RL.Note.prototype.updateY = function(){
	this.y = RL.getYForTime(this.time);

	if(typeof this.rect != 'undefined') this.drawRect();
}

/**
 * getTimeForY(y)
 *
 * (int) y = the y position in pixels
 *
 * @return (float) time = the time in ms
 */
RL.Note.prototype.updateTime = function(){
	var time = RL.getTimeForY(this.y);
	this.time = time;
	return time;
}

RL.Note.prototype.updateDuration = function(duration){
	this.duration = parseFloat(duration);
	this.originalDuration = this.duration;
	this.endTime = this.time + this.duration;

	this.maxHitY = RL.config.buttonY+RL.config.noteHeight;
	this.minHitY = RL.config.buttonY-RL.config.noteHeight+20;
	this.shortMaxHitY = this.maxHitY;

	if(this.duration >= RL.config.longNoteThreshold){
		this.drawRect();
	}else if(typeof this.rect != 'undefined'){
		this.rect.destroy();
	}
}

/**
 * getLaneForX(y)
 *
 * (int) x = the x position in pixels
 *
 * @return (int) lane = the lane number
 */
RL.Note.prototype.setLaneForX = function(x, mouse){
   	if(typeof(mouse) == 'undefined') mouse = false;
	//x += RL.config.noteWidth / 2;
	for(var i = 0 ; i <= RL.config.lanes; ++i){
		var laneX= RL.config.width / (RL.config.lanes) * i - RL.config.buttonWidth/2;
		if(!mouse){
			if(laneX >= x){
				this.lane = i;
				return i;
			}
		}else{
			var laneX = laneX + RL.config.noteWidth;
			if(laneX >= x){
				this.lane = i;
				return i;
			}
		}
	}

	this.lane = 5;

	return 6;
}

RL.Note.prototype.updateLane = function(lane){
	for(var l = 0; l < HighwayManager.aNotes.length; l++){
		laneNotes = HighwayManager.aNotes[l];
		for(var n = 0; n < laneNotes.length; n++){
			if(laneNotes[n] == this){
				laneNotes.splice(n,1);
			}
		}
	}

	this.x = RL.getXForLaneButton(lane);
	this.lane = lane;
	this.loadTexture('spritesheet',5*this.lane-3);

	if(typeof(this.rect) !== 'undefined'){
		this.drawRect();
	}
	HighwayManager.aNotes[this.lane].push(this);

	return this;
}

RL.Note.prototype.setHOPO = function(on){
	this.hopo = on ? true : false;

	this.setDefaultTexture();
}

RL.Note.prototype.setDefaultTexture = function(){
	if(!this.isSelected){
		if(this.hopo){
			this.loadTexture('spritesheet',5*this.lane-1);
		}else{
			this.loadTexture('spritesheet',5*this.lane-3);
		}
	}else{
		this.loadTexture('spritesheet',5*this.lane-2);
	}
}

RL.Note.prototype.initEditorFunctions = function(){
	this.isSelected = false;
	this.ticked = false;
	
	this.inputEnabled = true;
	this.input.enabled = true;
	this.input.enableDrag(	
		false, 
		true, 
		true, 
		255, 
		0, 
		new Phaser.Rectangle(
			RL.config.noteWidth/2,
			-900719925474,
			RL.config.width-RL.config.noteWidth,
			900719925474
		)
	);

	this.input.useHandCursor = true;
    this.input.allowHorizontalDrag = true;

    this.input.enableSnap(	
    	RL.config.width / (RL.config.lanes+1), 
		0.1, 
		true, 
		false, 
		-RL.config.noteHeight/2, 
		0
    );

    this.input.pixelPerfectAlpha = 1;

    game.physics.enable(this, Phaser.Physics.ARCADE);

    this.events.onInputDown.add( EditorManager.onNoteDown );
    this.events.onInputUp.add( EditorManager.onNoteUp );

    this.events.onDragStart.add(EditorManager.onNoteDragStart);
    this.events.onDragStop.add(EditorManager.onNoteDragStop);
    this.onHold = EditorManager.onDragging;
}