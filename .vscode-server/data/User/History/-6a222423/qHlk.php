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
                    <!-- Button to add a new pet -->
                    <button id="toggle-form" class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                        Huisdier Toevoegen
                    </button>

                    <!-- Form for adding a new pet -->
                    <div id="pet-form" class="hidden mt-4">
                        <form action="{{ route('pets.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-white">Naam</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="species" class="block text-white">Soort dier</label>
                                <input type="text" name="species" id="species" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="hourly_rate" class="block text-white">Prijs per uur (€)</label>
                                <input type="text" name="hourly_rate" id="hourly_rate" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="start_date" class="block text-white">Begindatum</label>
                                <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Submit
                            </button>
                        </form>
                    </div>

                    <!-- List of pets -->
                    <h3 class="mt-6 text-lg font-semibold">Lijst van Huisdieren</h3>
                    <ul class="mt-4">
                        @foreach ($pets as $pet)
                            <li class="mb-2">
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
        document.getElementById('toggle-form').addEventListener('click', function() {
            const form = document.getElementById('pet-form');
            form.classList.toggle('hidden'); // Toggle visibility of the form
        });
    </script>
</x-app-layout>
