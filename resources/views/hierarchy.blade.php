<!DOCTYPE html>
<html>

<head>
    <title>Data Hierarchy</title>
</head>

<body>
    <h1>Data Hierarchy</h1>
    <ul>
        @foreach ($hierarchy as $data)
        <li>
            {{ $data->name }}
            @if ($data->children->count())
            <ul>
                @foreach ($data->children as $child)
                    @include('hierarchyChild', ['data' => $child])
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</body>

</html>