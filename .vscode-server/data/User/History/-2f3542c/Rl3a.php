<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 text-center">

                <!-- Welkomstbericht voor de admin -->
                <h3 class="text-2xl font-bold mb-6">Welkom Admin</h3>
                <p class="mb-8">Op deze pagina kun je gebruikers verwijderen en aanvragen verwijderen.</p>

                <!-- Lijst van Oppassers -->
                <h3 class="text-lg font-semibold mb-4">Lijst van Oppassers</h3>
                <ul class="mt-4 flex flex-col items-center">
                    @foreach ($oppassers as $oppasser)
                        <li class="mb-4 border-t border-white pt-4 w-full max-w-md">
                            <div class="text-left">
                                <strong>Naam:</strong> {{ $oppasser->naam }} <br>
                                <form action="{{ route('admin.oppasser.destroy', $oppasser->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md mt-2">Verwijderen</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Witte scheidingslijn -->
                <div class="my-8 border-t border-white"></div>

                <!-- Lijst van Pending Aanvragen -->
                <h3 class="text-lg font-semibold mt-8 mb-4">Lijst van Pending Aanvragen</h3>
                <ul class="mt-4 flex flex-col items-center">
                    @foreach ($pendingAanvragen as $aanvraag)
                        <li class="mb-4 border-t border-white pt-4 w-full max-w-md">
                            <div class="text-left">
                                <strong>Huisdier Naam:</strong> {{ $aanvraag->pet->naam }} <br>
                                <strong>Uurloon:</strong> €{{ number_format($aanvraag->pet->loon_per_uur, 2) }} <br>
                                <strong>Status:</strong> {{ $aanvraag->status }} <br>
                                <form action="{{ route('admin.aanvraag.destroy', $aanvraag->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md mt-2">Verwijderen</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
            </div>
        </div>
    </div>
</x-app-layout>
