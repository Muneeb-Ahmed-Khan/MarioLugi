<!DOCTYPE html>
<html>
<head>
	<title>{{config('app.name')}}</title>
</head>
<body>
    @foreach($user as $u)
    <h4>From : {{ $u->email }}</h4>
    <h4>Subject : {{ $u->subject }}</h4>
    <p>{{ $u->content }}</p>
    @endforeach
</body>
</html>