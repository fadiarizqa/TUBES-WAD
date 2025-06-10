@props(['type' => 'success', 'title' => '', 'message' => ''])

@php
    $bg = $type === 'success' ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300';
    $iconColor = $type === 'success' ? 'text-green-500' : 'text-red-500';
    $textColor = 'text-gray-800';
@endphp

<div id="alertBox" {{ $attributes->merge(['class' => "flex items-start p-4 rounded-md shadow-sm mb-4 $bg relative w-full max-w-md mx-auto alert-box"]) }}>
    <div class="mr-3 mt-1">
        @if($type === 'success')
            <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        @else
            <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        @endif
    </div>
    <div class="flex-1 {{ $textColor }}">
        <strong class="block font-semibold capitalize">{{ $title }}</strong>
        <span class="text-sm">{{ $message }}</span>
    </div>
    <button onclick="document.getElementById('alertBox').remove()" class="ml-4 text-gray-500 hover:text-gray-700 cursor-pointer">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"/>
        </svg>
    </button>
</div>
