@props(['tagsCsv'])
{{-- ^ this will be a csv file from the db, which we will turn into an array. --}}

@php
//explode fn splits a string:
    $tags = explode(',', $tagsCsv);
@endphp

<ul class="flex">
    @foreach($tags as $tag)

    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="/?tag={{$tag}}">{{$tag}}</a>
    </li>

    @endforeach
</ul>