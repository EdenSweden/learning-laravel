{{-- $attributes->merge includes the stated attributes and their values, but also merges other attributes we add. See: https://www.amitmerchant.com/merge-attributes-blade-components-laravel7/ --}}

<div {{$attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6'])}}>
    {{$slot}}
</div>

{{-- $slot here is similar to {children} in React. It allows us to create a reusable styled wrapper or theme, etc. --}}