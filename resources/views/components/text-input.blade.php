@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm p-3']) !!}>
