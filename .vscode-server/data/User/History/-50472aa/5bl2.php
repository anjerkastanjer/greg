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

                    <!-- Button to add a new oppasser -->
                    <button id="toggle-oppasser-form" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Oppasser Aanmelden
                    </button>

                    <!-- Form for adding a new oppasser -->
                    <div id="oppasser-form" class="hidden mt-4">
                        <form action="{{ route('oppasser.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="soort_dier" class="block text-white">Soort dier</label>
                                <input type="text" name="soort_dier" id="soort_dier" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <div class="mb-4">
                                <label for="loon" class="block text-white">Prijs per uur (€)</label>
                                <input type="text" name="loon" id="loon" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black bg-white" style="color: black;">
                            </div>
                            <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Aanmelden
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggle-oppasser-form').addEventListener('click', function() {
            const form = document.getElementById('oppasser-form');
            form.classList.toggle('hidden'); // Toggle visibility of the oppasser form
        });
    </script>
</x-app-layout>
