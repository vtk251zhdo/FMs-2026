@extends('layouts.game')

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="mb-4">{{ $club->ClubName }} {{ __('app.facilities.title') }}</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('app.club.stadium') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $club->Stadium }}</h6>
                        <p class="text-muted">
                            <strong>{{ __('app.club.location') }}:</strong> {{ $club->City }}, {{ $club->Country }}
                        </p>
                        <div class="mt-3">
                            <small class="text-muted">{{ __('app.facilities.upgrades_coming') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">{{ __('app.facilities.training') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>{{ __('app.facilities.academy') }}</h6>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 75%"></div>
                            </div>
                            <small class="text-muted">{{ __('app.facilities.level') }} 7/10</small>
                        </div>
                        <div class="mb-3">
                            <h6>{{ __('app.facilities.medical') }}</h6>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                            <small class="text-muted">{{ __('app.facilities.level') }} 8/10</small>
                        </div>
                        <div class="mb-3">
                            <h6>{{ __('app.facilities.youth') }}</h6>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 60%"></div>
                            </div>
                            <small class="text-muted">{{ __('app.facilities.level') }} 6/10</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">{{ __('app.club.overview') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <h6 class="text-muted">{{ __('app.finances.budget') }}</h6>
                            <h4>${{ number_format($club->Budget, 0) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <h6 class="text-muted">{{ __('app.club.squad_value') }}</h6>
                            <h4>${{ number_format($club->getTotalSquadValue(), 0) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <h6 class="text-muted">{{ __('app.player.average_rating') }}</h6>
                            <h4>{{ $club->getAverageRating() }}/10</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <h6 class="text-muted">{{ __('app.club.squad_size') }}</h6>
                            <h4>{{ $club->players()->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection