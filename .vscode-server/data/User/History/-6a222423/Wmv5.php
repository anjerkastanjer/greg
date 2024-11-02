<!-- resources/views/pets/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jouw Huisdieren') }} <!-- Titel aanpassen -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold">Jouw Huisdieren</h1>
                    <ul>
                        @foreach ($pets as $pet)
                            <li class="my-4">
                                <strong>Naam:</strong> {{ $pet->name }} <br>
                                <strong>Soort:</strong> {{ $pet->type }} <br>
                                <strong>Prijs per uur:</strong> €{{ $pet->hourly_rate }} <br>
                                <strong>Begindatum:</strong> {{ $pet->start_date }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>