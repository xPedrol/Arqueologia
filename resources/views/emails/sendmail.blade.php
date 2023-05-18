<!DOCTYPE html>
<html lang="pt">
<head>
    <title>AllPHPTricks.com</title>
</head>
<body>
@if(isset($title))
    <h2>{{$title}}</h2>
@endif
<p>{!! $body !!}</p>
</body>
</html>
