<x-app-layout>
    <!-- end row-->
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Edit Roles Assignment
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('user-roles-assignment.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    value="{{ $user->name }}" required readonly>
                            </div>
                        </div>
                        @if (!$roles->isEmpty())
                            <div class="row mb-3">
                                <h6 class="text-success">Roles</h6>
                                @foreach ($roles as $role)
                                    <div class="mb-3 col-md-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="role{{ $role->id }}"
                                                name="roles[]" value="{{ $role->id }}" {!! $role->assigned ? 'checked' : '' !!}
                                                {!! $role->assigned && !$role->isRemovable ? 'onclick="return false;"' : '' !!}>
                                            <label class="form-check-label"
                                                for="role{{ $role->id }}">{{ $role->display_name ?? $role->name }}</label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                        @if (!$permissions->isEmpty())
                            <h5>Permissions</h5>
                            <hr>
                            <div class="accordion" id="accordionPermissions">
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
                                        <div  id="collapse{{ str_replace(' ', '',$module) }}"
                                            class="collapse @if ($loop->first) show @endif"
                                            aria-labelledby="heading{{ str_replace(' ', '',$module) }}"
                                            data-parent="#accordionPermissions">
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
