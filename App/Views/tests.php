
<!DOCTYPE html>
<html>
<head>
    <title>Moby Framework</title>
</head>
<body>
    <h1>Moby Framework</h1>
    {{ $teste }}
    
    <br><br>
    
    @if ($teste)@
        <div>{{ $teste }}</div>    
    @endif
    
    <br><br>
    
    @foreach ($array as $a)@
        <div>{{ $a }}</div>    
    @endforeach
</body>
</html>