@if($type == 'link')
<a class="inline-block rounded-sm border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600" href="{{ $href }}">
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" name="{{ $name }}" class="@if($aspect === 'full') w-full @endif cursor-pointer inline-block rounded-sm border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600">
    {{ $slot }}
</button>
@endif
