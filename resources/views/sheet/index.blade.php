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
    <table class="sheetTable">
        {{-- <tr>
            @foreach ($rowA as $sheet)
                <td>
                    {{$sheet->row}}-{{$sheet->column}}
                </td>
            @endforeach
        </tr>
        <tr>
            @foreach ($rowB as $sheet)
                <td>
                    {{$sheet->row}}-{{$sheet->column}}
                </td>
            @endforeach
        </tr>
        <tr>
            @foreach ($rowC as $sheet)
                <td>
                    {{$sheet->row}}-{{$sheet->column}}
                </td>
            @endforeach
        </tr> --}}
        @php $switchFlag = "a"; @endphp

        <tr>
        @foreach ($sheets as $sheet)
            {{-- rowが切り替わる時に改行 --}}
            @if ($switchFlag !== $sheet->row)
                </tr>
                <tr>
                @php $switchFlag = $sheet->row @endphp
            @endif

            <td>
                <a href="/movies/{{$movie_id}}/schedules/{{$schedule_id}}/reservations/create?screening_date={{$screening_date}}&sheetId={{$sheet->id}}">
                    {{$sheet->row}}-{{$sheet->column}}
                </a>
            </td>

        @endforeach
        </tr>
    </table>
</body>
</html>
