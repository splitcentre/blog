<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div>
        <h4>Add Comic</h4>
        <form method="post" action="{{route('comics.store')}}">
            @csrf
            <div>Name <input type="text" name="comic_name"></div>
            <div>Harga <input type="text" name="comic_price"></div>
            <div><button type="submit">Save</button></div>
            <a href="/comics">Cancel</a>
        </form>
    </div>
</body>
</html>