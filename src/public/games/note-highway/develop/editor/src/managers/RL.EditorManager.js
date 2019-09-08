/**
 * This contains all needed functions
 * for the Rocklegend Track Editor
 *
 * @module this
 */

RL.EditorManager = function(){
return {
	aTaps: [[],[],[],[],[],[]],
	aMsTapped: [[],[],[],[],[],[]],
	aSelectedNotes: [],
	aPreviousSelection: [],
	aCopiedNotes: [],
	selectedNote: false,
	positionSlider : false,
	playbackRateSlider: false,
	pxPerSecondSlider: false,
	auto_save: RL.config.auto_save, // in seconds
	auto_save_interval: RL.config.auto_save_interval, // in seconds
	auto_save_js_interval: null,

	notesChanged: 0,

	playTicks: false,

	advancedMode: false,

	beatsInitialized: false,
	beatLineContainer: false,
	aBeatLines: 0,
	beatLinesHeight: 0,

	beatLineTextContainer: false,

	timeSignature: [4,4],
	secondsPerMeasure: 0,
	gridSecondsPerNote: 0,

	grid: 0.25,
	grid_snap: false,
	grid_snap_sustained: false,

	dragging: false,

	newLine: function(){
		newTime = AudioManager.getPosition() + this.secondsPerNote;
		
		if(newTime < 0) newTime = 0;

		AudioManager.setPosition(newTime);
	},

	init: function(){
		this.beatLineContainer = game.add.group(game, game.world, "beatLineContainer", true, false);
		this.beatLineContainer.z = 100;

		this.beatLineTextContainer = game.add.group(game, game.world, "beatLineTextContainer", true, false);
		this.beatLineTextContainer.z = 50;

		// auto_save
		if(this.auto_save){
			this.toggleAutoSave();
		}

		tval = this.auto_save_interval + ' seconds';
		if(this.auto_save_interval >= 60){
			tval = parseFloat(this.auto_save_interval/60).toFixed(1)+' minutes';
		}
		jQuery('#auto-save-interval').html(tval);

		if(typeof(RL.config.fetchNotes) != 'undefined' && RL.config.fetchNotes){
			this.getNotesForTrack();
		}

		EditorInteractionManager.init();	
	},

	deleteBeatLines: function()
	{
		this.beatLineContainer.removeAll();
		this.beatLineTextContainer.removeAll();
		this.aBeatLines = 0;
	},

	drawBeatLines: function(force){
		var grid = this.grid;
		var pxPerSecond = RL.config.pxPerSecond;
		var neededLines = AudioManager.duration/1000 / grid;

		var line = new Phaser.Graphics(game, 0, 0);

		// reset beatlines and draw them from scratch
		if(force || this.aBeatLines < neededLines){
			this.deleteBeatLines();

			for(var i = this.aBeatLines; i <= neededLines; i+=grid){
				y = -Math.round(i*pxPerSecond);

				line.lineStyle(1, 0XFFFFFF, i % 1 == 0 ? 1 : 0.35);
				line.moveTo(0, y);
				line.lineTo(RL.config.width, y);

				line.time = parseFloat(i);

				this.aBeatLines++;

				time = parseFloat(i).toFixed(3);
				timeText = time;

				if(time >= 60){
					seconds = i;
					minutes = parseInt(seconds / 60);
					seconds = parseFloat(seconds - (minutes*60)).toFixed(3);
					timeText = minutes+':'+seconds;
				}

				text = game.add.text(4, y-12, timeText, {
					fill: '#ffffff',
					fontSize: 10,
					font: 'Roboto'
				}, this.beatLineTextContainer);

				text.alpha = i % 1 == 0 ? 1 : 0.35;
				text.exists = false;
				text.time = time*1000;

				text.update = function(){
					if(this.time > AudioManager.currentTime + RL.msOnScreen ||
	                    this.time < AudioManager.currentTime - 250)
	                {
	                    this.exists = false;
	                }
	                else
	                {
	                    this.exists = true;
	                }
				}
			}			

			this.beatLineContainer.add(line);
			this.beatLinesHeight = Math.round(i*pxPerSecond);
			this.beatLinesTime = i;
		}

		

		/*this.beatLineContainer.forEach(function(e){
			if(typeof(e) != 'undefined'){
				// if y !== false, we have to move this object to y
				y = false;
				switch(e.type){
					case 3: // graphics
					 	currentY = e.currentPath.shape.points[1];
						pos = currentY + this.beatLineContainer.y;
						if(pos >= RL.config.height){
							y = currentY - this.beatLinesHeight;
						}else if(pos < RL.config.height - this.beatLinesHeight){
							y = currentY + this.beatLinesHeight;
						}

						if(y !== false){
							e.destroy();

							time = parseFloat(y / -RL.config.pxPerSecond).toFixed(1);

							var line = new Phaser.Graphics(game, 0, 0);
							line.lineStyle(1, 0XFFFFFF, time % 1 == 0 ? 1 : 0.35);
							
							line.moveTo(0,y);
							line.lineTo(RL.config.width, y);

							this.beatLineContainer.add(line);
						}
					break;
					case 4: // text
						if(e.y+12 + this.beatLineContainer.y >= RL.config.height){
							y = e.y + 12 - this.beatLinesHeight;
						}else if(e.y+12 + this.beatLineContainer.y < RL.config.height - this.beatLinesHeight){
							y = e.y + 12 + this.beatLinesHeight;
						}

						if(y !== false){	
							time = parseFloat(y/ -RL.config.pxPerSecond).toFixed(3);
							e.destroy();					    	

							text = game.add.text(4,y-12, time, {}, this.beatLineContainer);

							text.fill = '#ffffff';
							text.alpha = parseFloat(time).toFixed(1) % 1 == 0 ? 1 : 0.35;
							text.fontSize = 10;
							text.font = 'Roboto';
							text.z = 100;
						}
					break;
				}
			}
		}, this);*/
	},

	/**
	 * addTap(lane, time)
	 * This function gets called when editor is active and trackTaps is activated.
	 * It adds an Note Object (see note.js) to the aNotes array with the current time
	 *
	 * @method addTap
	 * @param {Int} lane The line on which the note should be added
	 * @param {Int} time The current time
	 * @return {RL.Note} Returns the generated note
	 */
	 addTap: function(lane, time, hopo){
		if(	this.beatsInitialized && 
			this.grid_snap){
			time = this.calculateBPMTime(time);
		}
			
		// make sure that no other note exists at this time on this lane
		if(jQuery.inArray(time, this.aMsTapped[lane]) <= -1){
			var note = new RL.Note(game, {
				time: time,
				lane: lane,
				hopo: hopo
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[lane].push(note);

			note.initEditorFunctions();

			return note;
		}
	},

	calculateBPMTime: function(t){
		snap = this.secondsPerBeat * ( this.timeSignature[0] / this.grid_snap_bottom ) * 1000;
		return t.roundTo(snap);
	},

	holdTap: function(lane, duration, time, hopo){
		aNotes = HighwayManager.aNotes[lane];

		if(	this.beatsInitialized && 
			this.grid_snap){
			time = this.calculateBPMTime(time);
		}
		
		if(duration > RL.config.longNoteThreshold){
			noteIndex = aNotes.length-1;

			time = HighwayManager.aNotes[lane][noteIndex].time;
			HighwayManager.aNotes[lane][noteIndex].kill(true);
			HighwayManager.aNotes[lane].splice(noteIndex, 1);

			var note = new RL.Note(game, {
				time: time,
				lane: lane,
				duration: duration,
				hopo: hopo,
				showRect: true
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[lane].push(note);

			note.initEditorFunctions();
		}
	},

	/**
	* Handles the keyUp event for the this.
	*
	* @method finishTap
	* @param {Int} lane The lane
	* @param {Int} duration
	* @param {Int} time
	*
	*/
	finishTap: function(lane, duration, time){
		aNotes = HighwayManager.aNotes[lane];
		noteIndex = aNotes.length-1;
		
		if(typeof(HighwayManager.aNotes[lane][noteIndex].rect) != 'undefined')
		{
			HighwayManager.aNotes[lane][noteIndex].rect.alpha = 0.5;
		}
	},

	/**
	* Handles note selection.
	*
	* Clicking on notes makes them selected.
	* Multiselection by pressing shift key is possible
	*
	* @method onNoteDown
	* @param {RL.Note} note The clicked note
	* @param {Event} e The event object
	*/
	onNoteDown: function(note, e, multiSelection){
		var multiSelection = typeof(multiSelection) != 'undefined' ? multiSelection : false;

		EditorManager.selectedNote = true;

		/** check if shiftkey is pressed **/
		if(game.input.keyboard.event != null){
			var shiftKey = game.input.keyboard.event.shiftKey;
		}else{
			shiftKey = false;
		}

		/** if shiftkey is not pressed we start a new selection **/
		if(!multiSelection && !shiftKey && !note.isSelected){
			EditorManager.resetSelectedNotes();
		}

		/** if the pressed note is not selected, we select it.
		 *  otherwise, we remove it from the selected notes array 
		 *  
		 *  we don't want to reset everything because this way it's possible
		 *  to easily correct a multi-selection
		 */
		if(!note.isSelected){
			note.isSelected = true;
			note.setDefaultTexture();

			EditorManager.aSelectedNotes.push(note);
		}else{

			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				if(EditorManager.aSelectedNotes[i] == note){
					note.isSelected = false;

					EditorManager.aSelectedNotes.splice(i,1);
				}
			}
			note.setDefaultTexture();

		}

		EditorManager.updateNoteInfo();
		EditorManager.aPreviousSelection = EditorManager.aSelectedNotes.slice();
	},

	/**
	* Resets the this.aSelectedNotes array to start a new selection
	*
	* @method resetSelectedNotes
	* @param {Event} e The event object
	*/
	resetSelectedNotes: function(e){
		for(var i = 0; i < this.aSelectedNotes.length; i++){
			this.aSelectedNotes[i].isSelected = false;
			this.aSelectedNotes[i].setDefaultTexture();
		}

		this.aSelectedNotes = [];

		EditorManager.updateNoteInfo();
	},

	activatePreviousSelection: function(e){
		EditorManager.resetSelectedNotes();

		for(var i = 0; i < EditorManager.aPreviousSelection.length; i++){
			EditorManager.onNoteDown(EditorManager.aPreviousSelection[i], null, true);
		}
	},

	/**
	* This function resets this.selectedNote to false
	* Needed for dragging of notecontainer, so we know that the user has not currently
	* selected a note für die mouseDown event
	*
	* @method onNoteUp
	* @param {RL.Note} note The note
	* @param {Event} e The event object
	**/
	onNoteUp: function(note, e){
		var duration = e.timeUp - e.timeDown;
		if(duration >= 200){
			// empty selected notes array
			EditorManager.aSelectedNotes = [];

			// populate selected notes array with notes which have the "selected" frame
			// hacky but it works
			for(var i = 0; i < HighwayManager.aNotes.length; i++){
				var laneNotes = HighwayManager.aNotes[i];
				for(var n = 0; n < laneNotes.length; n++){
					if(laneNotes[n].isSelected){
						laneNotes[n].isSelected = false;
						EditorManager.onNoteDown(laneNotes[n], e, true);
					}
				}
			}
		}
		else
		{
			note.setDefaultTexture();
		}
	},

	/** 
	* Updates the information shown next to the player about
	* the currently selected notes 
	*
	* @method updateNoteInfo
	*/
	updateNoteInfo: function()
	{
		selectedNotes = EditorManager.aSelectedNotes;

		durations = [];
		times = [];
		lanes = [];
		hopos = [];

		durationDifferent = false;
		timeDifferent = false;
		laneDifferent = false;
		hoposDifferent = false;
		nonFalse = 0;

		for(var i = 0; i < selectedNotes.length; i++){
			durations.push(selectedNotes[i].duration);
			times.push(selectedNotes[i].time);
			lanes.push(selectedNotes[i].lane);
			hopos.push(selectedNotes[i].hopo);
			if(selectedNotes[i]){
				nonFalse++;
			}
		}

		if(!durations.AllValuesSame()){
			durationDifferent = true;
		}
		
		if(!times.AllValuesSame()){
			timeDifferent = true;
		}
		
		if(!lanes.AllValuesSame()){
			laneDifferent = true;
		}
		
		if(!hopos.AllValuesSame()){
			hoposDifferent = true;
		}

		$('.var-sel-count').text(nonFalse);

		if(selectedNotes.length <= 0){

			$('#sel-note-time').attr('readonly',true).val("-");
			$('#sel-note-duration').attr('readonly',true).val("-");
			$('#sel-note-lane').attr('readonly',true).val("-");
			$('#sel-note-hopo').attr('readonly',true).prop('checked', false);

			$('#copy-selected, #paste-copied').hide();

		}else{
			$('#copy-selected').show();

			$('#sel-note-time').attr('readonly',false).val(timeDifferent ? '' : selectedNotes[0].time);
			$('#sel-note-duration').attr('readonly',false).val(durationDifferent ? '' : selectedNotes[0].duration);
			$('#sel-note-lane').attr('readonly',false).val(laneDifferent ? '' : selectedNotes[0].lane);

			if(hoposDifferent){
				$('#sel-note-hopo').attr('readonly',false).prop('checked',false);	
			}else{
				if(selectedNotes[0].hopo){
					$('#sel-note-hopo').attr('readonly',false).prop('checked', true);
				}else{
					$('#sel-note-hopo').attr('readonly',false).prop('checked', false);
				}
			}

		}
	},

	copyNotes: function(e){
		EditorManager.aCopyNotes = [];

		for(var n = 0; n < EditorManager.aSelectedNotes.length; n++)
		{
			if(EditorManager.aSelectedNotes[n]){
				EditorManager.aCopyNotes.push(
					EditorManager.aSelectedNotes[n]
				);
			}
		}

		$('#copy-info').html(EditorManager.aCopyNotes.length+' notes copied');
		$('#paste-copied').show();
	},

	pasteNotes: function(e){
		var currentPlaybackPosition = AudioManager.getPosition();

		EditorManager.resetSelectedNotes();

		minTime = false;
		for(var n = 0; n < EditorManager.aCopyNotes.length; n++)
		{
			if(minTime === false || EditorManager.aCopyNotes[n].time < minTime){
				minTime = EditorManager.aCopyNotes[n].time;
			}
		}

		for(var n = 0; n < EditorManager.aCopyNotes.length; n++)
		{

			var newTime = EditorManager.aCopyNotes[n].time - minTime + currentPlaybackPosition;

			var note = new RL.Note(game, {
				time: newTime,
				lane: EditorManager.aCopyNotes[n].lane,
				duration: EditorManager.aCopyNotes[n].duration,
				hopo: EditorManager.aCopyNotes[n].hopo
			});

			note.exists = true;

			noteContainer.add(note);

			HighwayManager.aNotes[EditorManager.aCopyNotes[n].lane].push(note);

			note.initEditorFunctions();

			EditorManager.onNoteDown(note, null, true);
		}
		
		// save previous selection
		EditorManager.aPreviousSelection = EditorManager.aSelectedNotes.slice();

		EditorManager.aCopyNotes = [];

		$('#copy-info').html('no notes copied');
	},

	/**
	* Deletes notes from this.aSelectedNotes array from the aNotes array
	* and calls their burst methods
	*
	* Sorts aNotes array after each note deletion to ensure noteIndex data is correct
	*
	* Triggers this.resetSelectedNotes afterwards to start a new selection
	*
	* @method deleteNotes
	* @param {Event} e The event object
	**/
	deleteNotes: function(e){
		if(e.event.target.sourceElement != 'input'){
			for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
				var note = EditorManager.aSelectedNotes[i];

				var lane = EditorManager.aSelectedNotes[i].lane;

				/** Delete note from used ms array 
				 *  so we can put another note here again 
				 **/
				 if(typeof(note.time) != 'undefined'){
					time = note.time;
					var index = EditorManager.aMsTapped[lane].indexOf(time);
					ele = EditorManager.aMsTapped[lane].splice(index, 1);
				 }

				 note = HighwayManager.aNotes[lane].splice(
				 			HighwayManager.aNotes[lane].indexOf(note),
				 			1
				 		);
				 note = note[0];

				 note.kill(true);
				}

				EditorManager.resetSelectedNotes();
			}
		},

	/**
	* Sets the current frame of the dragged note to 1
	*
	* @method onNoteDragStart
	* @param {RL.Note} The note
	* @param {Event} e
	**/
	onNoteDragStart: function(note, e){
		note.originalLane = note.lane;
		note.rlDrag = true;
		EditorManager.dragging = true;

		for(var i = 0; i < EditorManager.aSelectedNotes.length; i++){
			if(EditorManager.aSelectedNotes[i] && !EditorManager.aSelectedNotes[i].input.isDragged){
				EditorManager.aSelectedNotes[i].input.startDrag(game.input.activePointer);
			}
		}
	},

	/**
	* Updates the dragged note according to its new position
	*
	* @method onNoteDragStop
	* @param {RL.Note} note
	* @param {Event} e
	**/
	onNoteDragStop: function(note, e){
		var notesArray = HighwayManager.aNotes;
		var editor = this;
		EditorManager.dragging = false;
		
		// extract note from its currently set lane
		noteObject = notesArray[note.originalLane].splice(
						notesArray[note.originalLane].indexOf(note), 1
					);
		noteObject = noteObject[0];

		// get lane for the notes new x position
		lane = noteObject.setLaneForX(note.x) - 1;

		// insert the note on its new corresponding lane array
		noteIndex = notesArray[noteObject.lane].push(noteObject) - 1;
		note = noteObject;

		// calculate new time for current y position
		time = RL.getTimeForY(note.y);

		// if advanced editor is active and grid snapping is activated 
		// the notes y position should snap to the grid
		if(	EditorManager.beatsInitialized &&
			EditorManager.grid_snap)
		{
			snap = EditorManager.secondsPerNote*1000;

			time = time.roundTo(snap);
		}

		note.time = time;
		note.y = RL.getYForTime(time);

		/** MOVE CORRESPONDING SUSTAINED RECTANGLE! **/
		if(typeof note.rect !== 'undefined'){
			note.drawRect();
		}
	},

	moveAllByMs: function(ms)
	{
		for(var lane = 1; lane < HighwayManager.aNotes.length; lane++){
			laneNotes = HighwayManager.aNotes[lane];

			for(var i = 0; i < laneNotes.length; i++){
				n = laneNotes[i];
				n.time = parseFloat(n.time) + parseFloat(ms);
				n.y = RL.getYForTime(parseFloat(n.time));
				n.drawRect();

				EditorManager.notesChanged++;
			}
		}
	},

	save: function(){
		EditorManager.finish(null, true, true);
	},

	finish: function(e, auto_save, manual){
		if(typeof(auto_save) === 'undefined') auto_save = false;
		if(typeof(manual) === 'undefined') manual = false;

		var sendNotes = [];
		var noteCount = 0;

		notes = $.map(HighwayManager.aNotes, function(value, index){
			return [value];
		});

		for(var l = 0; l < notes.length; l++){
			aIndex = sendNotes.push([]) - 1;
			lane = notes[l];

			for(var i = 0; i < lane.length; i++){
				sendNotes[aIndex].push({
					time: lane[i].time,
					duration: lane[i].duration,
					//cb: lane[i].cb,
					//hitcb: lane[i].hitcb,
					hopo: lane[i].hopo
				});

				length = sendNotes[aIndex].length-1;
			}

			noteCount += sendNotes[aIndex].length;
		}
		
		if(noteCount < 5){
			if(!auto_save || manual)
				jQuery('#modal-errorMinimumNotes').foundation('reveal', 'open');
		}else{
			var notes = JSON.stringify(sendNotes);
			if($('select[name="status"] option:selected').val() == '2'){
				$('select[name="status"]').attr('disabled', true);
			}
			jQuery.post(
				'/create/editor/'+song_slug+'/'+$('select[name="difficulty"]').val()+(track_id ? '/'+track_id : ''), 
				{ 
					name: $('#track-name').val(), 
					status: $('select[name="status"]').val(),
					difficulty: $('select[name="difficulty"]').val(),
					notes: notes, 
					lanes: $('select[name="lanes"]').val(),
					song_id: song_id, 
					track_id: track_id, 
					px_per_second: RL.config.pxPerSecond, 
					auto_save: auto_save,
					_token: csrf
				},
				function(data){
					if(typeof(data.error) != 'undefined'){
						alert('An error occured! We didn\'t save the track. We added debug data to a box on the bottom of the page. Please copy and post it to a thread in the forums. We also disable autosave if it\’s currently active.');

						$('#error-debug textarea').html('Track ID: '+track_id+'\r\n'+notes);

						$('#error-debug').fadeIn();

						if(auto_save){
							EditorManager.toggleAutoSave();
						}

					}else{
						if(!auto_save){
							location.href = '/create/review/'+song_slug+'/'+data.track_id;
						}else if(!track_id){
							document.location.hash = data.track_id;
							track_id = data.track_id;
						}

						$('.stats-notecount').html(data.note_count);
						$('select[name="status"] option[value="'+data.status+'"]').attr('selected', true);
					}
				}
				);

			var date = new Date();
			var time = RL.str_pad(date.getHours(),2,'0','STR_PAD_LEFT')+':'+RL.str_pad(date.getMinutes(), 2, '0', 'STR_PAD_LEFT')+':'+RL.str_pad(date.getSeconds(),2,'0','STR_PAD_LEFT');
			
			if(auto_save && !manual){
				jQuery('#auto-save-info').html('<b>Last Auto-Save:</b> '+time).show();

				setTimeout(function(){
					jQuery('#auto-save-info').hide();
				}, 3000);
			}else if(manual){
				jQuery('#manual-save-info').html('<b>Last Manual-Save:</b> '+time).show();

				setTimeout(function(){
				jQuery('#manual-save-info').hide();
				}, 3000);
			}
		}
	},

	toggleTracking: function(){
		RL.config.trackTaps ? RL.config.trackTaps = false : RL.config.trackTaps = true;
		document.getElementById('trackingCB').checked = (RL.config.trackTaps) ? "checked" : "";
	},

	getNotesForTrack: function(){
		jQuery.post('/tools/getTrackById/'+track_id, 
			{ _token: csrf },
			function(data){
				HighwayManager.aNotes = data;
				HighwayManager.drawNotes();
			}
		);
	},

	toggleAutoSave: function(e, reset){
		if(typeof(reset) == 'undefined') reset = false;

		if(!reset){
			if(EditorManager.auto_save_js_interval != null){
				clearInterval(EditorManager.auto_save_js_interval);
				EditorManager.auto_save_js_interval = null;
				jQuery('#auto-save-container').fadeOut();
			}else{
				EditorManager.auto_save_js_interval = setInterval(function(){
					EditorManager.finish(null, true);
				}, EditorManager.auto_save_interval*1000);
				jQuery('#auto-save-container').fadeIn();
			}
		}else{
			EditorManager.auto_save_js_interval = null;
			EditorManager.auto_save_js_interval = setInterval(function(){
				EditorManager.finish(null, true);
			}, EditorManager.auto_save_interval*1000);
		}
	},

	print: function(o){
	    var str='';

	    for(var p in o){
	        if(typeof o[p] == 'string'){
	            str+= p + ': ' + o[p]+';';
	        }else{
	            str+= p + ': {' + EditorManager.print(o[p]) + '}';
	        }
	    }

	    return str;
	}
}
};