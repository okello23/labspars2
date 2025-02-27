<x-app-layout>
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <!-- end row-->
    <div class="row">
        <div class="col-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    User Permissions
                                </h5>
                                {{-- <div class="ms-auto">
                                    <a type="button" href="#" class="btn btn-success mb-2 me-1"
                                        data-bs-toggle="modal" data-bs-target="#addPermission"><i
                                            class="fa fa-plus"></i>New</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="permissionsTable" class="table table-striped table-bordered mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th class="th">Name</th> -->
                                    <th class="th">User Permission</th>
                                    <th class="th">Description</th>
                                    <th class="th">Target Module</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <!-- <td>
                                            {{ $permission->name }}
                                        </td> -->
                                        <td>
                                            {{ $permission->display_name }}
                                        </td>
                                        <td>
                                            {{ $permission->description }}
                                        </td>
                                        <td>
                                            {{ $permission->target_module }}
                                        </td>
                                        <td class="table-action">
                                            <a href="{{ route('user-permissions.edit', $permission->id) }}"
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
    {{-- @include('livewire.user-management.access.createPermissionModal') --}}
    @push('scripts')
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#permissionsTable').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#permissionsTable_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
