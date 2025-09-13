<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route("api_test")}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
        <input type="file" name="image" id="image">
        <div>
            <input type="checkbox" name="is_plant" id="is_plant">
            <label for="is_plant">Is it a plant ?</label>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>