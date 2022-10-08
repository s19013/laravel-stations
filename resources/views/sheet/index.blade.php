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
        <tr>
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
        </tr>
    </table>
</body>
</html>
