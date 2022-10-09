<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    <form action="/admin/movies/{{$movieId}}/schedule/store" method="post">
        @csrf
        <input type="hidden" name="movie_id" value={{$movieId}}>

        @if ($errors->has('start_time_date'))
            @foreach ($errors->get('start_time_date') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">開始日付</label>
        <input name='start_time_date' placeholder="例 2000-01-01" type="text" value="{{old('start_time_date')}}" required >

        <br>

        @if ($errors->has('start_time_time'))
            @foreach ($errors->get('start_time_time') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">開始時間</label>
        <input name='start_time_time' placeholder="例 08:06" type="text" value="{{old('start_time_time')}}" required >

        <br>

        @if ($errors->has('end_time_date'))
            @foreach ($errors->get('end_time_date') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">終了日付</label>
        <input name='end_time_date' placeholder="例 2000-01-01" type="text" value="{{old('end_time_date')}}" required >

        <br>

        @if ($errors->has('end_time_time'))
            @foreach ($errors->get('end_time_time') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">終了時間</label>
        <input name='end_time_time' placeholder="例 08:06" type="text" value="{{old('end_time_time')}}" required >

        <input type="submit" value="送信">

</body>
</html>
