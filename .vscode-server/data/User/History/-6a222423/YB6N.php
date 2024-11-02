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
                    <h1>Jouw Huisdieren</h1>

                    <button id="addPetButton" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Voeg Huisdier Toe
                    </button>

                    <div id="petForm" class="mt-4 hidden">
                        <form action="{{ route('pets.store') }}" method="POST">
                            @csrf
                            <label for="name" class="block text-white">Naam:</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white">
                            
                            <label for="species" class="block text-white mt-2">Soort:</label>
                            <input type="text" name="species" id="species" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white">
                            
                            <label for="hourly_rate" class="block text-white mt-2">Prijs per uur:</label>
                            <input type="text" name="hourly_rate" id="hourly_rate" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white">
                            
                            <label for="start_date" class="block text-white mt-2">Begindatum:</label>
                            <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white">

                            <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addPetButton').onclick = function() {
            var form = document.getElementById('petForm');
            form.classList.toggle('hidden');
        };
    </script>
</x-app-layout>
