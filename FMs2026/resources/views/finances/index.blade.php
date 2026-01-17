@extends('layouts.game')

@section('title', 'Фінанси')

@section('content')
<div class="mb-30">
    <h2>Фінансовий звіт - {{ $club->ClubName }}</h2>
</div>

<div class="stats-grid">
    <div class="stat-box">
        <small>Поточний бюджет</small>
        <strong style="color: var(--success);">${{ number_format($currentBudget, 0, ',', ' ') }}</strong>
        <small>Доступні кошти</small>
    </div>
    <div class="stat-box">
        <small>Видатки на трансфери</small>
        <strong style="color: var(--danger);">${{{ number_format($transferSpending, 0, ',', ' ') }}}</strong>
        <small>Цей сезон</small>
    </div>
    <div class="stat-box">
        <small>Доходи від трансферів</small>
        <strong style="color: var(--info);">${{ number_format($transferIncome, 0, ',', ' ') }}</strong>
        <small>Цей сезон</small>
    </div>
    <div class="stat-box">
        <small>Вартість складу</small>
        <strong>${{ number_format($squadValue, 0, ',', ' ') }}</strong>
        <small>Ринкова вартість</small>
    </div>
</div>

<div class="row mt-30">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Трансферна активність</h5>
            </div>
            <div class="card-body">
                <div class="mb-20">
                    <p class="mb-10"><strong>Видатки:</strong> ${{ number_format($transferSpending, 0, ',', ' ') }}</p>
                    <small class="text-muted">Витрачено на придбання гравців</small>
                </div>
                <div class="mb-20">
                    <p class="mb-10"><strong>Доходи:</strong> ${{ number_format($transferIncome, 0, ',', ' ') }}</p>
                    <small class="text-muted">Отримано від продажу гравців</small>
                </div>
                <div class="mb-0">
                    <p class="mb-10"><strong>Чистий видаток:</strong> 
                        <span style="color: {{ $netSpending > 0 ? '#e74c3c' : '#2ecc71' }};">
                            ${{ number_format($netSpending, 0, ',', ' ') }}
                        </span>
                    </p>
                    <small class="text-muted">Різниця видатків та доходів</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Останні трансфери</h5>
            </div>
            <div class="card-body">
                @forelse($recentTransfers->take(5) as $transfer)
                <div class="mb-10 pb-10" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <p class="mb-1"><strong>{{ $transfer->player->FullName }}</strong></p>
                    <small>
                        {{ $transfer->fromClub->ClubName }} 
                        <i class="bi bi-arrow-right"></i> 
                        {{ $transfer->toClub->ClubName }}
                    </small><br>
                    <small style="color: var(--success);">
                        ${{ number_format($transfer->TransferFee, 0, ',', ' ') }} - 
                        {{ $transfer->TransferDate->format('d.m.Y') }}
                    </small>
                </div>
                @empty
                <p class="text-muted">Немає трансфертів у цьому сезоні</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.stat-box {
    background: linear-gradient(135deg, rgba(100, 200, 255, 0.2), rgba(150, 100, 200, 0.2));
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-box strong {
    display: block;
    font-size: 24px;
    margin: 10px 0;
}

.card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
}

.card-header {
    background: rgba(0, 0, 0, 0.3) !important;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Фінансовий Статус</h5>
            </div>
            <div class="card-body">
                @if($currentBudget > $squadValue * 0.5)
                    <p class="text-success"><i class="bi bi-check-circle"></i> Ваш клуб в хорошому фінансовому стані</p>
                @elseif($currentBudget > $squadValue * 0.25)
                    <p class="text-warning"><i class="bi bi-exclamation-triangle"></i> Слідкуйте за видатками</p>
                @else
                    <p class="text-danger"><i class="bi bi-x-circle"></i> Обмежені фінансові ресурси</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
