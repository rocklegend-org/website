/** game stuff **/
var game = null;

jQuery(function($) {
    /** SETTINGS **/
    max_sparkles_slider = $('#slider--max-sparkles').slider({
      value: RL.config.burstCount,
      range: "min",
      min: 1,
      max: 99,
      step: 1,
      slide: function(event, ui){
        $('#slider-value--max-sparkles').html(ui.value);
        $('input[name="player_burst_count"]').val(ui.value);
        RL.config.burstCount = ui.value;
      }
    });

    cheering_volume_slider = $('#slider--cheering-volume').slider({
      value: RL.config.cheeringVolume,
      range: "min",
      min: 0.0,
      max: 1,
      step: 0.1,
      slide: function(event, ui){
        $('#slider-value--cheering-volume').html(ui.value);
        $('input[name="player_cheering_volume"]').val(ui.value);
        RL.config.cheeringVolume = ui.value;
      }
    });

    $('input[name="player_enable_cheering"]').on('change', function(e){
      if($('input[name="player_enable_cheering"]:checked').length > 0){
        RL.config.enableCheering = 1;
      }else{
        RL.config.enableCheering = 0;
      }
    });

    $('#player-settings-form input[type="button"]').on('click', function(e){
      e.preventDefault();

      RL.toggleSettings();

      RL.init();
    });

    $('select[name="player_display_mode"]').on('change', function(e){
      e.preventDefault();
      RL.config.displayMode = $('select[name="player_display_mode"] option:selected').val();
    });

    $('.settings-button a').on('click', function(e){
        e.preventDefault();

        RL.toggleSettings();
    });
    $('.settings-overlay .fa-stack').on('click', function(e){
      RL.toggleSettings();
    });
});

function settingsSaved(response){
  $('#player-settings-form .success').fadeIn();

  setTimeout(function(){
    $('#player-settings-form .success').fadeOut();
  }, 2000);
}

/***/

Number.prototype.roundTo = function(num) {
    var resto = this%num;
    if (resto <= (num/2)) {
        return this-resto;
    } else {
        return this+num-resto;
    }
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

/*!
 devtools-detect
 Detect if DevTools is open
 https://github.com/sindresorhus/devtools-detect
 by Sindre Sorhus
 MIT License
 *
(function () {
    var devtools = {open: false};
    var threshold = 160;
    var emitEvent = function (state) {
        if(state)
        {
          if(typeof(ScoreManager) != 'undefined' && Object.isFrozen(ScoreManager) === false)
          {
            ScoreManager.init();

            Object.freeze(ScoreManager);
          }
        }
    };

    var checkDevtoolsOpen = function(){
       if ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || window.outerWidth - window.innerWidth > threshold ||
            window.outerHeight - window.innerHeight > threshold) {
            emitEvent(true);
            devtools.open = true;
        } else {
            emitEvent(false);
            devtools.open = false;
        }
    }

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = devtools;
    } else {
        window.devtools = devtools;
    }

    var checkDevToolsInterval = setInterval(checkDevtoolsOpen, 2500);
})();*/
