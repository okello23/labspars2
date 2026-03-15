@extends('layouts.guest')
@section('title', 'Self Enroll')

{{-- Select2 CSS pushed into <head> --}}
@push('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="card-body shadow p-3 mb-5">
    <div class="header">
        <h2>Lab SPARS</h2>
        <p>Create your account &mdash; pending admin approval</p>
    </div>

    <div class="body">
        @include('layouts.messages')

        <form class="form-auth-small" method="POST" action="{{ route('register.user') }}">
            @csrf

            {{-- Title + Surname + First Name --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select name="title" required
                            class="form-control @error('title') is-invalid @enderror">
                        <option value="">Title *</option>
                        @foreach ($titles as $t)
                            <option value="{{ $t }}" {{ old('title') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8 mb-3">
                    <div class="input-group">
                        <input type="text" name="surname" value="{{ old('surname') }}"
                               placeholder="Surname *" required
                               class="form-control @error('surname') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fa fa-user"></span></div>
                        </div>
                        @error('surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="input-group">
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                               placeholder="First Name *" required
                               class="form-control @error('first_name') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fa fa-user"></span></div>
                        </div>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Other Name --}}
            <div class="input-group mb-3">
                <input type="text" name="other_name" value="{{ old('other_name') }}"
                       placeholder="Other Name (optional)"
                       class="form-control @error('other_name') is-invalid @enderror">
                <div class="input-group-append">
                    <div class="input-group-text"><span class="fa fa-user-o"></span></div>
                </div>
            </div>

            {{-- Email --}}
            <div class="input-group mb-3">
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Email Address *" required
                       class="form-control @error('email') is-invalid @enderror">
                <div class="input-group-append">
                    <div class="input-group-text"><span class="fa fa-envelope"></span></div>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="input-group mb-3">
                <input type="text" name="contact" value="{{ old('contact') }}"
                       placeholder="Phone Number *" required
                       class="form-control @error('contact') is-invalid @enderror">
                <div class="input-group-append">
                    <div class="input-group-text"><span class="fa fa-phone"></span></div>
                </div>
                @error('contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Facility — Select2 searchable (no input-group wrapper) --}}
                       {{-- Facility — Select2 with icon --}}
            <div class="input-group select2-facility mb-3">
                <select name="facility_id" id="facilitySelect" required
                        class="@error('facility_id') is-invalid @enderror">
                    <option value="">-- Select Facility / Lab *--</option>
                    @foreach ($facilities as $facility)
                        <option value="{{ $facility->id }}"
                            {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                            {{ $facility->name }} {{ $facility->level }}
                        </option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <div class="input-group-text"><span class="fa fa-home"></span></div>
                </div>
                @error('facility_id')
                    <div class="text-danger small mt-1 w-100">{{ $message }}</div>
                @enderror
            </div>
            {{-- Info notice --}}
            <div class="alert alert-info py-2 small mb-3">
                <i class="fa fa-info-circle"></i>
                Once approved by an administrator, your login credentials will be sent to your
                email address. No password is required at this stage.
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">
                Submit Enrollment Request
            </button>

            <div class="bottom mt-2">
                <span class="helper-text m-b-10">
                    <i class="fa fa-arrow-left"></i>
                    <a href="{{ route('login') }}">Back to Login</a>
                </span>
            </div>

        </form>
    </div>
</div>

<div class="col-md-12 text-center">
    <script>document.write(new Date().getFullYear())</script>
    &copy; Central Public Health Laboratories (CPHL)
</div>

@endsection

{{-- Select2 JS + init — pushed after jQuery bundles --}}
@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#facilitySelect').select2({
            placeholder: '-- Select Facility / Lab --',
            allowClear: true,
            width: '87.5%',
        });
    });
</script>
@endpush