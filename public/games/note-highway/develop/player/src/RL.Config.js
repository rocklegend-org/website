RL.config = {
	log: true, // enable/disable log

	mobile: false,
	editor: false,

	countSeconds: 3,

	// Canvas
	width: $('#main-canvas').width(),
	height: $('#main-canvas').height(),

	disableVisibilityChange: true,
	smoothSprites: false,
	stageBackgroundColor: 0X2C2C2C, //canvas background color

	// Loader
	loaderWidth: 40,
	loaderHeight: 40,

	// Sounds
	squeaks: 1, // amount of squeak sounds available
	musicPlaybackRate: 1.0,

	// Grid
	gridLineWidth: 2, // thickness of main grid lines
	lanes: 5, //number of note lines (move this to a difficulty config later)
	laneColors: [	// colors of the lanes
				   null, // just a filler, so the lanes numbering is correct
	               0XD12B4F,
	               0XD4C400,
	               0X88D700,
	               0X00BBE3,
	               0X8137F9
	],

	// Buttons	
	buttonWidth: 39.5,
	buttonHeight: 45,

	buttonY: $('#main-canvas').height()-80, //the vertical position of the buttons
	
	buttonKeys: [
				null,
	            49, //1
	            50, //2
	            51, //3
	            52, //4
	            53,  //5
	            13, // STRUM = ENTER
	            16, // STRUM = SHIFT
    ],

    // Notes
	noteWidth: 35,
	noteHeight: 35,
	sustainedWidth: 11.5,
	noteHeightDifferenceToButton: 8,

    // NoteHighway
    pxPerSecond: 250, // px : the amount of pixels the note highway scrolls down per second
    longNoteThreshold: 75, // ms : minimum difference between startTap and endTap for long notes    
    hitDetectThreshold: 50, // ms : the maximum difference between note ms and hit time to be detected as a hit


    // Performance Keys
    startKey: 32,
    restartKey: 82,

    // Editor Keys
    seekBackwardKey: 37,
    seekForwardKey:  39,

    speedUpKey: 38,
    speedDownKey: 40,

    deleteKey: 46,

    newLineKey: 187,

    mode: 'tap', // tap or strum
                 // 
    // performance
    maxNotes: 35,
    showBurst: true,
    burstCount: 8,
    animateHitLanes: false,
    displayMode: 'AUTO',
    enableCheering: true,
    cheeringVolume: 0.5
}

jQuery.extend(RL.config, user_config);