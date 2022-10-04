<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
    <form action="{{route('movie.store')}}" method="post">
        @csrf
        <p>タイトル</p>
        @if (session('allReadyExists'))
            <p>{{ session('allReadyExists') }}</p>
        @endif
        @if ($errors->has('title'))
            <p>{{$errors->first('title')}}</p>
        @endif
        <input name='title' type="text" value="{{old('title')}}" required>

        @if ($errors->has('image_url'))
            <p>{{$errors->first('image_url')}}</p>
        @endif
        <p>画像のURL</p>
        <input name='image_url' type="text" value="{{old('image_url')}}" required>

        @if ($errors->has('published_year'))
            <p>{{$errors->first('published_year')}}</p>
        @endif
        <p>公開年</p>
        <select name="published_year" required>

            <option value=2000 selected>2000</option>

            @for ($i = 2021; $i <= 2030; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>

        <br>
        <input type="checkbox" name="is_showing"  value='true'>上映中

        @if ($errors->has('description'))
            <p>{{$errors->first('description')}}</p>
        @endif
        <p>概要</p>
        <textarea name="description" id="" cols="30" rows="10" required>{{old('description')}}</textarea>

        <input type="submit" value="送信">
    </form>
</body>
</html>
