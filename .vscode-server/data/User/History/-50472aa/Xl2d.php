<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <!-- Header content kan hier komen -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Welkomsttekst en knop voor aanmelden -->
                    <div class="text-center mb-6">
                        <p>{{ __("Welkom op mijn pagina! Ik ben blij dat je je hebt aangemeld. Op deze pagina kun je je aanmelden als oppasser.") }}</p>

                        @if ($oppasser)
                            <!-- Als de gebruiker al een oppasser is -->
                            <p class="mt-4 text-red-600 font-bold text-lg">
                                Je bent al aangemeld als oppasser, verwijder jezelf om jezelf opnieuw aan te melden.</p>
                        @else
                            <button id="toggle-oppasser-form" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Jezelf Aanmelden als Oppasser
                            </button>
                        @endif
                    </div>

                    @if ($oppasser)
                        <!-- Gegevens van de gebruiker die al een oppasser is -->
                        <div class="text-center mb-6">
                            <!-- Toon afbeelding van de oppasser -->
                            @if ($oppasser->profile_image)
                                <img src="{{ asset('storage/' . $oppasser->profile_image) }}" alt="Image of {{ $oppasser->naam }}" class="rounded-full mx-auto mb-4 max-w-[300px] max-h-[300px]">
                            @else
                                <p class="text-red-600">Geen profielfoto</p>
                            @endif
                            <p class="font-bold">{{ __("Je hebt je succesvol aangemeld als oppasser. Hier zijn je gegevens:") }}</p>
                            <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                            <strong>Soort Dier:</strong> {{ implode(', ', $oppasser->soort_dier) }} <br>
                            <strong>Minimale Prijs per uur:</strong> €{{ $oppasser->loon }} <br>

                            <!-- Verwijderknop voor deze oppasser -->
                            <form action="{{ route('oppasser.destroy', $oppasser->id) }}" method="POST" class="mt-2 text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Verwijderen</button>
                            </form>
                        </div>
                    @else
                        <!-- Formulier voor aanmelden als oppasser -->
                        <div id="oppasser-form" class="hidden mt-4 text-center">
                            <form action="{{ route('oppasser.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="soort_dier" class="block text-white">Diersoorten waar je op zou willen passen</label>
                                    <div class="flex justify-center items-center">
                                        <input type="text" name="soort_dier[]" id="soort_dier" required class="mt-1 block w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;">
                                        <button type="button" id="add-animal-button" class="ml-2 px-2 py-1 border border-black rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            +
                                        </button>
                                    </div>
                                    <div id="additional-animals" class="mt-2"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="loon" class="block text-white">Minimale Prijs per uur (€)</label>
                                    <input type="text" name="loon" id="loon" required class="mt-1 block w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;">
                                </div>

                                <div class="mb-4">
                                    <label for="profile_image" class="block text-white">Upload een afbeelding van jezelf</label>
                                    <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;">
                                </div>

                                <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Aanmelden
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- List van oppassers -->
                    <div class="text-center mt-8">
                        <h3 class="text-lg font-semibold">Lijst van andere Oppassers</h3>
                        <ul class="mt-4">
                            @foreach ($oppassers as $oppasser)
                                @if (auth()->check() && ($oppasser->user_id !== auth()->id())) <!-- Skip the current user's oppasser -->
                                    <li class="mb-4 border-t border-white pt-4">
                                        <!-- Toon afbeelding van de oppasser -->
                                        @if ($oppasser->profile_image)
                                            <img src="{{ asset('storage/' . $oppasser->profile_image) }}" alt="Image of {{ $oppasser->naam }}" class="rounded-full mx-auto mb-4 max-w-[300px] max-h-[300px]">
                                        @else
                                            <p class="text-red-600">Geen profielfoto</p>
                                        @endif
                                        <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                                        <strong>Soort Dier:</strong> {{ implode(', ', json_decode($oppasser->soort_dier, true) ?? []) }} <br>
                                        <strong>Prijs per uur:</strong> €{{ $oppasser->loon }} <br>
                                        <strong>Gebruiker:</strong> {{ $oppasser->user->name ?? 'Onbekend' }}
                                    </li>
                                @else
                                    <li class="mb-4 border-t border-white pt-4">
                                        <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                                        <strong>Soort Dier:</strong> {{ implode(', ', json_decode($oppasser->soort_dier, true) ?? []) }} <br>
                                        <strong>Prijs per uur:</strong> €{{ $oppasser->loon }} <br>
                                        <strong>Gebruiker:</strong> {{ $oppasser->user->name ?? 'Onbekend' }}

                                        <!-- Verwijderknop voor de ingelogde gebruiker of beheerder -->
                                        @if (auth()->user()->is_admin || auth()->id() === $oppasser->user_id)
                                            <form action="{{ route('oppasser.destroy', $oppasser->id) }}" method="POST" class="mt-2 text-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Verwijderen</button>
                                            </form>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <script>
                        document.getElementById('toggle-oppasser-form').addEventListener('click', function() {
                            const form = document.getElementById('oppasser-form');
                            form.classList.toggle('hidden');
                        });

                        document.getElementById('add-animal-button').addEventListener('click', function() {
                            const additionalAnimalsDiv = document.getElementById('additional-animals');
                            const newAnimalInput = document.createElement('div');
                            newAnimalInput.classList.add('mt-2');
                            newAnimalInput.innerHTML = `
                                <input type="text" name="soort_dier[]" required class="block w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;" placeholder="Voeg een ander soort dier toe">
                            `;
                            additionalAnimalsDiv.appendChild(newAnimalInput);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
