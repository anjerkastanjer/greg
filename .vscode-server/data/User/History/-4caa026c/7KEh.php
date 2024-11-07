<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geaccepteerde Aanvragen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Geaccepteerde Aanvragen</h3>

                    <ul>
                        @foreach ($geaccepteerdeAanvragen as $aanvraag)
                            <li class="mb-4 p-4 border-b border-gray-300">
                                <div>
                                    <strong>Naam Huisdier:</strong> {{ $aanvraag->pet->naam }} <br>
                                    <strong>Soort:</strong> {{ $aanvraag->pet->soort }} <br>
                                    <strong>Prijs per uur:</strong> €{{ $aanvraag->pet->loon_per_uur }} <br>
                                    <strong>Status:</strong> {{ $aanvraag->status }} <br>
                                    <strong>Oppasser:</strong> {{ $aanvraag->oppasser->name }} <br>
                                    <strong>Eigenaar:</strong> {{ $aanvraag->owner->name }} <br>

                                    <!-- Leave Review Button -->
                                    <button
                                        onclick="document.getElementById('reviewModal-{{ $aanvraag->id }}').style.display='block'"
                                        class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-black rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    >
                                        Leave Review
                                    </button>
                        
                                    <!-- Review Modal -->
<div id="reviewModal-{{ $aanvraag->id }}" style="display:none;" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <input type="hidden" name="pet_id" value="{{ $aanvraag->pet->id }}">

                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Leave a Review for {{ $aanvraag->pet->naam }}</h3>

                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" id="rating" class="mt-1 block w-full text-black bg-white">
                    <option value="1" class="text-black">1</option>
                    <option value="2" class="text-black">2</option>
                    <option value="3" class="text-black">3</option>
                    <option value="4" class="text-black">4</option>
                    <option value="5" class="text-black">5</option>
                </select>

                <label for="body" class="block text-sm font-medium text-gray-700 mt-4">Review</label>
                <textarea name="body" id="body" rows="4" class="mt-1 block w-full text-black bg-white"></textarea>

                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white sm:ml-3 sm:w-auto sm:text-sm">
                        Submit Review
                    </button>
                    <button type="button" onclick="document.getElementById('reviewModal-{{ $aanvraag->id }}').style.display='none'" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Review Modal -->

                                    <!-- End Review Modal -->
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
