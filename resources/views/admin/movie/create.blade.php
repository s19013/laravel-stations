<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    <form action="/admin/movies/store" method="post">
        @csrf
        <p>タイトル</p>
        @if ($errors->has('title'))
            @foreach ($errors->get('title') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <input name='title' type="text" value="{{old('title')}}" required >

        <p>画像のURL</p>
        @if ($errors->has('image_url'))
            @foreach ($errors->get('image_url') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif

        <input name='image_url' type="text" value="{{old('image_url')}}" required>

        <p>公開年</p>
        @if ($errors->has('published_year'))
            @foreach ($errors->get('published_year') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <select name="published_year" >

            <option value=2020 @if ((2020 === (int)old('published_year')) || old('published_year') == null)
                selected
            @endif>2020</option>

            @for ($i = 2021; $i <= 2030; $i++)
                <option value="{{$i}}"
                @if ($i === (int)old('published_year'))
                    selected
                @endif
                >{{$i}}</option>
            @endfor
        </select>

        <br>
        <input type="checkbox" name="is_showing" value = "1"
        @if ((int)old('is_showing') == "1") checked @endif
        >上映中

        <p>概要</p>
        @if ($errors->has('description'))
            @foreach ($errors->get('description') as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <textarea name="description" id="" cols="30" rows="10" required>{{old('description')}}</textarea>

        <input type="submit" value="送信">
    </form>
</body>
</html>
