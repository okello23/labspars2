<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    System User Activity
                                </h5>
                                <div class="ms-auto">

                                    <a type="button" class="btn btn-outline-success" wire:click="refresh()"><i
                                            class="fa fa-revision"></i></a>
                                    @if (!$checkroute)
                                        <a type="button" class="btn btn-outline-danger"
                                            wire:click="deleteConfirmation()"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-0">
                        <form>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="causer" class="form-label">User/Causer</label>
                                    <select class="form-control select2" id="causer" wire:model="causer">
                                        @if ($checkroute)
                                            <option selected value="{{ auth()->user()->id }}">
                                                {{ auth()->user()->fullName }}</option>
                                        @else
                                            <option selected value="0">All</option>
                                            @forelse ($users as $user)
                                                <option value='{{ $user->id }}'>{{ $user->fullName }}</option>
                                            @empty
                                            @endforelse
                                        @endif


                                    </select>
                                    @error('causer')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="event" class="form-label">Event</label>
                                    <select class="form-control select2" id="event" wire:model="event">
                                        <option selected value="">All</option>
                                        @forelse ($events as $event)
                                            <option value='{{ $event->event }}'>{{ $event->event }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('event')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="subject" class="form-label">Subject/Target</label>
                                    <select class="form-control select2" id="subject" wire:model="subject">
                                        <option selected value="">All</option>
                                        @forelse ($log_names as $log_name)
                                            <option value='{{ $log_name->log_name }}'>{{ $log_name->log_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('subject')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="from_date" class="form-label">Start Date</label>
                                    <input id="from_date" type="date" class="form-control" wire:model="from_date">
                                    @error('from_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="to_date" class="form-label">End Date</label>
                                    <input id="to_date" type="date" class="form-control" wire:model="to_date">
                                    @error('to_date')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- end row-->
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Causer</th>
                                        <th>Event</th>
                                        <th>Subject/Target</th>
                                        <th>Old Properties</th>
                                        <th>New Properties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $key => $log)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3 cursor-pointer">
                                                    <img src="{{ $log->causer->avatar ? asset('storage/' . $log->causer->avatar) : asset('assets/images/user.png') }}"
                                                        class="rounded-circle" width="44" height="44"
                                                        alt="">
                                                    <div class="">
                                                        <p class="mb-0">
                                                            {{ $log->causer != null ? $log->causer->surname : '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($log->event == 'created')
                                                    <span class="badge bg-success">{{ $log->event }}</span>
                                                @elseif($log->event == 'updated')
                                                    <span class="badge bg-info">{{ $log->event }}</span>
                                                @elseif($log->event == 'deleted')
                                                    <span class="badge bg-danger">{{ $log->event }}</span>
                                                @else
                                                    <span class="badge bg-info">{{ $log->event }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $log->log_name . '[' . $log->subject_id . ']' }}</td>
                                            <td>
                                                <div  class="scrollable scrollabe-content">
                                                @forelse ($log->properties as $attr => $property)
                                                    @if ($attr == 'old')
                                                        @foreach ($property as $key => $value)
                                                            <strong>{{ Str::ucfirst($key) }}: </strong>
                                                            @json($value)<br>
                                                        @endforeach
                                                    @endif
                                                @empty
                                                    N/A
                                                @endforelse
                                                </div>
                                            </td>
                                            <td>
                                                <div  class="scrollable scrollabe-content">
                                                @if ($log->event == 'Assigned Role' || $log->event == 'Assigned Permission')
                                                    @json($log->properties)
                                                @else
                                                    @forelse ($log->properties as $attr2 => $property)
                                                        @if ($attr2 == 'attributes')
                                                            @foreach ($property as $key => $value)
                                                                <strong>{{ Str::ucfirst($key) }}: </strong>
                                                                @json($value)
                                                                <br>
                                                            @endforeach
                                                        @endif
                                                    @empty
                                                        N/A
                                                    @endforelse
                                                @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>

    {{-- //DELETE CONFIRMATION MODAL --}}
    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Clean up Logs</h5>
                    <button type="button" class="btn-close" wire:click="cancel()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure you want to clean up activity logs >365days?</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" wire:click="cancel()" data-bs-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button class="btn btn-sm btn-danger" wire:click="cleanLogs()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script>
            window.addEventListener('livewire:load', () => {
                initializeSelect2();
            });

            $('#causer').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('causer', data.id);
            });

            $('#event').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('event', data.id);
            });

            $('#subject').on('select2:select', function(e) {
                var data = e.params.data;
                @this.set('subject', data.id);
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
        <script>
            window.addEventListener('close-modal', event => {
                $('#delete_modal').modal('hide');
            });

            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
