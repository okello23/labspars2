{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@section('title', 'Enrollments')
<div class="row">

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <div class="info-box-content">
      <h4>Self Enrollment Requests (<span class="text-danger fw-bold">{{ $enrollments->total() }}</span>)</h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
        <div class="table-responsive">

          <x-table-utilities>
            <div class="md-3">
              <div class="mb-1  col-md-12">
                <label for="region_id" class="form-label">Region</label>
                <select class="form-control" wire:model="region_id">
                  <option value="">All</option>
                  <option value="1">Central</option>
                  <option value="4">Eastern</option>
                  <option value="3">Northern</option>
                  <option value="2">Western</option>
                </select>
              </div>
            </div>
            <div class="md-3">
              <div class="mb-1  col-md-12">
                <label for="ownership" class="form-label">Ownership</label>
                <select class="form-control" wire:model="ownership">
                  <option value="">All</option>
                  <option value="Govt">Government</option>
                  <option value="PFP">PFP</option>
                  <option value="PNFP">PNFP</option>
                  <option value="PFNP">PFNP</option>
                </select>
              </div>
            </div>

          </x-table-utilities>

          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered mb-0 w-100 sortable">
              <thead>
                <tr>
                 <th>#</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Contact</th>
                 <th>Category</th>
                 <th>Facility</th>
                 <th>Submitted</th>
                 <th class="text-center">Actions</th>
                </tr>
              </thead>

              <tbody>
                 @forelse ($enrollments as $index => $user)
                   <tr>
                        <td>{{ $enrollments->firstItem() + $index }}</td>
                        <td>{{ $user->title }} {{ $user->surname }} {{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->contact }}</td>
                        <td>
                            <span class="badge badge-info">{{ $user->category }}</span>
                        </td>
                        <td>{{ $user->facility->name ?? '—' }} {{ $user->facility->level ?? '—' }}</td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        @if ($user->is_active == 2)
                        <td class="text-center">
                            <button wire:click="confirmApprove({{ $user->id }})"
                                    class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> Approve
                            </button>
                            <button wire:click="confirmReject({{ $user->id }})"
                                    class="btn btn-danger btn-sm ml-1">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </td>
                        @else
                        <td class="text-center">
                            <span class="text-muted">No actions available</span>
                        </td>
                        @endif
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fa fa-check-circle text-success fa-2x mb-2"></i><br>
                            No pending enrollment requests.
                        </td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="btn-group float-end">
                {{ $enrollments->links('vendor.livewire.bootstrap') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if ($confirmingApproval)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-check-circle"></i> Confirm Approval
                        </h5>
                        <button type="button" class="close text-white"
                                wire:click="cancelApproval">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-2">You are about to approve the enrollment request for:</p>
                        <p class="font-weight-bold text-dark mb-3">
                            <i class="fa fa-user-circle"></i> {{ $approvingUserName }}
                        </p>
                        <div class="alert alert-info small mb-0">
                            <i class="fa fa-info-circle"></i>
                            A system-generated password will be created and emailed to the
                            user immediately upon approval.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                                wire:click="cancelApproval">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-success"
                                wire:click="approve"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="approve">
                                <i class="fa fa-check"></i> Yes, Approve
                            </span>
                            <span wire:loading wire:target="approve">
                                <i class="fa fa-spinner fa-spin"></i> Approving...
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{--      REJECTION CONFIRMATION MODAL --}}
    @if ($confirmingRejection)
        <div class="modal fade show d-block" tabindex="-1" role="dialog"
             style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-times-circle"></i> Confirm Rejection
                        </h5>
                        <button type="button" class="close text-white"
                                wire:click="cancelRejection">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-2">You are about to reject the enrollment request for:</p>
                        <p class="font-weight-bold text-dark mb-3">
                            <i class="fa fa-user-circle"></i> {{ $rejectingUserName }}
                        </p>
                        <div class="form-group mb-0">
                            <label for="rejection_reason" class="form-label">
                                Reason for rejection <small class="text-danger">*</small>
                            </label>
                            <textarea id="rejection_reason"
                                      wire:model.defer="rejection_reason"
                                      rows="3"
                                      class="form-control @error('rejection_reason') is-invalid @enderror"
                                      placeholder="Provide a clear reason — this will be included in the notification email sent to the user..."></textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                wire:click="cancelRejection">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger"
                                wire:click="reject"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="reject">
                                <i class="fa fa-ban"></i> Yes, Reject
                            </span>
                            <span wire:loading wire:target="reject">
                                <i class="fa fa-spinner fa-spin"></i> Rejecting...
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
</div>
