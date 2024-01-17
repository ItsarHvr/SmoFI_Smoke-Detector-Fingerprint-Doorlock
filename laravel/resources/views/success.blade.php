<!DOCTYPE html>
<html>
<head>
    <title>Success Page</title>
</head>
<body>
    @if(session('id'))
        <div style="margin-top: 10px;">
            {{ session('id') }}
        </div>
    @endif
</body>
</html>
