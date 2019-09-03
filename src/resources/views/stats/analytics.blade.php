@extends('stats.layout')

@section('head-includes')
{!! HTML::style('assets/app/assets/css/main.css') !!}
{!! HTML::style('assets/app/assets/css/auth.css') !!}
{!! HTML::style('assets/app/assets/css/datachart.css') !!}
@stop

@section('content')
<!-- Step 1: Create the containing elements. -->
<h2 class="bg-black">Google Analytics Data</h2>
<section id="auth-button"></section>

<div class="analytics-container">
<section><strong>Active Users:</strong>&nbsp;&nbsp;<span class="Realtime-value" id="active-users">0</span>&nbsp;<small>(updates automatically)</section>

  <section class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">This Week vs Last Week (Sessions)</h3>
    <div id="chart1"></div>
    <ol class="Legend" id="legend1"></ol>
  </section>

  <div class="clear"></div>

  <section class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">This Year vs Last Year (Sessions)</h3>
    <div id="chart2"></div>
    <ol class="Legend" id="legend2"></ol>
  </section>

  <section class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">Top Countries</h3>
    <div id="countries"></div>
    <ol class="Legend" id="countriesLegend"></ol>
  </section>

  <section class="Component Chart Chart--chartjs">
    <h3 class="Chart-title">Top Browsers</h3>
    <div id="chart3"></div>
    <ol class="Legend" id="legend3"></ol>
  </section>
</main>

<!-- This code snippet loads the Embed API. Do not modify! -->
<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>

{!! HTML::script('assets/app/assets/js/promise.js') !!}
{!! HTML::script('assets/app/components/datepicker.js') !!}
{!! HTML::script('assets/app/assets/js/chart.js') !!}
{!! HTML::script('assets/app/assets/js/moment.js') !!}
{!! HTML::script('assets/app/components/active-users.js') !!}

<script>
gapi.analytics.ready(function() {
  /**
   * Authorize this user.
   */
  gapi.analytics.auth.authorize({
    container: 'auth-button',
    clientid: '655220529585-2b2rliij50cfbr8153b7g2r46k2cqh4k.apps.googleusercontent.com',
  });

  /**
   * Add a callback to add the `is-authorized` class to the body
   * as soon as authorization is successful. This is used to help
   * style components.
   */
  gapi.analytics.auth.on('success', function() {
    document.body.classList.add('is-authorized');
  });


  /**
   * Create a new ActiveUsers instance to be rendered inside of an
   * element with the id "active-users" and poll for changes every
   * five seconds.
   */
  var activeUsers = new gapi.analytics.ext.ActiveUsers({
    container: 'active-users',
    pollingInterval: 5
  });

  data = { query: { ids: 'ga:82156421' } };

  activeUsers.set(data.query).execute();
  drawWeek(data.query.ids);
  drawYear(data.query.ids);
  drawBrowserStats(data.query.ids);
  drawCountries(data.query.ids);
});

/**
 * Execute a Google Analytics Core Reporting API query
 * and return a promise.
 * @param {Object} params The request parameters.
 * @return {Promise} A promise.
 */
function query(params) {
  return new Promise(function(resolve, reject) {
    var data = new gapi.analytics.report.Data({query: params});
    data.once('success', function(response) { resolve(response); })
        .once('error', function(response) { reject(response); })
        .execute();
  });
}

/**
 * Create a new canvas inside the specified element. Optionally control
 * how tall/wide it is. Any existing elements in will be destroyed.
 * @param {string} id The id attribute of the element to create the canvas in.
 * @param {number} opt_width The width of the canvas. Defaults to 500.
 * @param {number} opt_height The height of the canvas. Defaults to 300.
 * @return {RenderingContext} The 2D canvas context.
 */
function makeCanvas(id, opt_width, opt_height) {
  var container = document.getElementById(id);
  container.innerHTML = '';
  var canvas = document.createElement('canvas');
  var ctx = canvas.getContext('2d');
  canvas.width = 350;
  canvas.height = 300;
  container.appendChild(canvas);
  return ctx;
}

/**
 * Create a visual legend inside the specified element.
 * @param {string} id The id attribute of the element to create the legend in.
 * @param {Array.<Object>} items A list of labels and colors for the legend.
 */
function setLegend(id, items) {
  var legend = document.getElementById(id);
  legend.innerHTML = items.map(function(item) {
    return '<li><i style="background:' + item.color + '"></i>' +
        item.label + '</li>';
  }).join('');
}

/**
 * Draw the a chart.js line chart with data from the specified view that
 * overlays session data for the current week over session data for the
 * previous week.
 */
