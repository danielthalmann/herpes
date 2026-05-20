<label class="flex items-center">
    <input type="checkbox" name="{{ $name }}" @if($checked == 'true') checked @endif class="rounded border-gray-300 w-8 accent-indigo-600 focus:ring-indigo-500 scale-150"/>
    <span class="ml-2 text-sm text-gray-900 dark:text-gray-100">{{ $slot }}</span>
</label>

@if(isset($errors))
@foreach ($errors->get($name) as $message)
    <p class="text-red-400 text-sm">{{ $message }}</p>
@endforeach
@endif
