window.playerPage = {
	init: function(){
		$.post('/track/notes.json', { id: track_id, _token: csrf }, function(data){
			aNotes = base64_decode(data.notes);

			aNotes = JSON.parse(aNotes);

			// migration code
			if(aNotes.length <= 5){
				aNotes.splice(0, 0, [false]);
			}

			RL.showLoadingScreen();
			RL.init();
		});

		$('.js-nscroll').nscroll({
			parent: '.js-nscroll-parent',
			offsetY: -100,
			speed: 250
		});
	}
}
