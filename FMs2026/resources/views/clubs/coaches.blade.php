@extends('layouts.game')

@section('title', 'Тренери')

@section('content')
<div class="mb-30">
    <h2>Тренери - {{ $club->ClubName }}</h2>
</div>

<div class="row">
    @forelse($coaches as $coach)
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $coach->FullName }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Посада:</strong> {{ $coach->Role }}</p>
                <p><strong>Вік:</strong> {{ $coach->Age }}</p>
                <p><strong>Клуб:</strong> {{ $coach->club->ClubName }}</p>

                <div class="mt-15">
                    <a href="#" class="btn btn-sm btn-outline-danger">Звільнити</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            У клубі немає тренерів.
        </div>
    </div>
    @endforelse
</div>
@endsection
