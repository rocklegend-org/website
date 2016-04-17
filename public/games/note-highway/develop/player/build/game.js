/*! rocklegend note-highway 06-02-2016 */

function keyDownHandler(a){var b=RL.keyCodeToIndex(a.keyCode);HighwayManager.startHitDetection(b),5>=b&&(HighwayManager.aButtons[b].frame=5*b-4)}function keyHoldHandler(a){var b=RL.keyCodeToIndex(a.keyCode);HighwayManager.continueHitDetection(b,a.duration)}function keyUpHandler(a){var b=RL.keyCodeToIndex(a.keyCode);HighwayManager.endHitDetection(b),5>=b&&(HighwayManager.aButtons[b].frame=5*b-5)}function touchDownHandler(a,b){a.frame=5*a.lane-4,a.isPressed=!0,a.started=game.time.now,HighwayManager.startHitDetection(a.lane)}function touchUpHandler(a,b){a.frame=5*a.lane-5,a.isPressed=!1,a.started=!1,HighwayManager.endHitDetection(a.lane)}function numberWithDots(a){return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".")}function settingsSaved(a){$("#player-settings-form .success").fadeIn(),setTimeout(function(){$("#player-settings-form .success").fadeOut()},2e3)}var RL={States:{},sounds:{},hittableNotes:[!1,!1,!1,!1,!1,!1],pressedButtons:[!1,!1,!1,!1,!1,!1],rectangleContainer:!1,playAdded:!1,instantRestart:!1,typing:!1,inputFields:$("input, textarea"),posXLanes:{},laneButtonX:{},init:function(a){if(this.instantRestart="undefined"==typeof a?!1:a,this.hitPosition=this.config.height-this.config.buttonY,this.editMode=this.isEditMode(),this.playerHeightOnePercent=this.config.height/100,this.config.pxPerMs=this.config.pxPerSecond/1e3,this.negPxPerMs=-this.config.pxPerMs,this.maxHitY=RL.config.buttonY+RL.config.buttonHeight,this.minHitY=RL.config.buttonY-RL.config.noteHeight/1.25,this.halfNoteHeight=this.config.noteHeight/2,restart=!1,null!=game?(RL.instantRestart||rl.darkenPage(!1),RL.music.pos(0),RL.music.stop(),RL.music=new Howl({src:[soundFiles[0],soundFiles[1]],preload:!0,onend:function(){ScoreManager.ended()}}),AudioManager.startTime=0,this.hittableNotes=[!1,!1,!1,!1,!1,!1],this.pressedButtons=[!1,!1,!1,!1,!1,!1],$(".counter-overlay").transition({opacity:1}),clearInterval(HighwayManager.counterInterval),noteContainer.destroy(!0),$(".counter-overlay .count").hide().html(this.config.countSeconds),$(".counter-overlay .info").fadeIn(),restart=!0):(AudioManager=new RL.AudioManager,InteractionManager=new this.InteractionManager),HighwayManager=new this.HighwayManager,HighwayManager.aNotes=aNotes,HighwayManager.sortNotes(),ScoreManager=new this.ScoreManager,restart)return void game.state.start("Play");var b=Phaser.AUTO;switch(this.config.displayMode){case"AUTO":b=Phaser.AUTO;break;case"WEBGL":b=Phaser.WEBGL;break;case"CANVAS":b=Phaser.CANVAS}game=new Phaser.Game(this.config.width,this.config.height,b,"main-canvas",null,!1,!0,null),game.state.add("Boot",this.States.Boot),game.state.add("Play",this.States.Play),game.state.start("Boot")},showLoadingScreen:function(){$(".large-player-loading-overlay").fadeOut(),$(".loading-overlay").show(),this.loadingStep="-=360deg",this.loadingAnimation=setInterval(function(){$(".loading-overlay img").css({transformOrigin:"11px 10px"}).transition({rotate:RL.loadingStep,duration:850}),this.loadingStep="-=360deg"==RL.loadingStep?"+=360deg":"-=360deg"},1010)},hideLoadingScreen:function(){$(".loading-overlay").fadeOut(),clearInterval(this.loadingAnimation)},showInfoScreen:function(){$(".counter-overlay").fadeIn()},hideInfoScreen:function(){$(".counter-overlay").fadeOut()},getPosXForLane:function(a){return this.posXLanes[a]?this.posXLanes[a]:(this.posXLanes[a]=RL.config.width/6*a,this.posXLanes[a])},getXForLaneButton:function(a){return this.laneButtonX[a]?this.laneButtonX[a]:(this.laneButtonX[a]=RL.config.width/6*a-RL.config.noteWidth/2,this.laneButtonX[a])},getYForTime:function(a){return a*RL.negPxPerMs+RL.config.noteHeightDifferenceToButton},getTimeForY:function(a){return(a-RL.config.noteHeightDifferenceToButton)/RL.negPxPerMs},addPlay:function(){$.post("/play/add/"+track_id)},toggleSettings:function(){"block"==$(".settings-overlay").css("display")?$(".settings-overlay").fadeOut():$(".settings-overlay").fadeIn()},sortNotesArray:function(){for(var a=1;a<aNotes.length;a++){lane=aNotes[a];for(var b=0;b<lane.length;b++)lane[b].ms=lane[b].ms;lane.sort(RL.dynamicSort("ms"))}},keyCodeToIndex:function(a){switch(a){case RL.config.buttonKeys[0]:return 0;case RL.config.buttonKeys[1]:return 1;case RL.config.buttonKeys[2]:return 2;case RL.config.buttonKeys[3]:return 3;case RL.config.buttonKeys[4]:return 4;case RL.config.buttonKeys[5]:return 5;case RL.config.buttonKeys[6]:return 6;case RL.config.buttonKeys[7]:return 7;case RL.config.buttonKeysAlt[0]:return 0;case RL.config.buttonKeysAlt[1]:return 1;case RL.config.buttonKeysAlt[2]:return 2;case RL.config.buttonKeysAlt[3]:return 3;case RL.config.buttonKeysAlt[4]:return 4;case RL.config.buttonKeysAlt[5]:return 5;case RL.config.buttonKeysAlt[6]:return 6;case RL.config.buttonKeysAlt[7]:return 7;default:return-1}},isEditMode:function(){return"undefined"!=typeof edit_mode&&edit_mode!==!1?!0:!1},dynamicSort:function(a){var b=1;return"-"===a[0]&&(b=-1,a=a.substr(1)),function(c,d){var e=c[a]<d[a]?-1:c[a]>d[a]?1:0;return e*b}},compare:function(a,b){return parseFloat(a.time)<parseFloat(b.time)?-1:parseFloat(a.time)>parseFloat(b.time)?1:0},str_pad:function(a,b,c,d){var e,f="",g=function(a,b){for(var c="";c.length<b;)c+=a;return c=c.substr(0,b)};return a+="",c=void 0!==c?c:" ","STR_PAD_LEFT"!==d&&"STR_PAD_RIGHT"!==d&&"STR_PAD_BOTH"!==d&&(d="STR_PAD_RIGHT"),(e=b-a.length)>0&&("STR_PAD_LEFT"===d?a=g(c,e)+a:"STR_PAD_RIGHT"===d?a+=g(c,e):"STR_PAD_BOTH"===d&&(f=g(c,Math.ceil(e/2)),a=f+a+f,a=a.substr(0,b))),a}};RL.config={log:!0,mobile:!1,editor:!1,countSeconds:3,width:$("#main-canvas").width(),height:$("#main-canvas").height(),disableVisibilityChange:!0,smoothSprites:!1,stageBackgroundColor:2894892,loaderWidth:40,loaderHeight:40,squeaks:1,musicPlaybackRate:1,gridLineWidth:2,lanes:5,laneColors:[null,13708111,13943808,8967936,48099,8468473],buttonWidth:39.5,buttonHeight:45,buttonY:$("#main-canvas").height()-80,buttonKeys:[null,49,50,51,52,53,13,16],noteWidth:35,noteHeight:35,sustainedWidth:11.5,noteHeightDifferenceToButton:8,pxPerSecond:250,longNoteThreshold:75,hitDetectThreshold:50,startKey:32,restartKey:82,seekBackwardKey:37,seekForwardKey:39,speedUpKey:38,speedDownKey:40,deleteKey:46,newLineKey:187,mode:"tap",maxNotes:35,showBurst:!0,burstCount:8,animateHitLanes:!1,displayMode:"AUTO",enableCheering:!0,cheeringVolume:.5},jQuery.extend(RL.config,user_config),RL.InteractionManager=function(){return{playing:!1,aKeyboardEvents:[],keyboardPresses:[0,0,0,0,0,0],strumDuration:[0,0,0,0,0,0],restartLastHit:0,initialized:!1,init:function(){var a=this;this.initialized=!0,game.input.touch.preventDefault=!1;var b=game.input.keyboard.addKey(32);b.onDown.add(this.togglePlayback,this),$(".counter-overlay").unbind().on("click",function(b){b.preventDefault(),"I"!=b.target.nodeName&&"A"!=b.target.nodeName&&"SPAN"!=b.target.nodeName&&(a.playing||$("input, textarea").is(":focus")||(a.playing=!0,HighwayManager.countIn(!0)))}),$("#change-playmode").unbind().on("click",function(a){a.preventDefault(),RL.config.mode="strum"==RL.config.mode?"tap":"strum",$(".var-mode").text(RL.config.mode),$(".var-mode-alt").text("strum"==RL.config.mode?"tap":"strum"),RL.init()})},togglePlayback:function(){this.playing||$("input, textarea").is(":focus")||(this.playing=!0,HighwayManager.countIn(!0))},restart:function(){if(!RL.typing&&!RL.inputFields.is(":focus")){var a=(new Date).getTime();0===InteractionManager.restartLastHit||a-InteractionManager.restartLastHit>700?InteractionManager.restartLastHit=a:(InteractionManager.restartLastHit=0,this.playing=!0,RL.init(!0))}}}},RL.AudioManager=function(){return{startTime:0,initialized:!1,duration:0,ended:!1,init:function(){this.initialized=!0,this.duration=RL.music._duration,this.onePercent=10*this.duration},getPosition:function(){return 1e3*RL.music.seek()},play:function(){RL.music.play(),this.startTime=game.time.now},pause:function(){RL.music.pause()},stop:function(){RL.music.stop(),this.startTime=0}}},RL.HighwayManager=function(){return{aButtons:[!1],aLanes:[!1],emitter:[!1],aNoteObjects:[],secondsOnScreen:RL.config.height/RL.config.pxPerSecond,topSecondsDistance:RL.config.buttonY/RL.config.pxPerSecond,animateNoteDistanceInterval:!1,progressBar:document.getElementById("progress-bar"),sortNotes:function(){for(var a=[],b=1;b<=RL.config.lanes;b++){laneNotes=this.aNotes[b];for(var c=0;c<laneNotes.length;c++)if(duration=laneNotes[c].duration,"undefined"!=typeof laneNotes[c].time?t=laneNotes[c].time:"undefined"!=typeof laneNotes[c].start?(t=1e3*laneNotes[c].start,duration=1e3*laneNotes[c].duration):t=laneNotes[c].ms,null!==t){var d={time:t,duration:duration,lane:b,cb:"undefined"!=typeof laneNotes[c].cb?laneNotes[c].cb:!1,hitcb:"undefined"!=typeof laneNotes[c].hitcb?laneNotes[c].hitcb:!1,hopo:laneNotes[c].hopo&&"undefined"!=typeof laneNotes[c].hopo?laneNotes[c].hopo:!1};a.push(d)}else this.aNotes[b].splice(c,1)}a.sort(RL.compare),this.aNotes=a},drawNotes:function(a){var a="undefined"!=typeof a?a:!0;a&&noteContainer.removeAll(!0),RL.config.maxNotes=this.aNotes.length+1e3;for(var b=0;b<this.aNotes.length;b++){noteObject=this.aNotes[b];var c=new RL.Note(game,{time:noteObject.time,lane:noteObject.lane,duration:noteObject.duration,cb:"undefined"!=typeof noteObject.cb?noteObject.cb:!1,hitcb:"undefined"!=typeof noteObject.hitcb?noteObject.hitcb:!1,hopo:noteObject.hopo&&"undefined"!=typeof noteObject.hopo?noteObject.hopo:!1});noteContainer.add(c)}},updateNotes:function(a){a=$.map(a,function(a,b){return[a]});for(var b=1;b<a.length;b++){laneNotes=a[b];for(var c=0;c<laneNotes.length;c++)currNote=laneNotes[c].updateY()}},animateNoteDistance:function(a){HighwayManager.animateNoteDistanceInterval&&clearInterval(HighwayManager.animateNoteDistanceInterval),HighwayManager.animateNoteDistanceFrom=RL.config.pxPerSecond,RL.config.pxPerSecond=a,HighwayManager.updateNotes(HighwayManager.aNotes),RL.editMode&&($("#slider-pxPerSecond").slider("value",RL.config.pxPerSecond),$("span#pxPerSecond").html(RL.config.pxPerSecond))},countIn:function(a){ga("send","event","Song","play","0"),HighwayManager.counterOverlay=$(".counter-overlay"),HighwayManager.counterOverlay.css({opacity:0}).show(),HighwayManager.counterOverlay.transition({opacity:.5}),HighwayManager.counterOverlay.find(".info").hide(),HighwayManager.counterOverlay.find(".count").show(),this.counter={start:(new Date).getTime(),count:RL.config.countSeconds},$(".counter-overlay .count").html(this.counter.count),RL.music.stop(),this.counterInterval=setInterval(function(){HighwayManager.counter.count--,RL.sounds.drumstick.play(),2==HighwayManager.counter.count&&rl.darkenPage(!0),HighwayManager.counter.count<=0?(RL.sounds.drumstick.stop(),$(".counter-overlay").hide(),clearInterval(HighwayManager.counterInterval),$(".reloadSong").fadeIn(),AudioManager.play()):$(".counter-overlay .count").html(HighwayManager.counter.count)},1e3)},instantStart:function(){this.countIn()},drawGrid:function(){grid=game.add.image(0,0,"spritesheet",35),grid.alpha=.5,grid.scaleY=2},drawProgressbar:function(a){this.progressBar.style.height=a+"px"},createButtons:function(){for(var a=1;5>=a;a++){var b=game.add.sprite(RL.getPosXForLane(a)-RL.config.buttonWidth/2,RL.config.buttonY,"spritesheet",5*a-5);a>RL.config.lanes&&(b.alpha=.25),this.aButtons.push(b),b.lane=a,b.z=5,"undefined"!=typeof mobile&&mobile&&(b.inputEnabled=!0,b.events.onInputDown.add(touchDownHandler),b.events.onInputUp.add(touchUpHandler),b.update=function(){this.isPressed&&HighwayManager.continueHitDetection(this.lane,game.time.now-this.started)});var c=game.input.keyboard.addKey(RL.config.buttonKeys[a]);if(c.onDown.add(keyDownHandler,this),c.onUp.add(keyUpHandler,this),c.onHoldCallback=keyHoldHandler,InteractionManager.aKeyboardEvents.push(c),RL.config.buttonKeysAlt[a]!=RL.config.buttonKeys[a]){var c=game.input.keyboard.addKey(RL.config.buttonKeysAlt[a]);c.onDown.add(keyDownHandler,this),c.onUp.add(keyUpHandler,this),c.onHoldCallback=keyHoldHandler,InteractionManager.aKeyboardEvents.push(c)}}if("strum"==RL.config.mode){var c=game.input.keyboard.addKey(RL.config.buttonKeys[6]);c.onDown.add(keyDownHandler,this),c.onUp.add(keyUpHandler,this),c.onHoldCallback=keyHoldHandler,InteractionManager.aKeyboardEvents.push(c);var c=game.input.keyboard.addKey(RL.config.buttonKeys[7]);c.onDown.add(keyDownHandler,this),c.onUp.add(keyUpHandler,this),c.onHoldCallback=keyHoldHandler,InteractionManager.aKeyboardEvents.push(c)}var c=game.input.keyboard.addKey(RL.config.restartKey);c.onUp.add(InteractionManager.restart,this),InteractionManager.aKeyboardEvents.push(c),game.input.keyboard.clearCaptures()},particleBurst:function(a,b){!RL.config.showBurst||"undefined"!=typeof mobile&&0!=mobile||((0==b||"undefined"==typeof b)&&this.emitter[a].setAllChildren("renderable",!1),this.emitter[a].explode(1e3,RL.config.burstCount))},startHitDetection:function(a){if("strum"==RL.config.mode)if(6==a||7==a){for(var b=0,c=1;5>=c;c++)RL.hittableNotes[c]&&RL.pressedButtons[c]&&!RL.hittableNotes[c].hit?(this.hitNote(RL.hittableNotes[c],c),b++):RL.hittableNotes[c]&&c==a?(ScoreManager.reset(),b=-1):RL.pressedButtons[c]&&!RL.hittableNotes[c].hit&&b>0&&ScoreManager.reset();if(0>=b){ScoreManager.reset();for(var c=1;5>=c;c++)0!=InteractionManager.keyboardPresses[c]&&InteractionManager.keyboardPresses[c].endTap()}}else RL.pressedButtons[a]=!0,RL.hittableNotes[a]&&RL.hittableNotes[a].hopo&&ScoreManager.streak>0&&!RL.hittableNotes[a].hit&&this.hitNote(RL.hittableNotes[a],a);else"tap"==RL.config.mode&&(RL.hittableNotes[a]?(InteractionManager.keyboardPresses[a]=RL.hittableNotes[a],InteractionManager.keyboardPresses[a].burst(),ScoreManager.notes_hit++):ScoreManager.reset())},hitNote:function(a,b){InteractionManager.strumDuration[b]={start:(new Date).getTime(),duration:0},InteractionManager.keyboardPresses[b]=a,InteractionManager.keyboardPresses[b].renderable=!1,InteractionManager.keyboardPresses[b].burst(),ScoreManager.sustainedCache[b]=0,ScoreManager.notes_hit++},continueHitDetection:function(a,b){0!==InteractionManager.keyboardPresses[a]&&("strum"==RL.config.mode&&6!=a&&7!=a?0==InteractionManager.keyboardPresses[a].alive?InteractionManager.keyboardPresses[a]=0:(b=(new Date).getTime()-InteractionManager.strumDuration[a].start,InteractionManager.keyboardPresses[a].burstLong(b,game.time.now-AudioManager.startTime)):"tap"==RL.config.mode&&InteractionManager.keyboardPresses[a].burstLong(b,game.time.now-AudioManager.startTime))},endHitDetection:function(a){0!==InteractionManager.keyboardPresses[a]&&"undefined"!=typeof InteractionManager.keyboardPresses[a]&&(InteractionManager.keyboardPresses[a].endTap(),InteractionManager.keyboardPresses[a]=0),"strum"==RL.config.mode&&6!=a&&7!=a?RL.pressedButtons[a]=!1:"tap"==RL.config.mode&&ScoreManager.resetSustainedCache(a)}}},RL.ScoreManager=function(){var a={_score:0,score:0,multiplier:1,streak:0,max_streak:0,max_multiplier:0,notes_hit:0,notes_missed:0,percent:0,prev_streak:0,prev_multiplier:0,prev_score:0,score_highest:0,score_user_highest:0,score_friend_highest:0,score_bar_percent:0,score_bar_current_element:0,sustainedCache:[0,0,0,0,0,0],cheeringStreak:[25,50,100,150,200,300,400,500],singleNotePoints:50,friendScoreInterval:!1,scoreTracking:[{t:0,str:0,score:0,multiplier:1}],$score:document.getElementById("score-num"),$streak:document.getElementById("streak-num"),$multiplier:document.getElementById("multiplier-num"),friendScoreBar:document.getElementById("bar-score-friend"),init:function(){if(this.$score.innerHTML="0",this.$streak.innerHTML="0",this.$multiplier.innerHTML="x1",max_user_score>0){this.score_highest=max_score;var a=max_user_score/max_score*100;$(".bar-user-highscore").css("height",a+"%").show()}if(max_friend_score>0){var b=max_friend_score/max_score*100;$(".bar-friend-score").css("height",b+"%").show()}if(friend_score_tracked){var b=0;$(".bar-friend-score").css("height",b+"%").show()}this.score_bar_current_element=document.getElementById("bar-score-current"),this.score_bar_current_element.style.height="0%",this.score_bar_current_element.style.display="block",$(".repeat-song").unbind().on("click",function(a){a.preventDefault(),ga("send","event","Song","repeat","1"),$(".score-overlay").fadeOut(),ScoreManager.animateFinishBack(".score-points-wrap",0),ScoreManager.animateFinishBack(".score-streak-wrap",1),ScoreManager.animateFinishBack(".score-multiplier-wrap",0),RL.init()}),$(".share-score").unbind().on("click",function(a){ga("send","event","Share","facebook - share score","score",ScoreManager.score),FB.ui({method:"feed",caption:"Can you beat my score?",name:share_title,description:"I just scored "+numberWithDots(ScoreManager.score)+' points on "'+song_name+'" by '+artist_name+"! A max streak of "+numberWithDots(ScoreManager.max_streak)+", "+numberWithDots(ScoreManager.notes_hit)+" notes hit and a completion of "+ScoreManager.percent+"%. #thisisrocklegend",link:share_url,picture:thumbnail_url})})},ended:function(){if(!RL.editMode)if(AudioManager.ended=!0,AudioManager.stop(),ga("send","event","Song","play","1"),$(".reloadSong").fadeOut(),testMode||Object.isFrozen(ScoreManager)!==!1)ScoreManager.showScoreScreen();else{var a=[{t:0,str:0,score:0,multiplier:1}],b=0;$.each(ScoreManager.scoreTracking,function(c,d){d.t<b&&(a=[{t:0,str:0,score:0,multiplier:1}]),(d.t>=a[a.length-1].t+500||c>=a.length-1)&&a.push(d),b=d.t});var c=lzw_encode(JSON.stringify({data:a}));$.post("/play/score/"+track_id+"/save",{score:ScoreManager.score,max_streak:ScoreManager.max_streak,max_multiplier:ScoreManager.max_multiplier,notes_missed:ScoreManager.notes_missed,notes_hit:ScoreManager.notes_hit,ts:c,mode:RL.config.mode,devMode:!1,_token:csrf},function(a){a.badge&&rl.badge.showBadgeInfo(parseInt(a.badge)),ScoreManager.showScoreScreen(a)})}},showScoreScreen:function(a){$(".score-overlay").fadeIn();var b=notes_count,c=(ScoreManager.notes_hit/b*100).toFixed(2);ScoreManager.percent=c,ga("send","event","Score","new","points",ScoreManager.score),ga("send","event","Score","new","percentage",ScoreManager.percent),ga("send","event","Score","new","max streak",ScoreManager.max_streak),ScoreManager.animateFinish(".score-points-wrap",2,function(){}),setTimeout(function(){ScoreManager.animateFinish(".score-streak-wrap",1.5,function(){$(".score-streak-wrap h1").eq(2).not(".streak").html("Max Streak"),$(".score-streak-wrap h1.streak").eq(1).html(ScoreManager.max_streak)})},270),setTimeout(function(){ScoreManager.animateFinish(".score-multiplier-wrap",3.5,function(){$(".score-multiplier-wrap h1").eq(2).not(".multiplier").html("Percent"),$(".score-multiplier-wrap h1.multiplier").eq(1).html(c+"%")})},540),setTimeout(function(){$(".score-button-wrap").fadeIn()},1010),setTimeout(function(){rl.darkenPage(!1)},1500),RL.sounds.crowds[0].play(),scores.fetch()},animateFinish:function(a,b,c){var b="undefined"!=typeof b?b:0,d=$(a),e=d.clone();e.css({position:"absolute",top:d.offset().top-1,left:d.offset().left}).appendTo("body").transition({left:$(".score-overlay").offset().left+$(".score-overlay").width()/2-e.width()+20*b,duration:500},500,"ease-in-out"),d.fadeOut(0).css({display:"inline-block",visibility:"hidden"}),c()},animateFinishBack:function(a,b){var c=$(a).eq(0),d=$(a).eq(1);d.transition({left:c.offset().left-20*b,duration:500},500,"ease-in-out"),setTimeout(function(){d.fadeOut(200,function(){d.remove()}),c.css("visibility","visible").fadeOut(0).fadeIn(200)},500)},adjustScoreBox:function(){$(".scoreBox").css({position:"absolute",left:$("#main-canvas canvas").offset().left+RL.config.width,top:$("#main-canvas canvas").offset().top+60})},scoreSingleNote:function(){this.score+=this.singleNotePoints*this.multiplier,this.increaseStreak(),this.streak%10==0&&this.increaseMultiplier(),this.trackScore()},scoreSustainedNote:function(a,b,c){perc=Math.ceil(b/(a/100)/1e3*a*this.multiplier),this.score-=this.sustainedCache[c],this.sustainedCache[c]<=0&&(this.increaseStreak(),this.streak%10==0&&this.increaseMultiplier()),this.sustainedCache[c]=perc,this.score+=perc,this.trackScore()},resetSustainedCache:function(a){this.sustainedCache[a]=0},increaseMultiplier:function(){this.multiplier<=3&&(this.multiplier++,this.max_multiplier<this.multiplier&&(this.max_multiplier=this.multiplier))},increaseStreak:function(){this.streak++,this.max_streak<this.streak&&(this.max_streak=this.streak),RL.config.enableCheering&&this.cheeringStreak.indexOf(this.streak)>-1&&(rand=Math.floor(Math.random()*RL.sounds.crowds.length),RL.sounds.crowds[rand].play())},renderScore:function(){this.prev_streak!=this.streak&&(this.$streak.innerHTML=this.streak,this.prev_streak=this.streak),this.prev_multiplier!=this.multiplier&&(this.$multiplier.innerHTML="x"+this.multiplier,this.prev_multiplier=this.multiplier),this.prev_score!=this.score&&(this.$score.innerHTML=numberWithDots(this.score),this.prev_score=this.score,this.score_bar_current_element.style.height=this.score/max_score*100+"%"),friend_score_tracked&&this.renderFriendScore()},reset:function(){this.multiplier=1,this.streak=0,this.renderScore(),this.trackScore()},trackScore:function(){var a=this.scoreTracking[this.scoreTracking.length-1],b={},c=!1;a.score!=this.score&&(b.score=this.score,c=!0),a.mp!=this.multiplier&&(b.mp=this.multiplier,c=!0),a.str!=this.streak&&(b.str=this.streak,c=!0),c&&(b.t=game.time.now-AudioManager.startTime,this.scoreTracking.push(b))},renderFriendScore:function(){if(friend_score_tracked.length&&AudioManager.startTime>0)do{var a=friend_score_tracked[0];if(!(a.t<=game.time.now-AudioManager.startTime))break;"undefined"!=typeof a.score&&(ScoreManager.friendScoreBar.style.height=a.score/max_score*100+"%"),friend_score_tracked.shift()}while(friend_score_tracked.length)}};return a.__defineSetter__("score",function(a){null!=arguments.callee.caller&&arguments.callee.caller.toString().indexOf("trackScore")>-1&&Object.isFrozen(this)===!1?this._score=a:this._score=0}),a.__defineGetter__("score",function(){return a._score}),a},RL.States.Boot={musicLoaded:!1,preload:function(){var a=this;RL.showLoadingScreen(),game.load.crossOrigin="anonymous",game.load.baseURL=ASSETS_BASE_URL,game.load.atlasJSONHash("spritesheet","/assets/images/game/spritesheet-player.png?t="+(new Date).getTime(),"/assets/images/game/spritesheet.json?t="+(new Date).getTime()),game.load.audio("squeak",["/assets/sounds/game/squeak1.mp3","/assets/sounds/game/squeak1.ogg"]),game.load.audio("tick",["/assets/sounds/game/tick.mp3","/assets/sounds/game/tick.ogg"]),game.load.audio("drumstick",["/assets/sounds/game/drumstick_twice_one_second.mp3","/assets/sounds/game/drumstick_twice_one_second.ogg"]),game.load.audio("crowd1",["/assets/sounds/game/fans/small_crowd_40.mp3","/assets/sounds/game/fans/small_crowd_40.ogg"]),game.load.audio("crowd2",["/assets/sounds/game/fans/small_crowd_40_2.mp3","/assets/sounds/game/fans/small_crowd_40_2.ogg"]),game.load.audio("crowd3",["/assets/sounds/game/fans/medium_crowd.mp3","/assets/sounds/game/fans/medium_crowd.ogg"]),RL.music=new Howl({src:[soundFiles[0],soundFiles[1]],preload:!0,onload:function(){a.musicLoaded=!0},onend:function(){ScoreManager.ended()}}),mobile&&$(".button-overlay").remove()},update:function(){if(this.musicLoaded){$("#main-canvas canvas").css("visibility","visible"),RL.sounds.drumstick=game.add.sound("drumstick"),RL.sounds.drumstick.volume=.24,RL.sounds.squeaks=[game.add.sound("squeak1")],RL.sounds.crowds=[game.add.sound("crowd1"),game.add.sound("crowd2")];for(var a=0;a<RL.sounds.crowds.length;a++)RL.sounds.crowds[a].volume=RL.config.cheeringVolume;$(document).on("keydown",function(a){32!=a.which||$("input,textarea").is(":focus")||a.preventDefault()}),game.state.start("Play")}}},RL.States.Play={preload:function(){RL.config.calculations="clean",this.HighwayManager=HighwayManager},create:function(){mobile&&(game.input.addPointer(),game.input.addPointer(),game.input.addPointer()),game.scale.fullScreenScaleMode=Phaser.ScaleManager.EXACT_FIT,game.stage.disableVisibilityChange=!0,game.stage.backgroundColor=2894892,InteractionManager.initialized===!1&&InteractionManager.init(),HighwayManager.drawGrid(),HighwayManager.createButtons(),noteContainer=game.add.group(game,game.world,"noteContainer",!1),noteContainer.inputEnabled=!0,noteContainer.z=50,HighwayManager.drawNotes(!0),ScoreManager.init(),_emitters=HighwayManager.emitter,_emitterY=RL.config.buttonY+RL.config.buttonHeight/2;for(var a=1;5>=a;++a)_emitters.push(game.add.emitter(0,0,350)),_emitters[a].makeParticles(["spritesheet"],24+a),_emitters[a].gravity=400,_emitters[a].x=RL.getPosXForLane(a),_emitters[a].y=_emitterY;AudioManager.initialized||AudioManager.init(),$("canvas").on("contextmenu",function(a){a.preventDefault()}),RL.hideLoadingScreen(),RL.instantRestart?(RL.hideInfoScreen(),HighwayManager.instantStart(),RL.instantRestart=!1):RL.showInfoScreen()},update:function(){AudioManager.startTime&&(currentPlaybackTime=game.time.now-AudioManager.startTime,noteContainer.y=RL.config.buttonY+currentPlaybackTime*RL.config.pxPerMs,game.time.now%2==0&&(ScoreManager.renderScore(),HighwayManager.drawProgressbar(RL.playerHeightOnePercent*currentPlaybackTime/AudioManager.onePercent)))}},RL.Note=function(a,b){this.className="RL.Note",this.game=a,Phaser.Image.call(this,this.game,0,0,"spritesheet",0),this.initialize(b)},RL.Note.prototype=Object.create(Phaser.Image.prototype),RL.Note.prototype.constructor=RL.Note,RL.Note.prototype.create=function(){},RL.Note.prototype.initialize=function(a){this.y=RL.getYForTime(a.time),this.x=RL.getXForLaneButton(a.lane),this.enableBody=!1,this.lane=a.lane,this.time=parseFloat(a.time),this.originalTime=this.time,this.duration=parseFloat(a.duration),this.originalDuration=this.duration,this.endTime=this.time+this.duration,this.hopo=a.hopo,this.hopo&&"strum"==RL.config.mode?this.loadTexture("spritesheet",5*this.lane-1):this.loadTexture("spritesheet",5*this.lane-3),this.hit=!1,this.missed=!1,this.removed=!1,this.burstCounter=0,this.maxHitY=RL.maxHitY,this.minHitY=RL.minHitY,this.shortMaxHitY=this.maxHitY,this.negativeNoteHeight=-RL.config.noteHeight,this.duration>=RL.config.longNoteThreshold?this.drawRect():"undefined"!=typeof this.rect&&(this.rect.destroy(),this.rect=void 0),this.killMaxY=this.maxHitY+50,this.exists=!1,this.rectMinHeightToShow=this.negativeNoteHeight+RL.config.noteHeight},RL.Note.prototype.drawRect=function(a){"undefined"==typeof a&&(a=!1);var b=this.duration*RL.config.pxPerMs+RL.halfNoteHeight;if(rectangleY=this.y-b+RL.halfNoteHeight,"undefined"==typeof this.rect){var c=game.add.image(RL.getPosXForLane(this.lane)-11,rectangleY,"spritesheet",29+this.lane);c.scale.setTo(1,b/30),a===!1&&(c.exists=!1,c.alpha=.5),noteContainer.add(c),noteContainer.sendToBack(c),this.rect=c}else a&&(this.rect.alpha=1,this.rect.scale.setTo(1,b/30));this.rectHeight=b,this.maxHitY=RL.config.buttonY+RL.config.noteHeight+10+b,this.killMaxY=this.maxHitY+50},RL.Note.prototype.update=function(){realY=this.y+noteContainer.y,realY>this.shortMaxHitY?(realY>this.killMaxY&&this.kill(!0),0==this.missed&&(this.missed=!0,ScoreManager.notes_missed++,ScoreManager.reset())):(realY>this.negativeNoteHeight&&(this.exists=!0,"undefined"!=typeof this.rect&&realY>this.rectMinHeightToShow&&(this.rect.exists=!0)),this.time<=game.time.now-AudioManager.startTime+350&&(!this.removed&&realY>=this.minHitY&&realY<=this.shortMaxHitY?RL.hittableNotes[this.lane]=this:"undefined"!=typeof this.rect&&this.hit&&realY<=this.maxHitY?this.removed?RL.hittableNotes[this.lane]=!1:RL.hittableNotes[this.lane]=this:RL.hittableNotes[this.lane]==this&&(RL.hittableNotes[this.lane]=!1)))},RL.Note.prototype.burst=function(){RL.hittableNotes[this.lane]=!1,this.hit=!0,this.removed=!0,"undefined"==typeof this.rect&&(HighwayManager.particleBurst(this.lane,this.world.y),ScoreManager.scoreSingleNote(),this.kill())},RL.Note.prototype.burstLong=function(a,b){if(this.hit&&"undefined"!=typeof this.rect){if(this.duration=this.endTime-b,this.duration<=0||b>this.endTime||this.originalDuration<=a)return ScoreManager.scoreSustainedNote(this.originalDuration,a,this.lane),this.kill(!0),!1;this.time=game.time.now-AudioManager.startTime,this.y=RL.config.buttonY+RL.config.noteHeightDifferenceToButton-noteContainer.y,(0==this.burstCounter||this.burstCounter%4==0)&&(HighwayManager.particleBurst(this.lane,!0),ScoreManager.scoreSustainedNote(this.originalDuration,a,this.lane)),this.burstCounter%3==0&&this.drawRect(a),this.burstCounter++}},RL.Note.prototype.endTap=function(){this.hit&&this.kill()},RL.Note.prototype.kill=function(a){RL.hittableNotes[this.lane]=!1,InteractionManager.keyboardPresses[this.lane]=0,"undefined"!=typeof this.rect&&this.rect.destroy(!0),this.destroy(!0)};var game=null;jQuery(function(a){max_sparkles_slider=a("#slider--max-sparkles").slider({value:RL.config.burstCount,range:"min",min:1,max:99,step:1,slide:function(b,c){a("#slider-value--max-sparkles").html(c.value),a('input[name="player_burst_count"]').val(c.value),RL.config.burstCount=c.value}}),cheering_volume_slider=a("#slider--cheering-volume").slider({value:RL.config.cheeringVolume,range:"min",min:0,max:1,step:.1,slide:function(b,c){a("#slider-value--cheering-volume").html(c.value),a('input[name="player_cheering_volume"]').val(c.value),RL.config.cheeringVolume=c.value}}),a('input[name="player_enable_cheering"]').on("change",function(b){a('input[name="player_enable_cheering"]:checked').length>0?RL.config.enableCheering=1:RL.config.enableCheering=0}),a('#player-settings-form input[type="button"]').on("click",function(a){a.preventDefault(),RL.toggleSettings(),RL.init()}),a('select[name="player_display_mode"]').on("change",function(b){b.preventDefault(),RL.config.displayMode=a('select[name="player_display_mode"] option:selected').val()}),a(".settings-button a").on("click",function(a){a.preventDefault(),RL.toggleSettings()}),a(".settings-overlay .fa-stack").on("click",function(a){RL.toggleSettings()})}),Number.prototype.roundTo=function(a){var b=this%a;return a/2>=b?this-b:this+a-b};var waitForFinalEvent=function(){var a={};return function(b,c,d){d||(d="Don't call this twice without a uniqueId"),a[d]&&clearTimeout(a[d]),a[d]=setTimeout(b,c)}}();