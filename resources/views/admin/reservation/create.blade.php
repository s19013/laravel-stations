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
    <form action="/admin/reservations/store" method="post">
        @csrf
        <p>movie_id</p>
        <input type="number" name="movie_id"       value="{{old('movie_id')}}">
        <p>schedule_id</p>
        <input type="number" name="schedule_id"    value="{{old('schedule_id')}}">
        <p>screening_date</p>
        <input type="text" name="screening_date" value="{{old('screening_date')}}">

        <p>sheet_id</p>
        <input type="number"  name="sheet_id" value="{{old('sheet_id')}}">
        <p>name</p>
        @if ($errors->has('name'))
            @foreach ($errors->get('name') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <input name='name' type="text" value="{{old('name')}}" required >

        <p>email</p>
        @if ($errors->has('email'))
            @foreach ($errors->get('email') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <input name='email' type="email" value="{{old('email')}}" required >



        <input type="submit" value="送信">
    </form>
</body>
</html>
