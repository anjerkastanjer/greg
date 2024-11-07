<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Alle Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- If there are no reviews -->
                    @if($reviews->isEmpty())
                        <div class="text-center mb-6">
                            <p>{{ __("Er zijn momenteel geen reviews beschikbaar.") }}</p>
                        </div>
                    @else
                        <!-- Reviews List -->
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-semibold">Alle Reviews</h3>
                            <ul class="mt-4">
                                @foreach ($reviews as $review)
                                    <li class="mb-4 border-b-2 border-gray-200 pb-4">
                                        <strong>Naam Huisdier:</strong> {{ $review->pet->naam }} <br>
                                        <strong>Beoordeling:</strong> {{ $review->rating }} <br>
                                        <strong>Review:</strong> {{ $review->body }} <br>
                                        <strong>Eigenaar:</strong> {{ $review->pet->user->name ?? 'Onbekend' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
