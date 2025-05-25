<div class="bg-white p-4 rounded shadow mb-3">
    <h3 class="text-xl font-bold">{{ $event->name }}</h3>
    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y H:i') }}</p>
    <p class="text-gray-700">{{ $event->location }}</p>
    @if($event->description)
        <p class="mt-2">{{ $event->description }}</p>
    @endif
    <a href="#" class="inline-block mt-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
        Bilet Al
    </a>
</div>
