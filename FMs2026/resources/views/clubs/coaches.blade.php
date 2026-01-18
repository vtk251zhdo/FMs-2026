@extends('layouts.game')

@section('title', __('app.club.coaches_title'))

@section('content')
    <div class="mb-30">
        <h2>{{ __('app.club.coaches_title') }} - {{ $club->ClubName }}</h2>
    </div>

    <div class="row">
        @forelse($coaches as $coach)
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white"
                        style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);">
                        <h5 class="mb-0">{{ $coach->FullName }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>{{ __('app.player.position') }}:</strong> {{ $coach->Role }}</p>
                        <p><strong>{{ __('app.player.age') }}:</strong> {{ $coach->Age }}</p>
                        <p><strong>{{ __('app.transfers.club') }}:</strong> {{ $coach->club->ClubName }}</p>

                        <div class="mt-15">
                            <a href="#" class="btn btn-sm btn-outline-danger">{{ __('app.coach.fire') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    {{ __('app.coach.no_coaches') }}
                </div>
            </div>
        @endforelse
    </div>
@endsection