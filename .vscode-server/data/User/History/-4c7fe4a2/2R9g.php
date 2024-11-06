<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mijn Aanvragen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Flexbox container voor twee kolommen -->
                    <div class="flex justify-between mb-8">
                        <!-- Binnenkomende aanvragen aan de linkerkant -->
                        <div class="w-1/2 pr-4">
                            <h3 class="text-lg font-semibold">Lijst van Mijn Binnenkomende Aanvragen</h3>
                            <ul>
                                @foreach ($binnenkomendeAanvragen as $aanvraag)
                                    <li class="mb-4">
                                        <strong>Eigenaar:</strong> {{ $aanvraag->owner->name }} <br>
                                        <strong>Huisdier Naam:</strong> {{ $aanvraag->pet->naam }} <br>
                                        <strong>Uurloon:</strong> €{{ number_format($aanvraag->pet->loon_per_uur, 2) }} <br>
                                        <strong>Status:</strong> {{ ucfirst($aanvraag->status) }} <br>

                                        @if ($aanvraag->status == 'pending' && $aanvraag->owner_id == Auth::id())
                                            <a href="{{ route('aanvragen.accept', $aanvraag->id) }}" class="text-green-500">Accepteer</a> |
                                            <a href="{{ route('aanvragen.reject', $aanvraag->id) }}" class="text-red-500">Verwijder</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Uitgaande aanvragen aan de rechterkant -->
                        <div class="w-1/2 pl-4">
                            <h3 class="text-lg font-semibold">Mijn Uitgaande Aanvragen</h3>
                            <ul>
                                @foreach ($uitgaandeAanvragen as $aanvraag)
                                    <li class="mb-4">
                                        <strong>Oppasser:</strong> {{ $aanvraag->oppasser->name }} <br>
                                        <strong>Huisdier Naam:</strong> {{ $aanvraag->pet->naam }} <br>
                                        <strong>Uurloon:</strong> €{{ number_format($aanvraag->pet->loon_per_uur, 2) }} <br>
                                        <strong>Status:</strong> {{ ucfirst($aanvraag->status) }} <br>

                                        @if ($aanvraag->status == 'pending' && $aanvraag->oppasser_id == Auth::id())
                                            <a href="{{ route('aanvragen.accept', $aanvraag->id) }}" class="text-green-500">Accepteer</a> |
                                            <a href="{{ route('aanvragen.reject', $aanvraag->id) }}" class="text-red-500">Verwijder</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
