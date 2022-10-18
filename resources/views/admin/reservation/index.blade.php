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
    <a href="/admin/reservations/create">
        <button type="button">新規作成</button>
    </a>
    <pre>
        {{$reservationList}}
    </pre>
    <table class="reservationTable">
        <tr>
            <td></td>
            @foreach ($reservationList as $reservation)
                <td>
                    <a href="/admin/reservations/{{$reservation->id}}/edit">
                        <button type="button">編集</button>
                    </a>
                </td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach ($reservationList as $reservation)
                <td>
                    <form action="/admin/reservations/{{$reservation->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return finalCheck()">削除</button>
                    </form>
                </td>
            @endforeach
        </tr>
        <tr>
            <td>日付</td>
            @foreach ($reservationList as $reservation)
                <td>{{$reservation->screening_date}}</td>
            @endforeach
        </tr>
        <tr>
            <td>予約者の名前</td>
            @foreach ($reservationList as $reservation)
                <td>{{$reservation->user->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td>予約者のメアド</td>
            @foreach ($reservationList as $reservation)
                <td>{{$reservation->user->email}}</td>
            @endforeach
        </tr>
        <tr>
            <td>座席</td>
            @foreach ($reservationList as $reservation)
                <td>{{strtoupper($reservation->sheet->row.$reservation->sheet->column)}}</td>
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
