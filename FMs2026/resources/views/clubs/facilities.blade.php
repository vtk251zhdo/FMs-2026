@extends('layouts.game')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">{{ $club->ClubName }} Facilities</h1>
        </div>
    </div>
    
    <div class="row">
        <!-- Stadium Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Stadium</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $club->Stadium }}</h6>
                    <p class="text-muted">
                        <strong>Location:</strong> {{ $club->City }}, {{ $club->Country }}
                    </p>
                    <div class="mt-3">
                        <small class="text-muted">Stadium upgrades coming soon...</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Training Facilities -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Training Facilities</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Academy Quality</h6>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 75%"></div>
                        </div>
                        <small class="text-muted">Level 7/10</small>
                    </div>
                    <div class="mb-3">
                        <h6>Medical Facilities</h6>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                        <small class="text-muted">Level 8/10</small>
                    </div>
                    <div class="mb-3">
                        <h6>Youth Development</h6>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                        <small class="text-muted">Level 6/10</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Club Information -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Club Overview</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center mb-3">
                        <h6 class="text-muted">Total Budget</h6>
                        <h4>${{ number_format($club->Budget, 0) }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center mb-3">
                        <h6 class="text-muted">Squad Value</h6>
                        <h4>${{ number_format($club->getTotalSquadValue(), 0) }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center mb-3">
                        <h6 class="text-muted">Average Rating</h6>
                        <h4>{{ $club->getAverageRating() }}/10</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center mb-3">
                        <h6 class="text-muted">Squad Size</h6>
                        <h4>{{ $club->players()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
