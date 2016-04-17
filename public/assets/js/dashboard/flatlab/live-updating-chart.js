	$(document).ready(function() {
	
		/*** Visitor Chart1 ***/	
	var data = [{
	"key": "Long",
	"values": getData()
	}];
	var chart;

	nv.addGraph(function () {
	chart = nv.models.lineChart();

	chart.xAxis
	.tickFormat(function (d) {
	return d3.time.format('%x')(new Date(d))
	});

	chart.yAxis
	.tickFormat(d3.format(',.1%'));

	d3.select('#chart svg')
	.datum(data)
	.transition().duration(500)
	.call(chart);

	nv.utils.windowResize(chart.update);

	return chart;
	});


	function redraw() {
	d3.select('#chart svg')
	.datum(data)
	.transition().duration(500)
	.call(chart);
	}

	function getData() {
	var arr = [];
	var theDate = new Date(2012, 01, 01, 0, 0, 0, 0);
	for (var x = 0; x < 30; x++) {
	arr.push({x: new Date(theDate.getTime()), y: Math.random() * 100});
	theDate.setDate(theDate.getDate() + 1);
	}
	return arr;
	}

	setInterval(function () {
	var long = data[0].values;
	var next = new Date(long[long.length - 1].x);
	next.setDate(next.getDate() + 1)
	long.shift();
	long.push({x:next.getTime(), y:Math.random() * 100});
	redraw();
	}, 1500);	
});