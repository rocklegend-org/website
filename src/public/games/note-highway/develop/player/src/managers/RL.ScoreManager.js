RL.ScoreManager = function(){
	var scoreManagerObject = {
		_score: 0,
		score: 0,
		multiplier: 1,
		streak: 0,
		max_streak: 0,
		max_multiplier: 0,
		notes_hit: 0,
		notes_missed: 0,
		percent: 0,

		prev_streak: 0,
		prev_multiplier: 0,
		prev_score: 0,

		score_highest: 0,
		score_user_highest: 0,
		score_friend_highest: 0,
		score_bar_percent: 0,

		score_bar_current_element: 0,

		sustainedCache: [0,0,0,0,0,0],

		cheeringStreak: [25, 50, 100, 150, 200, 300, 400, 500],

		singleNotePoints: 50,
		friendScoreInterval: false,

		scoreTracking: [{t:0,str:0,score:0,multiplier:1}],

		$score: document.getElementById('score-num'),//$('.score-display .score'),
		$streak: document.getElementById('streak-num'),// $('.score-display .streak'),
		$multiplier: document.getElementById('multiplier-num'),//$('.score-display .multiplier'),

		friendScoreBar: document.getElementById('bar-score-friend'),

		init: function(){
			this.$score.innerHTML = '0';
			this.$streak.innerHTML = '0';
			this.$multiplier.innerHTML = 'x1';

			// init score bars
			if(max_user_score > 0){
				this.score_highest = max_score;

				var user_scorebar_height = max_user_score / max_score * 100;
				$('.bar-user-highscore').css('height',user_scorebar_height+'%').show();

			}

			if(max_friend_score > 0){
				var friend_scorebar_height = max_friend_score / max_score * 100;
				$('.bar-friend-score').css('height',friend_scorebar_height+'%').show();
			}

			if(friend_score_tracked)
			{
				var friend_scorebar_height = 0;
				$('.bar-friend-score').css('height',friend_scorebar_height+'%').show();
			}

			this.score_bar_current_element = document.getElementById('bar-score-current');
			this.score_bar_current_element.style.height = '0%';
			this.score_bar_current_element.style.display = 'block';

			$('.repeat-song').unbind().on('click', function(e){
				e.preventDefault();

	        	ga('send', 'event', 'Song', 'repeat', '1');

				$('.score-overlay').fadeOut();

				ScoreManager.animateFinishBack('.score-points-wrap', 0);
				ScoreManager.animateFinishBack('.score-streak-wrap', 1);
				ScoreManager.animateFinishBack('.score-multiplier-wrap', 0);

				RL.init();
			});

			$('.share-score').unbind().on('click', function(e){
	        	ga('send', 'event', 'Share', 'facebook - share score', 'score', ScoreManager.score);

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
			if(!RL.editMode){
				AudioManager.ended = true;
				AudioManager.stop();

	        	ga('send', 'event', 'Song', 'play', '1');

	        	$('.reloadSong').fadeOut();

				// here we should switch to the next state -> "ENDED"
				if(!testMode && Object.isFrozen(ScoreManager) === false){
					var tracked_score = [{t:0,str:0,score:0,multiplier:1}];
					var previousTime = 0;

					$.each(ScoreManager.scoreTracking, function(i, o)
					{
						if(o.t < previousTime)
						{
							tracked_score = [{t:0,str:0,score:0,multiplier:1}];
						}

						if(o.t >= tracked_score[tracked_score.length-1].t+500 || i >= tracked_score.length-1)
						{
							tracked_score.push(o);
						}

						previousTime = o.t;
					});

					var tracked_string = lzw_encode(JSON.stringify({ data: tracked_score}));

					$.post('/play/score/'+track_id+'/save',
					{
						score: ScoreManager.score,
						max_streak: ScoreManager.max_streak,
						max_multiplier: ScoreManager.max_multiplier,
						notes_missed: ScoreManager.notes_missed,
						notes_hit: ScoreManager.notes_hit,
						ts: tracked_string,
						mode: RL.config.mode,
						devMode: false, //window.devtools.open,
						_token: csrf
					}, function(data){
						if(data.badge){
							rl.badge.showBadgeInfo(parseInt(data.badge));
						}
						ScoreManager.showScoreScreen(data);
					});
				}else{
					ScoreManager.showScoreScreen();
				}
			}
		},

		showScoreScreen: function(data)
		{
			$('.score-overlay').fadeIn();

			var total_notes = notes_count;
			var percent_hit = (ScoreManager.notes_hit / total_notes * 100).toFixed(2);

			ScoreManager.percent = percent_hit;

	    	ga('send', 'event', 'Score', 'new', 'points', ScoreManager.score);
	    	ga('send', 'event', 'Score', 'new', 'percentage', ScoreManager.percent);
	    	ga('send', 'event', 'Score', 'new', 'max streak', ScoreManager.max_streak);

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

			setTimeout(function(){
				rl.darkenPage(false);
			}, 1500);

			RL.sounds.crowds[0].play();

			scores.fetch();
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

			this.trackScore();
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

			this.trackScore();
		},

		resetSustainedCache: function(lane)
		{
			this.sustainedCache[lane] = 0;
		},

		increaseMultiplier: function(){
			// maximum multiplier: 4
			if(this.multiplier <= 3){
				this.multiplier++;

				if(this.max_multiplier < this.multiplier){
					this.max_multiplier = this.multiplier;
				}
			}
		},

		increaseStreak: function(){
			this.streak++;

			if(this.max_streak < this.streak){
				this.max_streak = this.streak;
			}

			if(RL.config.enableCheering && this.cheeringStreak.indexOf(this.streak) > -1){
				rand = Math.floor(Math.random() * RL.sounds.crowds.length);
				RL.sounds.crowds[rand].play();
			}
		},

		renderScore: function()
		{
			if(this.prev_streak != this.streak)
			{
				this.$streak.innerHTML = this.streak;
				this.prev_streak = this.streak;
			}

			if(this.prev_multiplier != this.multiplier)
			{
				this.$multiplier.innerHTML = 'x'+this.multiplier;
				this.prev_multiplier = this.multiplier;
			}

			if(this.prev_score != this.score)
			{
				this.$score.innerHTML = numberWithDots(this.score);
				this.prev_score = this.score;
				this.score_bar_current_element.style.height = (this.score / max_score * 100)+'%';
			}

			if(friend_score_tracked)
			{
				this.renderFriendScore();
			}
		},

		reset: function(){
			this.multiplier = 1;
			this.streak = 0;

			this.renderScore();
			this.trackScore();
		},

		trackScore: function()
		{
			var previousScore = this.scoreTracking[this.scoreTracking.length-1];

			var newScore = { };

			var filled = false;

			if(previousScore.score != this.score){
				newScore.score = this.score;
				filled = true;
			}

			if(previousScore.mp != this.multiplier){
				newScore.mp = this.multiplier;
				filled = true;
			}

			if(previousScore.str != this.streak){
				newScore.str = this.streak;
				filled = true;
			}

			if(filled)
			{
				newScore.t = game.time.now - AudioManager.startTime;
				this.scoreTracking.push(newScore);
			}
		},

		renderFriendScore: function()
		{
			if(friend_score_tracked.length && AudioManager.startTime > 0)
			{
				do{
					var updateData = friend_score_tracked[0];

					if(updateData.t <= game.time.now - AudioManager.startTime)
					{
						if(typeof(updateData.score) !== 'undefined')
						{
							ScoreManager.friendScoreBar.style.height = (updateData.score / max_score * 100)+'%';
						}

						friend_score_tracked.shift();
					}
					else
					{
						break;
					}
				}while(friend_score_tracked.length)
			}
		}
	};

	scoreManagerObject.__defineSetter__('score', function(val)
	{
		if(arguments.callee.caller != null &&
			arguments.callee.caller.toString().indexOf('trackScore') > -1 &&
			Object.isFrozen(this) === false)
		{
			this._score = val;
		}
		else
		{
			this._score = 0;
		}
	});

	scoreManagerObject.__defineGetter__('score', function()
	{
		return scoreManagerObject._score;
	});

	return scoreManagerObject;
};

function numberWithDots(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
