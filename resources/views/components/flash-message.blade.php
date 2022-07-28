{{-- note the session helper function: --}}
@if(session()->has('message'))
{{-- x-data is an attribute from Alpine.js, taken from script tag in layout view. --}}
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif

