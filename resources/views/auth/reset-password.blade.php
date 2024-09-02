@extends('layouts.guest')
@section('title', 'Reset password')
@section('content')
    <div class="card mt-5 mt-lg-0">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                        <img src="{{ asset('assets/images/merp-logo.png') }}" alt="" style="width: 50%">
                    </div>
                    <h5 class="card-title">{{ __('public.createnewpass') }}</h5>
                    <p class="card-text mb-1">
                        {{ __('We received your reset password request. Please enter your new password!') }}</p>
                </div>
                <div class="form-body">
                    <form class="row g-3" method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        @include('layouts.messages')
                        <div class="col-12">
                            <x-label for="inputEmailAddress">{{ __('public.email') }}</x-label>
                            <input type="email" class="form-control" id="inputEmailAddress" name="email"
                                value="{{ old('email', $request->email) }}" required>
                        </div>
                        <div class="col-12">
                            <x-label for="inputChoosePassword">
                                New Password</x-label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0" id="inputNewPassword"
                                    placeholder="Enter New Password" name="password" required autofocus>
                            </div>
                        </div>
                        <div class="col-12">
                            <x-label for="inputChoosePassword">
                                Confirm Password</x-label>
                            <div class="input-group" id="show_hide_password2">
                                <input type="password" class="form-control border-end-0" id="inputConfirmPassword"
                                    placeholder="Confirm Password" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid">
                                <x-button class="btn-success">{{ __('Change Password') }}</x-button>
                                <a href="{{ route('login') }}"
                                        class="btn  btn-light ">{{ __('public.backtologin') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer-->
    <footer>
        <div class="col-md-12 text-center">
            <script>
                document.write(new Date().getFullYear())
            </script> © Kampala Capital City Authority (KCCA)
        </div>
    </footer>
@endsection
