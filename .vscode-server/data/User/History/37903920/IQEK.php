<!-- In resources/views/reviews/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-semibold mb-4">All Reviews</h1>

        <ul>
            @foreach($reviews as $review)
                <li class="mb-4 p-4 border-b border-gray-300">
                    <!-- Display the pet's name -->
                    <strong>Pet Name:</strong> {{ $review->pet->naam }} <br>
                    <strong>Rating:</strong> {{ $review->rating }} <br>
                    <strong>Review:</strong> {{ $review->body }} <br>
                    <hr class="my-2">
                </li>
            @endforeach
        </ul>
    </div>
@endsection
