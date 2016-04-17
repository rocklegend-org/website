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
