@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success border-1 alert-dismissible fade show']) }}>
        <span class="fw-semibold"> {{ $status }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
