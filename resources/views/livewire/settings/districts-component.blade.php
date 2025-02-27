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
                <label for="result_type" class="form-label">Region</label>
                <select class="form-control" wire:model="region_id">
                  <option value="">All</option>
                  <option value="1">Central</option>
                  <option value="4">Eastern</option>
                  <option value="3">Northern</option>
                  <option value="2">Western</option>
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
                  <th>Region</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($districts as $key => $value)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->region?->name }}</td>
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

    @include('livewire.settings.inc.add-district-modal')
    @push('scripts')

    <script>
      window.addEventListener('show-modal', event => {
        $('#addEntry').modal('show');
      });
      window.addEventListener('close-modal', event => {
        $('#addEntry').modal('hide');
      });
    </script>
    @endpush
  </div>
