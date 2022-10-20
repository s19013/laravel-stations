<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
    <link rel="stylesheet" href="\css\my.css">
</head>
<body>
    <div class="searchField">
        <form action="/movies">
            <input type="text" name=keyword>
            <div>
                <input type="radio" name="is_showing" value="all" checked><label for="">すべて</label>
                <input type="radio" name="is_showing" value="1"><label for="">公開中</label>
                <input type="radio" name="is_showing" value="0"><label for="">公開予定</label>
            </div>
            <input type="submit" value="検索">
        </form>
    </div>
    <div class="movies">
        @foreach ($movieList as $movie)
            <a href="/movies/{{$movie->id}}">
                <div class="movie">
                    <img src={{$movie->image_url}} alt="">
                    <p>タイトル: {{ $movie->title }}</p>
                    @if ($movie->is_showing)
                    <p>上映中</p>
                    @endif
                    @if ($movie->is_showing == false)
                    <p>上映予定</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</body>
</html>
