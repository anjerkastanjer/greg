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
                    <button id="toggle-form" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Huisdier Toevoegen
                    </button>

                    <!-- Form for adding a new pet -->
                    <div id="pet-form" class="hidden mt-4">
                        <form action="{{ route('pets.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="naam" class="block text-white">Naam</label>
                                <input type="text" name="naam" id="naam" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="soort" class="block text-white">Soort dier</label>
                                <input type="text" name="soort" id="soort" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="loon_per_uur" class="block text-white">Prijs per uur (€)</label>
                                <input type="text" name="loon_per_uur" id="loon_per_uur" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
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

                    <!-- Display pets in a side-by-side layout with delete button -->
                    <ul class="mt-4 flex flex-wrap gap-4">
                        @foreach ($pets as $pet)
                            <li class="p-4 bg-gray-100 rounded-md w-1/2 md:w-1/4 text-black"> <!-- w-1/2 for small screens, w-1/4 for medium and larger screens -->
                                <strong>Naam:</strong> {{ $pet->naam }} <br>
                                <strong>Soort:</strong> {{ $pet->soort }} <br>
                                <strong>Prijs per uur:</strong> €{{ $pet->loon_per_uur }} <br>
                                <strong>Begindatum:</strong> {{ $pet->start_date }} <br>
                                <strong>Eigenaar:</strong> {{ Auth::user()->name }} <br> <!-- Displaying the owner's name -->

                                <!-- Delete Button -->
                                <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Verwijderen
                                    </button>
                                </form>
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
