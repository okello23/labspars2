@extends('layouts.guest')
@section('title', 'Forgot password')
@section('content')


  <div class="card-body shadow p-3 mb-5 bg-transparent rounded">
    <div class="header">
        <p class="lead">Forgot Password</p>
    </div>
        <div class="card mt-5 mt-lg-0">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="text-center">
                        <span
                            class="d-block text-muted">{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</span>
                    </div>
                    <div class="form-body">
                        <form class="row g-3" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            @include('layouts.messages')
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="col-12">
                                <x-label for="inputEmailAddress" class="fw-bold">{{ __('public.email') }}</x-label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required autofocus autocomplete="off">
                            </div>

                            <div class="col-12 mt-2">
                                <div class="d-grid">
                                    <x-button class="btn-success">{{ __('public.sendlink') }}</x-button>
                                    <a href="{{ route('login') }}"
                                        class="btn  btn-light ">{{ __('public.backtologin') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer-->
    <footer>
        <div class="col-md-12 text-center">
            <script>document.write(new Date().getFullYear())</script> © Central Public Health Laboratory Services (CPHL)
        </div>
    </footer>
@endsection
