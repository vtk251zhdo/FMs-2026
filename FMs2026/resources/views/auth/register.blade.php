@extends('layouts.game')

@section('title', __('app.auth.register_title'))

@section('content')
    <div class="row justify-content-center mt-50">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-success text-white text-center"
                    style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);">
                    <h4 class="mb-0">{{ __('app.auth.register_title') }}</h4>
                </div>

                <div class="card-body p-30">
                    <form method="POST" action="/register">
                        @csrf

                        <div class="mb-15">
                            <label class="form-label">{{ __('app.auth.username') }}</label>
                            <input name="username" class="form-control" required>
                        </div>

                        <div class="mb-15">
                            <label class="form-label">{{ __('app.auth.email') }}</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>

                        <div class="mb-20">
                            <label class="form-label">{{ __('app.auth.password') }}</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn w-100"
                            style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%); color: white; margin-top: 20px;">
                            {{ __('app.auth.register_btn') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <small>
                        {{ __('app.auth.have_account') }}
                        <a href="/login">{{ __('app.auth.login_link') }}</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection