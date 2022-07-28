<x-layout>
    @include('partials._hero')
    @include('partials._search')

    <div
    class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4"
    >

    {{-- <h1>{{$heading}}</h1> --}}
    <!-- The heading variable above is taken from the route in web.php. While the syntax would normally say 'echo' and have php tags, this is blade syntax.
    To directly incorporate php, you can use the php directive, similar to foreach below. Put @ php together and @ endphp together & put php code between them.
    -->
    {{-- UNLESS DIRECTIVE: --}}
    {{-- @unless(count($listings) == 0) --}}
        {{-- do foreach loop here --}}
        {{-- @else bla bla no listings found --}}
    {{-- @endunless --}}
    {{-- @else can also of course be used with if. --}}

    @unless(count($listings) == 0)
        
    @foreach($listings as $listing)
    {{-- A component with props, sort of like React! --}}
        <x-listing-card :listing="$listing" />
    @endforeach

    @else <p>No listings found.</p>
    @endunless

    </div>

    <div class="mt-6 p-4">
        {{$listings->links()}}
    </div>
</x-layout>