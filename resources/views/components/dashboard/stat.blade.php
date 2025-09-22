<div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
    <div class="p-3 rounded-full bg-gray-100">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6 {{ $color }}" />
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ $count }}</p>
        <p class="text-sm text-gray-500">{{ $label }}</p>
    </div>
</div>
