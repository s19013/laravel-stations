<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    <form action="/admin/schedules/{{$movieSchedule->id}}/update" method="post">
        @csrf
        @method("PATCH")

        {{-- <input type="hidden" name="schedule_id" value={{$movieSchedule->id}}> --}}
        <input type="hidden" name="movie_id" value={{$movieSchedule->movie_id}}>

        @if ($errors->has('start_time_date'))
            @foreach ($errors->get('start_time_date') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">開始日付</label>
        <input name='start_time_date' placeholder="例 2000-01-01" type="text" value="{{old('start_time_date',date('Y-m-d', strtotime($movieSchedule->start_time)))}}" required >

        <br>

        @if ($errors->has('start_time_time'))
            @foreach ($errors->get('start_time_time') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">開始時間</label>
        <input name='start_time_time' placeholder="例 08:06" type="text" value="{{old('start_time_time',date('H:i', strtotime($movieSchedule->start_time)))}}" required >

        <br>

        @if ($errors->has('end_time_date'))
            @foreach ($errors->get('end_time_date') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">終了日付</label>
        <input name='end_time_date' placeholder="例 2000-01-01" type="text" value="{{old('start_time_date',date('Y-m-d', strtotime($movieSchedule->end_time)))}}" required >

        <br>

        @if ($errors->has('end_time_time'))
            @foreach ($errors->get('end_time_time') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">終了時間</label>

        <input name='end_time_time' placeholder="例 08:06" type="text" value="{{old('end_time_time',date('H:i', strtotime($movieSchedule->end_time)))}}" required >

        <br>

        @if ($errors->has('screen_id'))
            @foreach ($errors->get('screen_id') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <label for="">スクリーン</label>
        <input name='screen_id' type="number" value="{{old('screen_id',$movieSchedule->screen_id)}}" required >

        <input type="submit" value="送信">
    </form>
</body>
</html>
