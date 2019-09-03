<html>
	<head>
		<title>track updated with status "review"</title>
		<style>
			@import url(http://fonts.googleapis.com/css?family=Roboto:300);

			body{
				font-family: Roboto, Arial, sans-serif;
				font-size: 14px;
				color: #2e2e2e;
			}

			p{
			}
		</style>
	</head>
	<body>
		<b>{{ $track->user->username }}</b> marked a track for review.</b><br />
		Song: <i>"{{ $track->song->title }}" by {{ $track->song->artist->name }}</i><br /><br />
		Note Count: {{ $track->getCount() }}<br />
		Difficulty: {{ $track->getDifficultyName() }}<br />
		<br />
		<a href="{{$url}}">Test - Play</a>
	</body>
</html>