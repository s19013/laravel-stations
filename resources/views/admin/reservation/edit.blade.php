<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    {{-- ぶっちゃけここは厳密にテストされないようなので適当に --}}
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <pre>
        {{$reservation}}
    </pre>
    <form action="/admin/reservations/{{$reservation->id}}" method="post">
        @csrf
        @method("patch")

        <input type="hidden" name="movie_id"    value="{{old('movie_id',$movie_id)}}">
        <input type="hidden" name="schedule_id" value="{{old('schedule_id',$reservation->schedule_id)}}">
        <input type="hidden" name="sheet_id"    value="{{old('sheet_id',$reservation->sheet_id)}}">
        <input type="hidden" name="screening_date" value="{{old('screening_date',$reservation->screening_date)}}">


        <p>name</p>
        @if ($errors->has('name'))
            @foreach ($errors->get('name') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <input name='name' type="text" value="{{old('name',$reservation->name)}}" required >

        <p>email</p>
        @if ($errors->has('email'))
            @foreach ($errors->get('email') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <input name='email' type="email" value="{{old('email',$reservation->email)}}" required >



        <input type="submit" value="送信">
    </form>
</body>
</html>
