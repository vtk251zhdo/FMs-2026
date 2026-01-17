@extends('layouts.game')

@section('title', 'Гравці клубу')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-30">
    <h2>Гравці - {{ $club->ClubName }}</h2>
    <a href="{{ route('transfers.market') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Купити гравця
    </a>
</div>

<div class="row">
    @forelse($players as $player)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">{{ $player->FullName }}</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>Позиція:</strong> {{ $player->Position }}<br>
                    <strong>Номер:</strong> {{ $player->Number }}<br>
                    <strong>Вік:</strong> {{ $player->Age }}<br>
                    <strong>Рейтинг:</strong> 
                    @if($player->Rating >= 8.0)
                        <span class="badge bg-success">{{ $player->Rating }}/10</span>
                    @elseif($player->Rating >= 6.5)
                        <span class="badge bg-warning">{{ $player->Rating }}/10</span>
                    @else
                        <span class="badge bg-danger">{{ $player->Rating }}/10</span>
                    @endif
                </p>
                <p><strong>Вартість:</strong> ${{ number_format($player->Value, 0) }}</p>
                
                <div class="mt-3">
                    <a href="{{ route('club.player', $player->PlayerID) }}" class="btn btn-sm btn-outline-primary">
                        Детальніше
                    </a>
                    <a href="{{ route('transfers.sell') }}" class="btn btn-sm btn-outline-danger">
                        Продати
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> У клубу поки немає гравців. <a href="{{ route('transfers.market') }}">Придбати гравців</a>
        </div>
    </div>
    @endforelse
</div>
@endsection
