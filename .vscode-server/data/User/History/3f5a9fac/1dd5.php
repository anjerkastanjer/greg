<!-- resources/views/pets/all.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Alle Huisdieren</h1>

    @if($allPets->isEmpty())
        <p>Er zijn momenteel geen huisdieren beschikbaar.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="border-b border-gray-300 text-left py-2 px-4">Naam</th>
                    <th class="border-b border-gray-300 text-left py-2 px-4">Soort</th>
                    <th class="border-b border-gray-300 text-left py-2 px-4">Loon per uur</th>
                    <th class="border-b border-gray-300 text-left py-2 px-4">Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allPets as $pet)
                    <tr>
                        <td class="border-b border-gray-300 py-2 px-4">{{ $pet->name }}</td>
                        <td class="border-b border-gray-300 py-2 px-4">{{ $pet->type }}</td>
                        <td class="border-b border-gray-300 py-2 px-4">{{ $pet->description }}</td>
                        <td class="border-b border-gray-300 py-2 px-4">
                            @if($pet->photo)
                                <img src="{{ asset($pet->photo) }}" alt="{{ $pet->name }}" class="w-16 h-16 object-cover">
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
