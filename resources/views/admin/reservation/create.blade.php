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
    <form action="/admin/reservations/store" method="post">
        @csrf
        <p>movie_id</p>
        <input type="number" name="movie_id"       value="{{old('movie_id')}}" required>
        <p>schedule_id</p>
        <input type="number" name="schedule_id"    value="{{old('schedule_id')}}" required>
        <p>screening_date</p>
        <input type="text" placeholder="例 2000-01-01" name="screening_date" value="{{old('screening_date')}}" required>

        <p>sheet_id</p>
        <input type="number"  name="sheet_id" value="{{old('sheet_id')}}" required>

        <p>user_id</p>
        <input name='user_id' type="number" value="{{old('user_id')}}" required >


        <input type="submit" value="送信">
    </form>
</body>
</html>
