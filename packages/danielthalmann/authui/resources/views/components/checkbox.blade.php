<label class="flex items-center">
    <input type="checkbox" name="{{ $name }}" @if($checked == 'true') checked @endif class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
    <span class="ml-2 text-sm text-gray-600">{{ $slot }}</span>
</label>

@if(isset($errors))
@foreach ($errors->get($name) as $message)
    <p class="text-red-400 text-sm">{{ $message }}</p>
@endforeach
@endif