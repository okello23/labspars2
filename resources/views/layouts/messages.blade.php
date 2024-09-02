@if (count($errors) > 0)

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger border-1 alert-dismissible fade show">
            <span class="fw-semibold">{{ $error }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endforeach

@endif

@if (session('success'))
    <div class="alert alert-success border-1 alert-dismissible fade show">
        <span class="fw-semibold">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-warning border-1 alert-dismissible fade show">
        <span class="fw-semibold">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
