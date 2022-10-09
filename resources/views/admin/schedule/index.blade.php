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
    <h2>{{$movieData->title}}</h2>
    <img src="{{$movieData->image_url}}" alt="">
    <p>{{$movieData->published_year}}</p>
    <p>{{$movieData->description}}</p>
    @if ($movieData->is_showing === '1')
        <p>上映中</p>
    @else
        <p>上映予定</p>
    @endif
    <a href="/admin/movies/{{$movieData->id}}/schedules/create">
        <button type="button" >追加</button>
    </a>
    <table>
        <tr>
            <th>開始</th>
            <th>終了</th>
            <th></th>
            <th></th>
        </tr>
        @foreach ($movieScheduleList as $schedule)
            <tr>
                <td>{{date('H:i', strtotime($schedule->start_time));}}</td>
                <td>{{date('H:i', strtotime($schedule->end_time));}}</td>
                <td>
                    <a href="/admin/schedules/{{$schedule->id}}/edit">
                        <button type="button">編集</button>
                    </a>
                </td>
                <td>
                    <form action="/admin/schedules/{{$schedule->id}}/destroy" method="post" onsubmit="return finalCheck()">
                        @csrf
                        @method('DELETE')
                        <input type="submit" id='delete' value="削除">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <script>
        function finalCheck() { window.confirm("削除しますか?"); }
    </script>
</body>
</html>
