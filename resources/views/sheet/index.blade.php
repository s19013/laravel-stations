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
    <table class="sheetTable">
        @php $switchFlag = "a"; @endphp

        <tr>
        @foreach ($sheets as $sheet)
            {{-- rowが切り替わる時に改行 --}}
            @if ($switchFlag !== $sheet->row)
                </tr>
                <tr>
                @php $switchFlag = $sheet->row @endphp
            @endif

            @if (in_array($sheet->id,$reserved))
                <td class="reserved">
                    {{$sheet->row}}-{{$sheet->column}}
                </td>
            @else
                <td>
                    <form action="/reservations/store" method="post">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{$movie_id}}">
                        <input type="hidden" name="schedule_id" value="{{$schedule_id}}">
                        <input type="hidden" name="screening_date" value="{{$screening_date}}">
                        <input type="hidden" name="sheet_id" value="{{$sheet->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">

                        <button type="submit">{{$sheet->row}}-{{$sheet->column}}</button>
                    </form>
                </td>
            @endif

        @endforeach
        </tr>
    </table>
</body>
</html>
