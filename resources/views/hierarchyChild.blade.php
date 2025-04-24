<li>
    {{ $data->name }}
    @if ($data->children->count())
        <ul>
            @foreach ($data->children as $child)
                @include('hierarchy.partials.data', ['data' => $child])
            @endforeach
        </ul>
    @endif
</li>
