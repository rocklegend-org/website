/**
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
};