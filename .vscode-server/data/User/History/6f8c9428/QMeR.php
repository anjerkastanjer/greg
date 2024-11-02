@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inloggen</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mailadres</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('register') }}">Nog geen account? Registreer hier.</a>
    </div>
</div>
@endsection

