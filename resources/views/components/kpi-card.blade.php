@props(['title','value','url'=>null,'icon'=>null,'color'=>'text-gray-700'])

<div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
    <div>
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <p class="text-2xl font-semibold {{ $color }}">{{ $value }}</p>
    </div>
    <div class="text-right">
        @if($url)
            <a href="{{ $url }}" class="text-sm text-indigo-600 hover:underline">Open</a>
        @endif
    </div>
</div>
