<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    @if ($oppasser)
                        <!-- Weergeven dat de gebruiker al een oppasser is -->
                        <p class="mt-4">Je hebt je al aangemeld als oppasser. Hier zijn je gegevens:</p>
                        <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                        <strong>Soort Dier:</strong> {{ implode(', ', json_decode($oppasser->soort_dier, true) ?? []) }} <br>
                        <strong>Prijs per uur:</strong> €{{ $oppasser->loon }} <br>

                        <!-- Optionele verwijderknop voor deze oppasser -->
                        <form action="{{ route('oppasser.destroy', $oppasser->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Verwijderen</button>
                        </form>
                    @else
                        <!-- Formulier om een nieuwe oppasser aan te melden als er nog geen is -->
                        <h3 class="mt-6 text-lg font-semibold">Aanmelden als Oppasser</h3>
                        <div id="oppasser-form" class="mt-4">
                            <form action="{{ route('oppasser.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label for="soort_dier" class="block text-white">Diersoort waar je op zou willen passen</label>
                                    <div class="flex items-center">
                                        <input type="text" name="soort_dier[]" id="soort_dier" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;">
                                        <button type="button" id="add-animal-button" class="ml-2 px-2 py-1 border border-black rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            +
                                        </button>
                                    </div>
                                    <div id="additional-animals" class="mt-2"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="loon" class="block text-white">Prijs per uur (€)</label>
                                    <input type="text" name="loon" id="loon" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;">
                                </div>

                                <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Aanmelden
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Optionele lijst van alle oppassers -->
                    <h3 class="mt-6 text-lg font-semibold">Lijst van Oppassers</h3>
                    <ul class="mt-4">
                        @if ($oppassers->isEmpty())
                            <li class="mb-2">Geen oppassers gevonden.</li>
                        @else
                            @foreach ($oppassers as $oppasser)
                                <li class="mb-2">
                                    <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                                    <strong>Soort Dier:</strong> {{ implode(', ', json_decode($oppasser->soort_dier, true) ?? []) }} <br>
                                    <strong>Prijs per uur:</strong> €{{ $oppasser->loon }} <br>
                                    <strong>Gebruiker:</strong> {{ $oppasser->user->name ?? 'Onbekend' }}

                                    <!-- Optionele verwijderknop voor deze oppasser -->
                                    <form action="{{ route('oppasser.destroy', $oppasser->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Verwijderen</button>
                                    </form>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <script>
                        document.getElementById('add-animal-button').addEventListener('click', function() {
                            const additionalAnimalsDiv = document.getElementById('additional-animals');
                            const newAnimalInput = document.createElement('div');
                            newAnimalInput.classList.add('mt-2');
                            newAnimalInput.innerHTML = `
                                <input type="text" name="soort_dier[]" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;" placeholder="Voeg een ander soort dier toe">
                            `;
                            additionalAnimalsDiv.appendChild(newAnimalInput);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>