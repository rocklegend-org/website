/**
 * This manages audio stuff.
 * It's to be used as a wrapper for any sound framework that might be used
 *
 * @module RL.AudioManager
 */

RL.AudioManager = function(){
return {
	duration : 0,
	halfTime: 0,
	onePercent: 0,
	muted: false,

	init: function()
	{
		this.duration = this.getDuration();
		this.onePercent = this.duration/100;
		this.halfTime = this.duration/2;
	},
	setPosition : function(pos){
		if(pos <= 0){
			pos = 0;
		}else if(pos >= AudioManager.getDuration()){
			pos = AudioManager.getDuration();
		}

		RL.music.setPosition(pos);

		for(var l = 0; l < aNotes.length; l++){
			lane = aNotes[l];

			for(var i = 0; i < lane.length; i++){
				lane[i].ticked = false;
			}
		}
	},

	getPosition : function(audio){
		var position = RL.music.position;

		AudioManager.currentTime = position;
		return position;
	},

	getDuration: function(){
		return RL.music.duration;
	},

	getPlaybackRate: function()
	{
		return RL.music._playbackResource.playbackRate;
	},

	setPlaybackRate : function(speed){
		RL.music._playbackResource.playbackRate  = speed;
	    jQuery('input[name="playbackRate"]').val(speed.toFixed(2));
	},

	toggleMute: function(){
		if(this.muted){
			RL.music.muted = false;
			this.muted = false;
		}else{
			RL.music.muted = true;
			this.muted = true;
		}
	},

	pause: function()
	{
		RL.music.paused = true;
	},

	stop: function()
	{
		return RL.music.stop();
	},

	play: function()
	{
		RL.music.play();
	}
}
};