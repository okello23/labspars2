{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@section('title', 'platforms')
<div class="row">

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <div class="info-box-content">
      <h4>Platforms (<span class="text-danger fw-bold">{{ $platforms->total() }}</span>)</h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
        <div class="table-responsive">

          <x-table-utilities>
            <div class="md-3">
             
            </div>

          </x-table-utilities>

          <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered mb-0 w-100 sortable">
                <thead>
                    <tr>
                        <th >#</th>
                        <th >Name</th>
                        <th >Type</th>
                        <th >Manufacturer</th>
                        <!-- <th >Model</th> -->
                        <th >Status</th>
                        <th >Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($platforms as $key=> $platform)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $platform->name }}</td>
                            <td>{{ $platform->type }}</td>
                            <td>{{ $platform->manufacturer }}</td>
                            <!-- <td >{{ $platform->model_number }}</td> -->
                            <td>
                              @if($platform->is_active == 1)
                              <span class="badge bg-success">Active</span>
                              @else
                              <span class="badge bg-danger">Deactived</span>
                              @endif
                            </td>
                            <td>
                                <button wire:click="editData({{ $platform->id }})" class="action-ico btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#addUpdateRecord">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $platform->id }})" class="action-ico btn btn-sm btn-danger mx-1"> <i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="btn-group float-end">
                {{ $platforms->links('vendor.livewire.bootstrap') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('livewire.settings.inc.add-platform-modal')
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
