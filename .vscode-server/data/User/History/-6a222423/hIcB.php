h1>Jouw Huisdieren</h1>

<ul>
    @foreach ($pets as $pet)
        <li>
            <strong>Naam:</strong> {{ $pet->name }} <br>
            <strong>Soort:</strong> {{ $pet->type }} <br>
            <strong>Prijs per uur:</strong> €{{ $pet->hourly_rate }} <br>
            <strong>Begindatum:</strong> {{ $pet->start_date }}
        </li>
    @endforeach
</ul>