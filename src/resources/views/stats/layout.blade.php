<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>rocklegend stats</title>

	<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
	{!! HTML::style('assets/css/frontend/main.css') !!}

	<style type="text/css">
		body{
			margin: 15px;
			border: none;
		}

		a.active{
			text-decoration: underline;
			font-weight: bold;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			$('a.delete-btn').on('click', function(e){
				e.preventDefault();

				if(confirm('Are you sure you want to delete this comment?')){
					location.href = $(this).attr('href');
				}
			});
		});
	</script>

	@yield('head-includes', '')
</head>
<body>
	<a href="/admin-stats" class="btn bg-green">Stats Home</a> 
	<a href="/admin-stats?page=trackplaycount" class="btn bg-blue">Track Play Count</a> 
	<a href="/admin-stats?page=users" class="btn bg-violet">Users</a> 
	<a href="/admin-stats?page=analytics" class="btn bg-black">Analytics</a>
	<a href="javascript:location.reload();" class="btn bg-red">refresh</a>
	<br />
	<br />
	<h1>Rocklegend Stats</h1>&nbsp;<small>(<?php echo time(); ?>)</small>
	<br />
	@yield('content')
</body>
</html>