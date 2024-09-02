@extends('layouts.guest')
@section('title', 'Register Application')
@section('content')

<div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="header">
    <p class="lead">Register Your Application</p>
  </div>
  <div class="card mt-5 mt-lg-0">
    <div class="card-body">
      @include("layouts.messages")
      <div class="border p-4 rounded">
        <div class="text-center">
          <span
          class="d-block text-muted"><b>Its a breeze, Lets walk through.</b> Just let us know your
          Application Name, System adminitrator's email address, Vendor/Owner, Purpose for integration,
          Password, mode of access and your application url or IP Address  and we will email you an integration guide
          and Token upon approval.</span>
        </div>
        <div class="form-body">
          @csrf
          <x-auth-session-status class="mb-4" :status="session('status')" />
          <div class="col-12">
            <br>
            <span class="helper-text m-b-10"><i class="fa fa-chain"></i>
              <a href="#" data-toggle="modal" data-target="#registerApplication">Open Registration Form</a></span>
            </div>

            <div class="d-grid">
              <a href="{{ route('login') }}"
              class="btn  btn-light ">{{ __('public.backtologin') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('auth.inc.register-application-modal')

  @endsection
