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
    <form action="/reservations/store" method="post">
        @csrf
        <input type="hidden" name="movie_id" value="{{$movie_id}}">
        <input type="hidden" name="schedule_id" value="{{$schedule_id}}">
        <input type="hidden" name="screening_date" value="{{$screening_date}}">
        <input type="hidden" name="sheet_id" value="{{$sheet_id}}">
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
