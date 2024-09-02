<x-app-layout>
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <div class="row">
        <div class="col-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    User Roles
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" href="#" class="btn btn-success mb-2 me-1"
                                        data-toggle="modal" data-target="#addRole"><i
                                            class="fa fa-plus"></i>New</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rolesTable" class="table table-striped table-bordered mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">Display Name</th>
                                    <th class="th">Name</th>
                                    <th class="th"># Permissions</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role->display_name }}</td>
                                        <td> {{ $role->name }}</td>
                                        <td>{{ $role->permissions_count }}</td>
                                        <td class="table-action d-flex">
                                            @if (\Laratrust\Helper::roleIsEditable($role))
                                                <a href="{{ route('user-roles.edit', $role->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit"
                                                    class="action-ico btn btn-outline-success mx-1">
                                                    <i class="fa fa-edit"></i></a>
                                            @else
                                                <a href="{{ route('user-roles.show', $role->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="View"
                                                    class="action-ico btn btn-outline-success">
                                                    <i class="fa fa-eye"></i></a>
                                            @endif

                                            <form action="{{ route('user-roles.destroy', $role->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                @if (\Laratrust\Helper::roleIsDeletable($role))
                                                    <a href="#" class="action-ico btn btn-outline-danger mx-1"
                                                    data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Delete"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <i class="fa fa-trash"></i></a>
                                                @else
                                                    {{-- <i class="uil-padlock"></i> --}}
                                                @endif
                                            </form>
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
    @include('livewire.user-management.access.createRoleModal')
    @push('scripts')
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#rolesTable').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#rolesTable_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
