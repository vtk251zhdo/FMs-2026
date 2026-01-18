@extends('layouts.game')

@section('title', __('app.auth.login_title'))

@section('content')
    <div class="row justify-content-center mt-50">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white text-center"
                    style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);">
                    <h4 class="mb-0">{{ __('app.auth.login_title') }}</h4>
                </div>

                <div class="card-body p-30">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-15">
                            <label class="form-label">{{ __('app.auth.username') }}</label>
                            <input name="username" class="form-control" required>
                        </div>

                        <div class="mb-20">
                            <label class="form-label">{{ __('app.auth.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn w-100"
                            style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%); color: white; margin-top: 20px;">
                            {{ __('app.auth.login_btn') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <small>
                        {{ __('app.auth.no_account') }}
                        <a href="/register">{{ __('app.auth.register_link') }}</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection