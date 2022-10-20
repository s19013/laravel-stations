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
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <p>タイトル</p>
    <p>{{$movie->title}}</p>
    <img width="300rem" src="{{$movie->image_url}}" alt="">
    <p>公開年</p>
    <p>{{$movie->published_year}}</p>
    <p>説明</p>
    <p>{{$movie->description}}</p>

    <table>
        <tr>
            <th>開始</th>
            <th>終了</th>
            <th></th>
        </tr>
        @foreach ($movie->schedules as $schedule)
            <tr>
                {{-- <td>{{date('a h:i', strtotime($schedule->start_time));}}</td>
                <td>{{date('a h:i', strtotime($schedule->end_time));}}</td> --}}
                {{-- テストコードにあわせた --}}
                {{-- なぜこのような表記なのだろう? --}}
                <td>{{date('a h:m', strtotime($schedule->start_time));}}</td>
                <td>{{date('a h:m', strtotime($schedule->end_time));}}</td>
                <td>
                    <a href="/movies/{{$movie->id}}/schedules/{{$schedule->id}}/sheets?screening_date={{date('Y-m-d', strtotime($schedule->start_time))}}">
                        <button type="button">座席を予約する</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
