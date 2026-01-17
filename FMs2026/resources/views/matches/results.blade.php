@extends('layouts.game')

@section('title', 'Матчі - Результати')

@section('content')
<div class="mb-30">
    <h2>Результати матчів</h2>
</div>

<div class="row">
    @forelse($matches as $match)
    <div class="col-md-6 mb-20">
        <div class="match-result-card">
            <div class="match-header">
                <small class="text-muted">{{ $match->MatchDate?->format('d.m.Y H:i') }}</small>
                <span class="badge bg-success">Завершений</span>
            </div>
            <div class="match-body">
                <div class="row align-items-center">
                    <div class="col-4 text-end">
                        <p class="mb-0"><strong>{{ $match->homeClub->ClubName }}</strong></p>
                        <small class="text-muted">Дома</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="mb-0">{{ $match->ScoreHome }}:{{ $match->ScoreAway }}</h3>
                        @php
                        $result = $match->getResult();
                        @endphp
                        @if($result === 'HomeWin')
                            <small class="badge bg-success">Перемога дома</small>
                        @elseif($result === 'AwayWin')
                            <small class="badge bg-danger">Перемога гостей</small>
                        @else
                            <small class="badge bg-info">Нічия</small>
                        @endif
                    </div>
                    <div class="col-4">
                        <p class="mb-0"><strong>{{ $match->awayClub->ClubName }}</strong></p>
                        <small class="text-muted">Гості</small>
                    </div>
                </div>
            </div>
            <div class="match-footer">
                <a href="{{ route('matches.detail', $match->MatchID) }}" class="btn btn-sm btn-primary">
                    Деталі
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            Немає завершених матчів
        </div>
    </div>
    @endforelse
</div>

<style>
.match-result-card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 15px;
}

.match-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.match-body {
    margin: 15px 0;
}

.match-footer {
    display: flex;
    gap: 5px;
}

.match-footer .btn {
    flex: 1;
}

                </div>

                <div class="row mt-15 text-center">
                    <div class="col-6">
                        <small>Глядачів: {{ number_format($match->Attendance ?? 0) }}</small>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('matches.detail', $match->MatchID) }}" class="btn btn-sm btn-primary">
                            Деталі
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Матчів поки немає
        </div>
    </div>
    @endforelse
</div>
@endsection
