<div>
The best athlete wants his opponent at his best.

  @if (Session::has('message'))
     <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <span class="info-box-icon bg-info"><i class="fas fa-dna"></i></span>
    <div class="info-box-content">
      <h4>3rd Party API Systems Integration</h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
        <div class="table-responsive">
          <x-table-utilities>
            <div class="md-3">
              <div class="mb-1  col-md-12">
              <label for="view_option">View Options</label>
              <select class="form-control" wire:model="view_option" style="width:100%; ">
                <option value="">Filter...</option>
                <option value="">All Requests</option>
                <option value=0>Pending Approval</option>
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
              </select>
            </div>
            </div>
            </x-table-utilities>

            <div class="table-responsive">
              <table id="IdChw" class="table table-sm table-striped table-bordered mb-0 w-100 sortable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client ID</th>
                    <th>Application / System Name</th>
                    <th>Application Version</th>
                    <th>URL /  IP Address</th>
                    <th>Scope</th>
                    <th>Owner</th>
                    <th>Date Requested</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($applications as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->client?->id}}</td>
                    <td>{{$value->client?->name}}</td>
                    <td>{{$value->application_version}}</td>
                    <td>{{$value->url}}</td>
                    <td>{{$value->purpose_for_integration}}</td>
                    <td>{{$value->owner}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>
                      @if($value->status == 0)
                      <span class="badge badge-warning">Pending Approval</span>
                      @elseif($value->status == 1)
                      <span class="badge badge-success">Approved & Token Issued</span>
                      @elseif($value->status == 2)
                      <span class="badge badge-danger">Token Revoked</span>
                      @endif
                      </td>

                    <td>
                      @if($value->status == 0)

                      <button type="button" class="btn btn-sm btn-outline-success fa fa-thumbs-up"
                      wire:click="approveRequest({{ $value->id }})" title="Approve & Issue Bearer Token"></button>

                      <button type="button" class="btn btn-sm btn-outline-danger fa fa-thumbs-down"
                      wire:click="revokeBearerToken({{ $value->id }})" title="Reject Request"></button>

                      @elseif($value->status == 1 || $value->status ==2 )
                      <button type="button" class="btn btn-sm btn-outline-success fa fa-eye"
                      wire:click="viewBearerToken({{ $value->id }})" title="View Bearer Token">  </button>

                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="btn-group float-end">
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
          @include('livewire.api.inc.view-bearer-token-modal')
        @push('scripts')
        <script>
          window.addEventListener('close-modal', event => {
            $('#rejectSample').modal('hide');
            $('#accessionSamplesModal').modal('hide');
          });

          window.addEventListener('show-modal', event => {
            $('#confirmDelete').modal('show');
          });

          window.addEventListener('view-bearer-token-modal', event => {
            $('#registerApplication').modal('show');
          });
        </script>
        @endpush

</div>
