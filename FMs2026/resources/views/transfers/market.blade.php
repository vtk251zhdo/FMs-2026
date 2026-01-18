@extends('layouts.game-2')

@section('title', __('app.transfers.market'))

@section('content')
    <div class="mb-30">
        <h2>{{ __('app.transfers.transfer_market') }}</h2>
        <p class="text-muted">{{ __('app.finances.budget') }}:
            <strong>${{ number_format($club->Budget, 0, ',', ' ') }}</strong>
        </p>
    </div>

    <div class="row">
        @forelse($players as $player)
            <div class="col-md-6 col-lg-4 mb-20">
                <div class="player-card">
                    <div class="d-flex justify-content-between align-items-start mb-10">
                        <div>
                            <h6 class="mb-1"><strong>{{ $player->FullName }}</strong></h6>
                            <small class="text-muted">{{ $player->Position }}</small>
                        </div>
                        <span class="player-rating" data-rating="{{ $player->Rating }}">
                            {{ $player->Rating }}
                        </span>
                    </div>

                    <p class="mb-10"><strong>${{ number_format($player->Value, 0, ',', ' ') }}</strong></p>

                    <form method="POST" action="{{ route('transfers.buy', $player->PlayerID) }}" class="mb-10">
                        @csrf
                        <div class="input-group">
                            <input type="number" name="offer_amount" class="form-control form-control-sm"
                                placeholder="{{ __('app.transfers.offer') }} ($)" min="0" value="{{ $player->Value }}" required>
                            <button class="btn btn-primary btn-sm" type="submit">{{ __('app.transfers.buy') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">{{ __('app.transfers.no_available_players') }}</div>
            </div>
        @endforelse
    </div>

    @if ($players->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination mb-0">

                    <li class="page-item {{ $players->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $players->previousPageUrl() ?? '#' }}">
                            ←
                        </a>
                    </li>

                    <li class="page-item active">
                        <span class="page-link">
                            {{ $players->currentPage() }}
                        </span>
                    </li>

                    <li class="page-item {{ $players->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $players->nextPageUrl() ?? '#' }}">
                            →
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif

@endsection