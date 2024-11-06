<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mijn Aanvragen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Lijst van Mijn Aanvragen</h3>

                    <ul>
                        @foreach ($aanvragen as $aanvraag)
                            <li class="mb-4">
                                <strong>Oppasser:</strong> {{ $aanvraag->oppasser->name }} <br>
                                <strong>Eigenaar:</strong> {{ $aanvraag->owner->name }} <br>
                                <strong>Status:</strong> {{ ucfirst($aanvraag->status) }} <br>
                                
                                <!-- Only the owner can edit the status -->
                                @if ($aanvraag->owner_id == Auth::id())
                                    <form action="{{ route('aanvragen.updateStatus', $aanvraag->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH') <!-- Use PATCH method for updating the status -->
                                        <label for="status">Wijzig Status:</label>
                                        <select name="status" id="status">
                                            <option value="pending" {{ $aanvraag->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="accepted" {{ $aanvraag->status == 'accepted' ? 'selected' : '' }}>Geaccepteerd</option>
                                            <option value="rejected" {{ $aanvraag->status == 'rejected' ? 'selected' : '' }}>Afgewezen</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Opslaan</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
