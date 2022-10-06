<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <table>
        <tr>
            <th></th>
            @foreach ($movieList as $movie)
                <td>
                    <a href="/admin/movies/{{$movie->id}}/edit">
                        <button type="button">編集</button>
                    </a>
                </td>
            @endforeach
        </tr>
        <tr>
            <th>ID</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->id}}</td>
            @endforeach
        </tr>
        <tr>
            <th>タイトル</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->title}}</td>
            @endforeach
        </tr>
        <tr>
            <th>画像のurl</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->image_url}}</td>
            @endforeach
        </tr>
        <tr>
            <th>公開年</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->published_year}}</td>
            @endforeach
        </tr>
        <tr>
            <th>上映中かどうか</th>
            @foreach ($movieList as $movie)
                @if ($movie->is_showing)
                <td>上映中</td>
                @endif
                @if ($movie->is_showing == false)
                <td>上映予定</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <th>概要</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->description}}</td>
            @endforeach
        </tr>
        <tr>
            <th>登録日時</th>
            @foreach ($movieList as $movie)
                <td>{{$movie->created_at}}</td>
            @endforeach
        </tr>
        <tr>
            <th>更新日時 </th>
            @foreach ($movieList as $movie)
                <td>{{$movie->updated_at}}</td>
            @endforeach
        </tr>
    </table>
</body>
</html>