function drawWeek(ids) {

  // Adjust `now` to experiment with different days, for testing only...
  var now = moment() // .subtract('day', 2);

  var thisWeek = query({
    'ids': ids,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:sessions',
    'start-date': moment(now).subtract('day', 1).day(0).format('YYYY-MM-DD'),
    'end-date': moment(now).format('YYYY-MM-DD')
  });

  var lastWeek = query({
    'ids': ids,
    'dimensions': 'ga:date,ga:nthDay',
    'metrics': 'ga:sessions',
    'start-date': moment(now).subtract('day', 1).day(0).subtract('week', 1)
        .format('YYYY-MM-DD'),
    'end-date': moment(now).subtract('day', 1).day(6).subtract('week', 1)
        .format('YYYY-MM-DD')
  });

  Promise.all([thisWeek, lastWeek]).then(function(results) {

    var data1 = results[0].rows.map(function(row) { return +row[2]; });
    var data2 = results[1].rows.map(function(row) { return +row[2]; });
    var labels = results[1].rows.map(function(row) { return +row[0]; });

    labels = labels.map(function(label) {
      return moment(label, 'YYYYMMDD').format('ddd');
    });

    var data = {
      labels : labels,
      datasets : [
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          pointColor : "rgba(220,220,220,1)",
          pointStrokeColor : "#fff",
          data : data2
        },
        {
          fillColor : "rgba(151,187,205,0.5)",
          strokeColor : "rgba(151,187,205,1)",
          pointColor : "rgba(151,187,205,1)",
          pointStrokeColor : "#fff",
          data : data1
        }
      ]
    };

    new Chart(makeCanvas('chart1')).Line(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend1', [
      {
        color: 'rgba(151,187,205,1)',
        label: 'This Week'
      },
      {
        color: 'rgba(220,220,220,1)',
        label: 'Last Week'
      }
    ]);
  });
}

/**
 * Draw the a chart.js bar chart with data from the specified view that overlays
 * session data for the current year over session data for the previous year,
 * grouped by month.
 */
function drawYear(ids) {

  var thisYear = query({
    'ids': ids,
    'dimensions': 'ga:month,ga:nthMonth',
    'metrics': 'ga:sessions',
    'start-date': moment().date(1).month(0).format('YYYY-MM-DD'),
    'end-date': moment().date(1).subtract('day',1).format('YYYY-MM-DD')
  });

  var lastYear = query({
    'ids': ids,
    'dimensions': 'ga:month,ga:nthMonth',
    'metrics': 'ga:sessions',
    'start-date': moment().subtract('year',1).date(1).month(0).format('YYYY-MM-DD'),
    'end-date': moment().date(1).month(0).subtract('day',1).format('YYYY-MM-DD'),
  });

  Promise.all([thisYear, lastYear]).then(function(results) {
    var data1 = results[0].rows.map(function(row) { return +row[2]; });
    var data2 = results[1].rows.map(function(row) { return +row[2]; });
    var labels = ['Jan','Feb','Mar','Apr','May','Jun',
                  'Jul','Aug','Sep','Oct','Nov','Dec'];

    var data = {
      labels : labels,
      datasets : [
        {
          fillColor : "rgba(151,187,205,0.5)",
          strokeColor : "rgba(151,187,205,1)",
          data : data1
        },
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          data : data2
        }
      ]
    };

    new Chart(makeCanvas('chart2')).Bar(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend2', [
      {
        color: 'rgba(151,187,205,1)',
        label: 'This Year'
      },
      {
        color: 'rgba(220,220,220,1)',
        label: 'Last Year'
      }
    ]);

  });
}

/**
 * Draw the a chart.js doughnut chart with data from the specified view that
 * show the top 5 browsers over the past seven days.
 */
function drawBrowserStats(ids) {

  query({
    'ids': ids,
    'dimensions': 'ga:browser',
    'metrics': 'ga:sessions',
    'sort': '-ga:sessions',
    'max-results': 5
  })
  .then(function(response) {

    var data = [];
    var colors = ['#F7464A','#E2EAE9','#D4CCC5','#949FB1','#4D5360'].reverse();

    response.rows.forEach(function(row, i) {
      data.push({ value: +row[1], color: colors[i], label: row[0] });
    });

    new Chart(makeCanvas('chart3')).Doughnut(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('legend3', data);
  });
}
/*
function drawCountries(ids) {

  query({
    'ids': ids,
    'dimensions': 'ga:country',
    'metrics': 'ga:sessions',
    'sort': '-ga:sessions',
    'max-results': 5
  })
  .then(function(response) {

    var data = [];
    var colors = ['#F7464A','#E2EAE9','#D4CCC5','#949FB1','#4D5360'].reverse();

    response.rows.forEach(function(row, i) {
      data.push({ value: +row[1], color: colors[i], label: row[0] });
    });

    new Chart(makeCanvas('countries')).Doughnut(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('countriesLegend', data);
  });
}*/

function drawCountries(ids) {

 query({
    'ids': ids,
    'dimensions': 'ga:country',
    'metrics': 'ga:sessions',
    'sort': '-ga:sessions',
    'max-results': 10,
    'start-date': moment().date(1).month(0).format('YYYY-MM-DD'),
    'end-date': moment().format('YYYY-MM-DD')
  })
  .then(function(response) {
    var vals = [];
    var labels = [];

    response.rows.forEach(function(row, i){
    	vals.push(+row[1]);
    	labels.push(row[0]);
    });

    var data = {
    	labels: labels,
    	datasets: [ {
	        fillColor : "rgba(151,187,205,0.5)",
	        strokeColor : "rgba(151,187,205,1)",
    		data: vals 
    	} ]
    }

    new Chart(makeCanvas('countries')).Bar(data, {
      animationSteps: 60,
      animationEasing: 'easeInOutQuart'
    });

    setLegend('countriesLegend', [
      {
        color: 'rgba(151,187,205,1)',
        label: 'Country'
      }
    ]);

  });
}

</script>
</div>
@stop