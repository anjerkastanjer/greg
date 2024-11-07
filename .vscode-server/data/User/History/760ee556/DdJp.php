<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Oppassers huren') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-6">
                        <p>{{ __("Welkom op mijn pagina! Je kunt je hier aanmelden als oppasser of je gegevens zien als je al een oppasser bent.") }}</p>

                        <!-- If the user is already a sitter, show their profile -->
                        @if ($currentUserOppasser)
                            <div class="text-center mb-6">
                                <p class="font-bold">{{ __("Jij hebt je al aangemeld: dit is hoe anderen jouw profiel zien:") }}</p>
                                <strong>Naam:</strong> {{ $currentUserOppasser->naam }} <br>
                                <strong>Soort Dier:</strong> {{ implode(', ', json_decode($currentUserOppasser->soort_dier, true) ?? []) }} <br>
                                <strong>Prijs per uur:</strong> €{{ $currentUserOppasser->loon }} <br>

                                <!-- Button to delete their own sitter profile -->
                                <form action="{{ route('oppasser.destroy', $currentUserOppasser->id) }}" method="POST" class="mt-2 text-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Verwijderen</button>
                                </form>
                            </div>
                            
                            <!-- Horizontal line between sections -->
                            <hr class="border-t-2 border-gray-300 my-8">
                        @endif

                        <!-- List of other sitters -->
                        <div class="text-center mt-8">
                            <h3 class="text-lg font-semibold">Lijst van andere Oppassers</h3>
                            <ul class="mt-4">
                                @foreach ($oppassers as $oppasser)
                                    @if (auth()->check() && ($oppasser->user_id !== auth()->id())) <!-- Skip the current user's sitter -->
                                        <li class="mb-4 border-b-2 border-gray-200 pb-4">
                                            <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                                            <strong>Soort Dier:</strong> {{ implode(', ', json_decode($oppasser->soort_dier, true) ?? []) }} <br>
                                            <strong>Prijs per uur:</strong> €{{ $oppasser->loon }} <br>
                                            <strong>Gebruiker:</strong> {{ $oppasser->user->name ?? 'Onbekend' }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
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
                                <input type="text" name="soort_dier[]" required class="block w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-white" style="color: black;" placeholder="Voeg een ander soort dier toe...">
                            `;
                            additionalAnimalsDiv.appendChild(newAnimalInput);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>