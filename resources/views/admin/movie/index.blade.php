<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
    <link rel="stylesheet" href="\css\app.css">
</head>
<body>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <a href="/admin/movies/create">
        <button type="button">新規作成</button>
    </a>
    <table class="movieTable">
        <tr>
            <td></td>
            @foreach ($movieList as $movie)
                <td>
                    <a href="/admin/movies/{{$movie->id}}/edit">
                        <button type="button">編集</button>
                    </a>
                </td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach ($movieList as $movie)
                <td>
                    <a href="/admin/movies/{{$movie->id}}">
                        <button type="button">スケジュール</button>
                    </a>
                </td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach ($movieList as $movie)
                <td>
                    <form action="/admin/movies/{{$movie->id}}/destroy" method="post" onsubmit="return finalCheck()">
                        @csrf
                        @method('DELETE')
                        <input type="submit" id='delete' value="削除">
                    </form>
                </td>
            @endforeach
        </tr>
        <tr>
            <td>ID</td>
            @foreach ($movieList as $movie)
                <td>{{$movie->id}}</td>
            @endforeach
        </tr>
        <tr>
            <td>タイトル</td>
            @foreach ($movieList as $movie)
                <td>{{$movie->title}}</td>
            @endforeach
        </tr>
        <tr>
            <td>画像</td>
            @foreach ($movieList as $movie)
            <td>
                <img src="{{$movie->image_url}}" alt="">
            </td>
            @endforeach
        </tr>
        <tr>
            <td>公開年</td>
            @foreach ($movieList as $movie)
                <td>{{$movie->published_year}}</td>
            @endforeach
        </tr>
        <tr>
            <td>上映状態</td>
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
            <td>概要</td>
            @foreach ($movieList as $movie)
                <td>{{$movie->description}}</td>
            @endforeach
        </tr>
        <tr>
            <td>登録日時</td>
            @foreach ($movieList as $movie)
                <td>{{$movie->created_at}}</td>
            @endforeach
        </tr>
        <tr>
            <td>更新日時 </td>
            @foreach ($movieList as $movie)
                <td>{{$movie->updated_at}}</td>
            @endforeach
        </tr>
    </table>
    </div>
    <script>
        function finalCheck() {
            window.confirm("削除しますか?");
        }
    </script>
</body>
</html>
