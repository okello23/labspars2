<x-app-layout>
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    @include('layouts.messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Roles Assignment
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="roleAssignment" class="table table-striped table-bordered mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">Name</th>
                                    <th class="th">Roles</th>
                                    <th class="th">Non Default Permissions</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $user->fullName ?? 'The model doesn\'t have a `name` attribute' }}
                                        </td>
                                        <td>
                                            {{ $user->roles_count }}
                                        </td>
                                        @if (config('laratrust.panel.assign_permissions_to_user'))
                                            <td>
                                                {{ $user->permissions_count }}
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('user-roles-assignment.edit', $user->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Assign"
                                                class="action-ico btn btn-outline-success mx-1"> <i
                                                    class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    @push('scripts')
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#roleAssignment').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#roleAssignment_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
