<html>
<head>
	<title>An error occured!</title>
</head>
<body>
	<h1>An error occured on <a href="{{$url}}">{{$url}}</a></h1>
	<h3>Previous URL: <a href="{{$previousUrl}}">{{$previousUrl}}</a></h3>
	<h2>{{$exception->getCode()}} - {{$exception->getMessage()}}</h2>
	<h4>User: {{Sentinel::getUser()->id}}</h4>
	<strong>File:</strong> {{$exception->getFile()}} / L: {{$exception->getLine()}}<br />

	<hr />

	{{$exception->getTraceAsString()}}

	<hr />

	<h3>Previous exception: {{$exception->getPrevious() != null ? $exception->getPrevious()->getMessage() : 'none'}}
</body>
</html>