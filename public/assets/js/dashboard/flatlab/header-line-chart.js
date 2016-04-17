(function() {
  var data1, data2, dataSet, date, getData, num, options, showTooltip, today, update;

  today = 1381416681600;

  data1 = (function() {
    var _i, _results;
    _results = [];
    for (num = _i = 1; _i <= 50; num = ++_i) {
      date = today + 86400 * num * 1000;
      _results.push([date, Math.floor(Math.random() * 100)]);
    }
    return _results;
  })();

  data2 = (function() {
    var _i, _results;
    _results = [];
    for (num = _i = 1; _i <= 50; num = ++_i) {
      date = today + 86400 * num * 1000;
      _results.push([date, Math.floor(Math.random() * 100)]);
    }
    return _results;
  })();

  getData = function() {
    data1.shift();
    data1.push([data1[data1.length - 1][0] + 86400 * 1000, Math.floor(Math.random() * 100)]);
    data2.shift();
    return data2.push([data2[data2.length - 1][0] + 86400 * 1000, Math.floor(Math.random() * 100)]);
  };

  dataSet = [
    {
      label: 'New Visitors',
      data: data1
    }, {
      label: 'Returning Visitors',
      data: data2
    }
  ];

  update = function() {
    console.log('update');
    getData();
    $.plot($("#flot-placeholder"), dataSet, options);
    return setTimeout(update, 500);
  };

  options = {
    series: {
      stack: false,
      lines: {
        lineWidth: 1,
        show: true,
        fill: true,
        steps: false
      },
      points: {
        radous: 1,
        show: true
      }
    },
    legend: {
      backgroundOpacity: 0.35
    },
    grid: {
      hoverable: false,
      borderWidth: 0,
      backgroundColor: {
        colors: ["#ffffff", "#ffffff"]
      }
    },
    shadowSize: 1,
    xaxis: {
      mode: "time",
      timeformat: "%Y/%m/%d"
    }
  };

  console.dir(options);

  $.fn.UsetTooltip = function() {
    $(this).bind('plothover', function(event, pos, item) {});
    if (item) {
      console.dir(arguments);
    }
  };

  $.fn.UseToop = function() {
    return $(this).bind("plothover", function(event, pos, item) {
      var color, content, x, y;
      if (item) {
        if ($(this).data('previousPoint') !== item.dataIndex || $(this).data('previousLabel') !== item.series.label) {
          $(this).data('previousPoint', item.dataIndex);
          $(this).data('previousLabel', item.series.label);
          $(".tooltip").remove();
          x = item.datapoint[0];
          y = item.datapoint[1];
          color = item.series.color;
          content = "<strong>" + item.series.label + "</strong><br/>\n<strong>" + x + "</strong>\n<strong>" + y + "</strong>";
          return showTooltip(item.pageX, item.pageY, color, content);
        }
      }
    });
  };

  showTooltip = function(x, y, color, contents) {
    var tooltip;
    console.log('showTooltip:' + contents);
    tooltip = $('<div class="tooltip">' + contents + '</div>');
    tooltip.css({
      'background-color': "#ffffff",
      position: 'absolute',
      display: 'none',
      top: y - 10,
      left: x + 10,
      border: '1px solid ' + color,
      padding: '5px',
      'font-size': '10px',
      'border-radius': '2px',
      'background-color': '#fff',
      'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
      opacity: 0.9
    });
    tooltip.appendTo('body');
    tooltip.fadeIn('fast');
    console.log($(".tooltip").size());
    return console.log("RUN");
  };

  $(function() {
    $.plot($("#flot-placeholder"), dataSet, options);
    $("#flot-placeholder").UseToop();
    return update();
  });

}).call(this);
