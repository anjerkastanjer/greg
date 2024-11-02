<!-- resources/views/pets/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jouw Huisdieren') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold">Jouw Huisdieren</h1>

                    <!-- Button to toggle the form -->
                    <button id="toggleForm" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-4">
                        Voeg Huisdier Toe
                    </button>

                    <!-- Form for adding a new pet -->
                    <div id="petForm" class="hidden mb-4">
                        <form action="{{ route('pets.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700">Naam:</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                            </div>
                            <div class="mb-4">
                                <label for="species" class="block text-gray-700">Soort:</label>
                                <input type="text" id="species" name="species" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                            </div>
                            <div class="mb-4">
                                <label for="owner_id" class="block text-gray-700">Eigenaar:</label>
                                <input type="text" id="owner_id" name="owner_id" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                            </div>
                            <div class="mb-4">
                                <label for="hourly_rate" class="block text-gray-700">Prijs per uur:</label>
                                <input type="number" id="hourly_rate" name="hourly_rate" class="mt-1 block w-full p-2 border border-gray-300 rounded" step="0.01" required>
                            </div>
                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-700">Begindatum:</label>
                                <input type="date" id="start_date" name="start_date" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                            </div>
                            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                                Huisdier Toevoegen
                            </button>
                        </form>
                    </div>

                    <ul>
                        @foreach ($pets as $pet)
                            <li class="my-4">
                                <strong>Naam:</strong> {{ $pet->name }} <br>
                                <strong>Soort:</strong> {{ $pet->species }} <br>
                                <strong>Prijs per uur:</strong> €{{ $pet->hourly_rate }} <br>
                                <strong>Begindatum:</strong> {{ $pet->start_date }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleForm').onclick = function() {
            var form = document.getElementById('petForm');
            form.classList.toggle('hidden');
        };
    </script>
</x-app-layout>