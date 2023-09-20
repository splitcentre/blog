<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>judul komik</th>
                <th>harga</th>
            </tr>    
        <thead>
        <tbody>
            @foreach($data_comic as $comics)
                <tr>
                    <td>{{$comics->id_comic}}</td>
                    <td>{{$comics->comic_name}}</td>
                    <td>{{$comics->comic_price}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p align="right"><a href="{{route('comics.create')}}">Add Comic</a></p>
    <td>
        <form action="{{route('comics.destroy',$comics->id_comic)}}" method="post">
            @csrf
            <button  onClick="return confirm('are you sure)">Delete</button>
        </form>
    </td>
</body>
</html>
