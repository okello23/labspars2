<x-app-layout>

    <div class="row">
        @include('layouts.messages')
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Edit {{ Str::ucfirst($type) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ $model ? route("user-{$type}s.update", $model->id) : route("user-{$type}s.store") }}">
                        @csrf
                        @if ($model)
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Name/Code</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    value="{{ $model->name }}" placeholder="this-will-be-the-code-name" required
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="display_name" class="form-label">Display Name</label>
                                <input type="text" id="display_name" class="form-control" name="display_name"
                                    value="{{ $model->display_name }}" placeholder="Edit user profile" required>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="email" id="description" class="form-control" name="description"
                                    placeholder="Some description for the {{ $type }}">{{ $model->description ?? old('description') }}</textarea>
                            </div>
                        </div>
                        @if ($type == 'role')
                            <h5>Permissions</h5>
                            <hr>
                            <div class="accordion" id="accordionTrainer">
                                @forelse ($permissions as $module => $user_permissions)
                                    <div class="accordion-item">
                                        <h6 class="accordion-header" id="heading{{ str_replace(' ', '',$module) }}">
                                            <button class="btn btn-block btn-outline-success" type="button"
                                                data-toggle="collapse"
                                                data-target="#collapse{{ str_replace(' ', '',$module) }}"
                                                aria-expanded="true"
                                                aria-controls="collapse{{ str_replace(' ', '',$module) }}">
                                                {{ $module }}
                                               
                                            </button>
                                        </h6>
                                        <div id="collapse{{ str_replace(' ', '',$module) }}"
                                            class="accordion-collapse collapse @if ($loop->first) show @endif"
                                            aria-labelledby="heading{{ str_replace(' ', '',$module) }}"
                                            data-parent="#accordionTrainer">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    {{-- <h6 class="text-success">{{ $module }}</h6> --}}
                                                    @foreach ($user_permissions as $permission)
                                                        <div class="mb-3 col-md-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="permission{{ $permission->id }}" name="permissions[]"
                                                                    value="{{ $permission->id }}" {!! $permission->assigned ? 'checked' : '' !!}>
                                                                <label class="form-check-label"
                                                                    for="permission{{ $permission->id }}">{{ $permission->display_name ?? $permission->name }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        @endif
                        <!-- end row-->
                        <div class="modal-footer">
                            <x-button class="btn-success">{{ __('Save') }}</x-button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-app-layout>
