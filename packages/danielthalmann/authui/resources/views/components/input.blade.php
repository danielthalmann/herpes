
<label class="mt-2" for="{{ $name }}id">
  <span class="block text-sm font-medium text-gray-700 mb-1"> {{ $label }} @if($required === 'true') * @endif</span>
  <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" id="{{ $name }}id"
    @if($required === 'true') required @endif
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
</label>

@if(isset($errors))
@foreach ($errors->get($name) as $message)
    <p class="text-red-400 text-sm">{{ $message }}</p>
@endforeach
@endif
