<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Voeg hier de Huisdier toevoegen sectie toe -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Huisdier toevoegen</h2>
                <button id="addPetButton" class="btn btn-secondary mb-4" type="button">Huisdier toevoegen</button>

                <div id="petForm" style="display: none;" class="mt-4">
                    <form action="{{ route('pets.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="pet_name" class="form-label">Naam van het huisdier</label>
                            <input type="text" class="form-control" id="pet_name" name="pet_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="pet_type" class="form-label">Soort huisdier</label>
                            <input type="text" class="form-control" id="pet_type" name="pet_type" required>
                        </div>

                        <div class="mb-3">
                            <label for="rate_per_hour" class="form-label">Tarief per uur</label>
                            <input type="number" class="form-control" id="rate_per_hour" name="rate_per_hour" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="sitter_needed" class="form-label">Wanneer is een oppas nodig?</label>
                            <input type="datetime-local" class="form-control" id="sitter_needed" name="sitter_needed" required>
                        </div>

                        <div class="mb-3">
                            <label for="special_requirements" class="form-label">Speciale benodigdheden</label>
                            <textarea class="form-control" id="special_requirements" name="special_requirements"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Huisdier opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addPetButton').addEventListener('click', function() {
            var petForm = document.getElementById('petForm');
            petForm.style.display = petForm.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</x-app-layout>
