@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    default:
        $alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    {{-- Trigger --}}
    <div @click="open = !open; console.log('Dropdown clicked, open:', open)" class="cursor-pointer select-none" style="cursor: pointer !important;">
        {{ $trigger }}
    </div>

    {{-- Dropdown content --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        style="display: none; z-index: 9999 !important;"
        class="absolute z-[9999] mt-2 {{ $width }} rounded-[10px] {{ $alignmentClasses }} bg-white border border-[rgba(184,232,212,.9)] overflow-hidden"
        style="display: none; z-index: 9999 !important; box-shadow: 0 6px 16px rgba(6,95,70,.1);"
    >
        {{ $content }}
    </div>
</div>
