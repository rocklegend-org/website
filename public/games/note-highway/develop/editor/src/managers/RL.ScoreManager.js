RL.ScoreManager = function(){
return {
	score: 0,
	multiplier: 1,
	streak: 0,
	max_streak: 0,
	max_multiplier: 0,
	notes_hit: 0,
	notes_missed: 0,
	percent: 0,

	sustainedCache: [0,0,0,0,0,0],

	cheeringStreak: [25, 50, 100, 150, 200, 300, 400, 500],

	singleNotePoints: 50,

	$score: $('.score-display .score'),
	$streak: $('.score-display .streak'),
	$multiplier: $('.score-display .multiplier'),

	init: function(){
		this.$score.html('0');
		this.$streak.html('0');
		this.$multiplier.html('x1');

		$('.repeat-song').unbind().on('click', function(e){
			e.preventDefault();

			$('.score-overlay').fadeOut();
			
			ScoreManager.animateFinishBack('.score-points-wrap', 0);
			ScoreManager.animateFinishBack('.score-streak-wrap', 1);
			ScoreManager.animateFinishBack('.score-multiplier-wrap', 0);

			RL.init();
		});

		$('.share-score').unbind().on('click', function(e){
			FB.ui({
				method: 'feed',
				caption: 'Can you beat my score?',
				name: share_title,
				description: 'I just scored '+numberWithDots(ScoreManager.score)+' points on "'+song_name+'" by '+artist_name+'! A max streak of '+numberWithDots(ScoreManager.max_streak)+', '+
								numberWithDots(ScoreManager.notes_hit)+' notes hit and a completion of '+ScoreManager.percent+'%. #thisisrocklegend',
				link: share_url,
				picture: thumbnail_url
			});
		});
	},

	ended: function(){
		if(!RL.editMode && !testMode){
			// here we should switch to the next state -> "ENDED"
			$.post('/play/score/'+track_id+'/save',
			{
				score: ScoreManager.score,
				max_streak: ScoreManager.max_streak,
				max_multiplier: ScoreManager.max_multiplier,
				notes_missed: ScoreManager.notes_missed,
				notes_hit: ScoreManager.notes_hit
			}, function(data){
				// data should be an object with score related information
				if(rl.focusMode){
					rl.darkenPage();
				}

				$('.score-overlay').fadeIn();
				
				var total_notes = notes_count;
				var percent_hit = (ScoreManager.notes_hit / total_notes * 100).toFixed(2);

				ScoreManager.percent = percent_hit;

				ScoreManager.animateFinish('.score-points-wrap', 2, function(){});

				setTimeout(function(){
					ScoreManager.animateFinish('.score-streak-wrap',1.5, function(){
						$('.score-streak-wrap h1').eq(2).not('.streak').html('Max Streak');
						$('.score-streak-wrap h1.streak').eq(1).html(ScoreManager.max_streak);
					});
				}, 270);

				setTimeout(function(){
					ScoreManager.animateFinish('.score-multiplier-wrap',3.5, function(){
						$('.score-multiplier-wrap h1').eq(2).not('.multiplier').html('Percent');
						$('.score-multiplier-wrap h1.multiplier').eq(1).html(percent_hit+'%');
					});
				}, 540);

				setTimeout(function(){
					$('.score-button-wrap').fadeIn();
				}, 1010);

				RL.sounds.crowds[0].play();
			});
		}
	},

	animateFinish: function(selector, indent, cb)
	{
		var indent = typeof(indent) != 'undefined' ? indent : 0;

		var $scoreWrap = $(selector);
		var $scoreClone = $scoreWrap.clone();

		$scoreClone
			.css({
				position: 'absolute',
				top: $scoreWrap.offset().top-1,
				left: $scoreWrap.offset().left
			})
			.appendTo('body')
			.transition({
				left: $('.score-overlay').offset().left + $('.score-overlay').width()/2 - $scoreClone.width() + indent * 20,
				duration: 500
			}, 500, 'ease-in-out');

		$scoreWrap.fadeOut(0).css({ display: 'inline-block', visibility : 'hidden'});

		cb();
	},

	animateFinishBack: function(selector, indent)
	{
		var $scoreWrap = $(selector).eq(0);
		var $scoreClone = $(selector).eq(1);

		$scoreClone
			.transition({
				left: $scoreWrap.offset().left - indent*20,
				duration: 500
			}, 500, 'ease-in-out');

		setTimeout(function(){
			$scoreClone.fadeOut(200,function(){ $scoreClone.remove(); });
			$scoreWrap.css('visibility', 'visible').fadeOut(0).fadeIn(200);
		}, 500);
	},

	adjustScoreBox: function(){
		$('.scoreBox').css({
			position: 'absolute',
			left: $('#main-canvas canvas').offset().left + RL.config.width,
			top: $('#main-canvas canvas').offset().top + 60,
		});
	},

	scoreSingleNote: function(){
		this.score += this.singleNotePoints * this.multiplier;
		this.increaseStreak();

		if(this.streak % 10 == 0){
			this.increaseMultiplier();
		}

		this.$score.html(numberWithDots(this.score));
	},

	scoreSustainedNote: function(duration, currentDuration, lane)
	{
		perc = Math.ceil((currentDuration / (duration/100))/1000 * duration * this.multiplier);
		this.score -= this.sustainedCache[lane];

		if(this.sustainedCache[lane] <= 0){
			this.increaseStreak();

			if(this.streak % 10 == 0){
				this.increaseMultiplier();
			}
		}

		this.sustainedCache[lane] = perc;
		this.score += perc;

		this.$score.html(numberWithDots(this.score));
	},

	resetSustainedCache: function(lane)
	{
		this.sustainedCache[lane] = 0;
	},

	increaseMultiplier: function(){
		// maximum multiplier: 4
		if(this.multiplier <= 3){
			this.multiplier++;
			this.$multiplier.html('x'+this.multiplier);

			if(this.max_multiplier < this.multiplier){
				this.max_multiplier = this.multiplier;
			}
		}
	},

	increaseStreak: function(){
		this.streak++;
		this.$streak.html(this.streak);

		if(this.max_streak < this.streak){
			this.max_streak = this.streak;
		}

		if(this.cheeringStreak.indexOf(this.streak) > -1){
			rand = Math.floor(Math.random() * RL.sounds.crowds.length);
			RL.sounds.crowds[rand].play();
		}
	},

	reset: function(){
		this.multiplier = 1;
		this.streak = 0;

		this.$streak.html('0');
		this.$multiplier.html('x1');
	}
}
};

function numberWithDots(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}