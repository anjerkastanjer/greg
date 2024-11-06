<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geaccepteerde Aanvragen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Geaccepteerde Aanvragen</h3>

                    <ul>
    @foreach ($geaccepteerdeAanvragen as $aanvraag)
        <li class="mb-4 p-4 border-b border-gray-300">
            <div>
                <strong>Naam Huisdier:</strong> {{ $aanvraag->pet->naam }} <br>
                <strong>Soort:</strong> {{ $aanvraag->pet->soort }} <br>
                <strong>Prijs per uur:</strong> €{{ $aanvraag->pet->loon_per_uur }} <br>
                <strong>Status:</strong> {{ $aanvraag->status }} <br>
                <strong>Oppasser:</strong> {{ $aanvraag->oppasser->name }} <br>
                <strong>Eigenaar:</strong> {{ $aanvraag->owner->name }} <br>
            </div>
        </li>
    @endforeach
</ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
