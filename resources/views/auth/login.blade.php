@extends('layouts.guest')
@section('title', 'Login')
@section('content')


  <div class="card-body shadow p-3 mb-5">
    <div class="header">
      <a class="navbar-brand"><img src="{{ asset('/images/moh.png') }}" width="250px"

        class="d-inline-block align-bottom" alt="Lab Spars"></a>
      <h2>Lab SPARS</h2>
      <p>Log in to continue</p>
    </div>

    <div class="body">
        @include("layouts.messages")
        <form class="form-auth-small" id="loginform" method="POST" action="{{ route('user.login') }}">

          <div class="input-group mb-3">
                      <input type="email" name="email" value="{{ old('email') }}" id="emailaddress" required="" placeholder="Email" autofocus  class="form-control @error('email') is-invalid @enderror">
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fa fa-envelope"></span></div>
                      </div>
                  </div>

          <div class="input-group mb-3">
                      <input class="form-control" type="password" id="password" placeholder="Enter your password" name="password" required autocomplete="current-password">
                      <div class="input-group-append">
                          <div class="input-group-text"><span class="fa fa-lock"></span></div>
                      </div>
                  </div>
                    @csrf

            <div class="form-group clearfix">
                <label class="fancy-checkbox element-left">
                    <input type="checkbox">
                    <span>Remember me</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
            <div class="bottom">

                <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{route('password.request')}}">Forgot password?</a></span>
                <span class="helper-text m-b-10"><i class="fa fa-chain"></i> <a href="{{route('register.application')}}">Register 3rd Party Application</a></span>

            </div>
        </form>
    </div>
</div>
<div class="col-md-12 text-center">
  <script>document.write(new Date().getFullYear())</script> © Central Public Health Laboratories (CPHL)
</div>
@endsection
