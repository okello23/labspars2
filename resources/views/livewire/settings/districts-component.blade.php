{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@section('title', 'Districts')
<div class="row">

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <div class="info-box-content">
      <h4>Districts (<span class="text-danger fw-bold">{{ $districts->total() }}</span>)</h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
        <div class="table-responsive">

          <x-table-utilities>
            <div class="md-3">
              <div class="mb-1  col-md-12">
                <label for="result_type" class="form-label">Health Sub Region</label>
                <select class="form-control" wire:model="result_type">
                  <option value="">View all results</option>
                  <option value="0">Pending release</option>
                  <option value="1">Released results</option>
                  <option value="2">Recalled results</option>
                  <option value="3">Reviewed results</option>
                  <option value="4">Retained results</option>
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
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($districts as $key => $value)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $value->name }}</td>

                  <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                  <td>
                    <button wire:click="editData({{ $value->id }})" class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#addUpdateRecord">
                      <i class="fa fa-edit"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="btn-group float-end">
              {{ $districts->links('vendor.livewire.bootstrap') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @push('scripts')

    <script>
      window.addEventListener('close-modal', event => {
        $('#resultsDetailModal').modal('hide');
        $('#recallResultModal').modal('hide');
        $('#confirmResultRelease').modal('hide');
        $('#viewResultsOption').modal('hide');
      });

      window.addEventListener('recall-result-modal', event => {
        $('#recallResultModal').modal('show');
      });

      window.addEventListener('view-result-modal', event => {
        $('#resultsDetailModal').modal('show');
      });

      window.addEventListener('confirm-result-release', event => {
        $('#confirmResultRelease').modal('show');
      });

      window.addEventListener('view-result-options', event => {
        $('#viewResultsOption').modal('show');
      });

    </script>
    @endpush
  </div>
