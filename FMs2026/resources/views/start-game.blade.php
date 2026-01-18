@extends('layouts.game')

@section('title', __('app.game.start_title'))

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4">{{ __('app.game.select_club') }}</h1>

                @if($clubs->isEmpty())
                    <div class="alert alert-info">
                        {{ __('app.game.no_clubs') }}
                    </div>
                @else
                    <form method="POST" action="/start-game">
                        @csrf
                        <div class="row">
                            @foreach($clubs as $club)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $club->ClubName }}</h5>
                                            <p class="card-text">
                                                <small class="text-muted">{{ $club->City }}, {{ $club->Country }}</small>
                                            </p>
                                            <p>
                                                <strong>{{ __('app.club.stadium') }}:</strong> {{ $club->Stadium }}<br>
                                                <strong>{{ __('app.game.budget') }}:</strong> ${{ number_format($club->Budget, 0) }}
                                            </p>
                                            <button type="submit" name="club_id" value="{{ $club->ClubID }}"
                                                class="btn btn-primary w-100">
                                                {{ __('app.game.start_career') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection