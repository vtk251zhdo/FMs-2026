@extends('layouts.game')

@section('title', 'Вибір клубу')

@section('content')
    <h2>Оберіть клуб</h2>

    <form method="POST" action="/choose-club">
        @csrf

        <select name="club_id">
            @foreach($clubs as $club)
                <option value="{{ $club->ClubID }}">
                    {{ $club->ClubName }} ({{ $club->Country }})
                </option>
            @endforeach
        </select>

        <br><br>
        <button>Почати гру</button>
    </form>
@endsection
