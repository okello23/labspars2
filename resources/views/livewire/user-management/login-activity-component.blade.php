<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    System User Login Activity
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" class="btn btn-outline-success" wire:click="refresh()"><i
                                            class="fa fa-revision"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Login Records</h6>

                            <div class="mb-3 col-md-3">
                                <label for="description" class="form-label">Action</label>
                                <select class="form-control select2" id="description" wire:model="description">
                                    <option selected value="0">All</option>
                                    @forelse ($descriptions_list as $action)
                                        <option value='{{ $action }}'>{{ $action }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="platform" class="form-label">Platform</label>
                                <select class="form-control select2" id="platform" wire:model="platform">
                                    <option selected value="0">All</option>
                                    @forelse ($platforms_list as $platform)
                                        <option value='{{ $platform }}'>{{ $platform }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="browser" class="form-label">Browser</label>
                                <select class="form-control select2" id="browser" wire:model="browser">
                                    <option selected value="0">All</option>
                                    @forelse ($browsers_list as $browser)
                                        <option value='{{ $browser }}'>{{ $browser }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="row mb-0">

                            <div class="mt-4 col-md-1">
                                <a type="button" class="btn btn-outline-success me-2" wire:click="export()">Export</a>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="perPage" class="form-label">Per Page</label>
                                <select wire:model="perPage" class="form-control" id="perPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="orderBy" class="form-label">OrderBy</label>
                                <select wire:model="orderBy" class="form-control">
                                    <option value="email">Email</option>
                                    <option value="platform">Platform</option>
                                    <option value="browser">Browser</option>
                                    <option value="id">Latest</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="orderAsc" class="form-label">Order</label>
                                <select wire:model="orderAsc" class="form-control" id="orderAsc">
                                    <option value="1">Asc</option>
                                    <option value="0">Desc</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">Search</label>
                                <input id="search" type="text" class="form-control"
                                    wire:model.debounce.300ms="search" placeholder="search">
                            </div>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table id="logsTable" class="table table-striped table-bordered mb-0 w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Platform</th>
                                        <th>Browser</th>
                                        <th>Client_IP</th>
                                        <th>Period</th>
                                        <th>Activity Date/time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $log->email }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->platform }}</td>
                                            <td>{{ $log->browser }}</td>
                                            <td>{{ $log->client_ip }}</td>
                                            <td>{{ $log->created_at->diffForHumans() }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $logs->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    @push('scripts')
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script>
            window.addEventListener('livewire:load', () => {
                initializeSelect2();
            });

            $('#description').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('description', data.id);
            });

            $('#platform').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('platform', data.id);
            });

            $('#browser').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('browser', data.id);
            });

            window.addEventListener('livewire:update', () => {
                $('.select2').select2('destroy'); //destroy the previous instances of select2
                initializeSelect2();
            });

            function initializeSelect2() {

                $('.select2').each(function() {
                    $(this).select2({
                        theme: 'bootstrap4',
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                            '100%' : 'style',
                        placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : 'Select',
                        allowClear: Boolean($(this).data('allow-clear')),
                    });
                });
            }
        </script>
    @endpush
</div>
