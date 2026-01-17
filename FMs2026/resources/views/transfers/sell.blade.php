@extends('layouts.game')

@section('title', 'Продати гравців')

@section('content')
<div class="mb-30">
    <h2>Продати гравців</h2>
    <p class="text-muted">Поточний бюджет: <strong>${{ number_format($club->Budget, 0, ',', ' ') }}</strong></p>
</div>

<div class="row">
    @forelse($players as $player)
    <div class="col-md-6 col-lg-4 mb-20">
        <div class="player-card">
            <div class="d-flex justify-content-between align-items-start mb-10">
                <div>
                    <h6 class="mb-1"><strong>{{ $player->FullName }}</strong></h6>
                    <small class="text-muted">{{ $player->Position }} (#{{ $player->Number }})</small>
                </div>
                <span class="badge-rating {{ $player->Rating >= 8 ? 'high' : 'medium' }}">
                    {{ $player->Rating }}
                </span>
            </div>

            <p class="mb-10">
                <strong>Поточна вартість:</strong><br>
                ${{ number_format($player->Value, 0, ',', ' ') }}
            </p>

            <form method="POST" action="{{ route('transfers.sell-player', $player->PlayerID) }}" class="mb-10">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Запрошена ціна ($)</label>
                    <input type="number" name="sell_price" class="form-control form-control-sm" 
                           placeholder="Ціна продажу" min="0" value="{{ $player->Value }}" required>
                </div>
                <button class="btn btn-danger w-100 btn-sm" type="submit">Продати</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            У клубі немає гравців для продажу.
        </div>
    </div>
    @endforelse
</div>

<div class="mt-20">
    <a href="{{ route('transfers.market') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Повернутися на ринок
    </a>
</div>
@endsection
