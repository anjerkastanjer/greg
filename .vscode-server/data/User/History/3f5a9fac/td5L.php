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

            <!-- Display reviews for the pet -->
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

<!-- Jouw opgegeven huisdieren -->
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

                <!-- Display reviews for the pet -->
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
