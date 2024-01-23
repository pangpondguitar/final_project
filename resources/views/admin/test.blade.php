<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    @if($data)
    <h1>{{ $data->user_d_name }}</h1>
    @else
    <p>Data not found</p>
    @endif
</body>

</html>
