@extends('layouts.game')

@section('title', 'Тактика')

@section('content')
<div class="mb-30">
    <h2 class="mb-20">Управління тактикою</h2>
    
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTacticModal">
        <i class="bi bi-plus-circle"></i> Нова тактика
    </button>
</div>

@if($activeTactic)
<div class="alert alert-success mb-20">
    <strong>Активна тактика:</strong> {{ $activeTactic->FormationName }} 
    ({{ $activeTactic->TacticStyle }})
</div>
@endif

<div class="row">
    @forelse($tactics as $tactic)
    <div class="col-md-6 mb-20">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    {{ $tactic->FormationName }}
                    @if($tactic->IsActive)
                        <span class="badge bg-success float-end">Активна</span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Стиль:</strong> {{ $tactic->TacticStyle }}</p>
                <p><strong>Темп:</strong> <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: {{ $tactic->Tempo }}%"></div></div></p>
                <p><strong>Ширина:</strong> <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: {{ $tactic->Width }}%"></div></div></p>
                <p><strong>Агресивність:</strong> <div class="progress" style="height: 10px;"><div class="progress-bar bg-danger" style="width: {{ $tactic->Aggression }}%"></div></div></p>
            </div>
            <div class="card-footer">
                @if(!$tactic->IsActive)
                    <form method="POST" action="{{ route('tactics.activate', $tactic->TacticID) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Активувати</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('tactics.destroy', $tactic->TacticID) }}" class="d-inline" onsubmit="return confirm('Видалити?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Видалити</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Тактик поки немає. Створіть нову!</div>
    </div>
    @endforelse
</div>

<!-- Modal for creating tactic -->
<div class="modal fade" id="createTacticModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Створити тактику</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('tactics.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Формація</label>
                        <select name="formation_name" class="form-control" required>
                            <option value="4-3-3">4-3-3</option>
                            <option value="4-2-3-1">4-2-3-1</option>
                            <option value="3-5-2">3-5-2</option>
                            <option value="5-3-2">5-3-2</option>
                            <option value="3-4-3">3-4-3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Стиль</label>
                        <select name="tactic_style" class="form-control" required>
                            <option value="Defensive">Захисна</option>
                            <option value="Balanced">Збалансована</option>
                            <option value="Attacking">Атакуюча</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Темп (0-100)</label>
                        <input type="range" name="tempo" class="form-range" min="0" max="100" value="50" required>
                        <small class="text-muted">Значення: <span id="tempoValue">50</span></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ширина (0-100)</label>
                        <input type="range" name="width" class="form-range" min="0" max="100" value="50" required>
                        <small class="text-muted">Значення: <span id="widthValue">50</span></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Агресивність (0-100)</label>
                        <input type="range" name="aggression" class="form-range" min="0" max="100" value="50" required>
                        <small class="text-muted">Значення: <span id="aggressionValue">50</span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                    <button type="submit" class="btn btn-primary">Створити</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('input[name="tempo"]').addEventListener('input', (e) => {
    document.getElementById('tempoValue').textContent = e.target.value;
});
document.querySelector('input[name="width"]').addEventListener('input', (e) => {
    document.getElementById('widthValue').textContent = e.target.value;
});
document.querySelector('input[name="aggression"]').addEventListener('input', (e) => {
    document.getElementById('aggressionValue').textContent = e.target.value;
});
</script>
@endpush

@endsection
