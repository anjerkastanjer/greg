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

                    <!-- Sectie voor Uitgaande Aanvragen -->
                    <h3 class="text-lg font-semibold">Mijn Uitgaande Aanvragen</h3>

                    <ul>
                        @foreach ($uitgaandeAanvragen as $aanvraag)
                            <li class="mb-4">
                                <strong>Oppasser:</strong> {{ $aanvraag->oppasser->name }} <br>
                                <strong>Huisdier Naam:</strong> {{ $aanvraag->pet->naam }} <br>
                                <strong>Uurloon:</strong> €{{ number_format($aanvraag->pet->loon_per_uur, 2) }} <br>
                                <strong>Status:</strong> {{ ucfirst($aanvraag->status) }} <br>
                                
                                @if ($aanvraag->owner_id == Auth::id()) <!-- Alleen de eigenaar kan de aanvraag accepteren of afwijzen -->
                                    <div class="flex items-center space-x-4 mt-2">
                                        <!-- Accept button (green) -->
                                        <form action="{{ route('aanvragen.accept', $aanvraag->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Accepteren</button>
                                        </form>

                                        <!-- Reject button (red) -->
                                        <form action="{{ route('aanvragen.reject', $aanvraag->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Afwijzen</button>
                                        </form>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- Sectie voor Binnenkomende Aanvragen -->
                    <h3 class="text-lg font-semibold">Lijst van Mijn Binnenkomende Aanvragen</h3>

                    <ul>
                        @foreach ($binnenkomendeAanvragen as $aanvraag)
                            <li class="mb-4">
                                <strong>Eigenaar:</strong> {{ $aanvraag->owner->name }} <br>
                                <strong>Huisdier Naam:</strong> {{ $aanvraag->pet->naam }} <br>
                                <strong>Uurloon:</strong> €{{ number_format($aanvraag->pet->loon_per_uur, 2) }} <br>
                                <strong>Status:</strong> {{ ucfirst($aanvraag->status) }} <br>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>