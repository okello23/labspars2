@extends('layouts.guest')
@section('title', 'Self Enrollment')
@section('content')

<div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="header">
    <p class="lead">Self Enrollment</p>
  </div>
  <div class="card mt-5 mt-lg-0">
    <div class="card-body">
      @include("layouts.messages")
      <div class="border p-4 rounded">
        <div class="text-center">
          <span
          class="d-block text-muted"><b>Its a breeze, Lets walk through.</b> Fill in the form with all required information,
          upon approval by the administrator, an email will be sent to your registered email address with your login credentials.</span>
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
  @include('auth.inc.self-enroll-modal')

  @endsection
