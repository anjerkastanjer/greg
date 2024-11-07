<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hier kun je een aanvraag doen om op een huisdier te passen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Error message section -->
                    @if (session('error'))
                        <div class="mb-4 text-red-600 text-center font-bold">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center">
                        <p>{{ __("Welkom op deze pagina! Hier kun je je aanmelden als oppas voor verschillende dieren") }}</p>

                        <!-- Success message -->
                        @if (session('success'))
                            <div class="mb-4 text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Button to add a new pet (for authenticated users) -->
                        @auth
                            <button id="toggle-form" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Eigen Huisdier Toevoegen
                            </button>

                            <!-- Form for adding a new pet -->
                            <div id="pet-form" class="hidden mt-4">
                                @if ($errors->any())
                                    <div class="mb-4 text-red-600">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
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
                        @endauth

                        <h3 class="mt-6 text-lg font-semibold">Lijst van Alle Huisdieren die een oppas zoeken</h3>
                        <ul class="mt-4">
                            <!-- Huisdieren van andere gebruikers -->
                            @foreach ($otherPets as $pet)
                                <li class="mb-4 p-4 border-b border-gray-300">
                                    <div>
                                        <strong>Naam:</strong> {{ $pet->naam }} <br>
                                        <strong>Soort:</strong> {{ $pet->soort }} <br>
                                        <strong>Prijs per uur:</strong> €{{ $pet->loon_per_uur }} <br>
                                        <strong>Begindatum:</strong> {{ $pet->start_date }} <br>
                                        <strong>Eigenaar:</strong> 
                                        @if ($pet->user)
                                            {{ $pet->user->name }} <!-- Display the pet's owner's name -->
                                        @else
                                            Onbekend
                                        @endif

                                        <!-- Check if the pet has reviews before displaying them -->
                                        @if ($pet->reviews->isNotEmpty())
                                            <h4 class="mt-4 font-semibold">Reviews:</h4>
                                            <ul class="mt-2">
                                                @foreach ($pet->reviews as $review)
                                                    <li class="mb-2">
                                                        <strong>Rating:</strong> {{ $review->rating }} <br>
                                                        <strong>Review:</strong> {{ $review->body }} <br>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No reviews yet.</p>
                                        @endif

                                        <!-- Button for 'Meld je aan als Oppas' (Apply as a Pet Sitter) -->
                                        @auth
                                            @if ($pet->user && $pet->user->id !== auth()->user()->id) <!-- Only show button for pets not owned by the logged-in user -->
                                                <form action="{{ route('aanvragen.store', ['owner_id' => $pet->user->id]) }}" method="POST" class="mt-4">
                                                    @csrf
                                                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                                                    <input type="hidden" name="owner_id" value="{{ $pet->user->id }}">
                                                    <input type="hidden" name="oppasser_id" value="{{ auth()->user()->id }}">
                                                    <input type="hidden" name="status" value="pending">

                                                    <button type="submit" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Meld je aan als Oppas voor dit dier
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <h3 class="mt-6 text-lg font-semibold">Jouw opgegeven huisdieren</h3>
                        <ul class="mt-4">
                            @foreach ($userPets as $pet)
                                <li class="mb-4 p-4 border-b border-gray-300">
                                    <div>
                                        <strong>Naam:</strong> {{ $pet->naam }} <br>
                                        <strong>Soort:</strong> {{ $pet->soort }} <br>
                                        <strong>Prijs per uur:</strong> €{{ $pet->loon_per_uur }} <br>
                                        <strong>Begindatum:</strong> {{ $pet->start_date }} <br>
                                        <strong>Eigenaar:</strong> {{ $pet->user->name }} <br>

                                        <!-- Check if the pet has reviews before displaying them -->
                                        @if ($pet->reviews->isNotEmpty())
                                            <h4 class="mt-4 font-semibold">Reviews:</h4>
                                            <ul class="mt-2">
                                                @foreach ($pet->reviews as $review)
                                                    <li class="mb-2">
                                                        <strong>Rating:</strong> {{ $review->rating }} <br>
                                                        <strong>Review:</strong> {{ $review->body }} <br>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No reviews yet.</p>
                                        @endif

                                        <!-- Button to delete pet -->
                                        @auth
                                            @if ($pet->user && $pet->user->id === auth()->user()->id)
                                                <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md mb-4">Verwijderen</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>