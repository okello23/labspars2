{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@section('title', 'Districts')
<div class="row">

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <div class="info-box-content">
      <h4>Health Facilities (<span class="text-danger fw-bold">{{ $facilities->total() }}</span>)</h4>
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
                  <th>Level</th>
                  <th>Ownership</th>
                  <th>Health Sub District</th>
                  <th>District</th>
                  <th>Region</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($facilities as $key => $value)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->level }}</td>
                  <td>{{ $value->ownership }}</td>
                  <td>{{ $value->healthSubDistrict?->name }}</td>
                  <td>{{ $value->healthSubDistrict?->district->name }}</td>
                  <td>{{ $value->healthSubDistrict?->district?->region?->name }}</td>
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
                {{ $facilities->links('vendor.livewire.bootstrap') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('livewire.settings.inc.add-health-facility-modal')
    @push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
      window.addEventListener('close-modal', event => {
        $('#addEntry').modal('hide');
      });

      window.addEventListener('show-modal', event => {
        $('#addEntry').modal('show');
      });

      window.addEventListener('livewire:load', () => {
        initializeSelect2();
      });

      $('#district_id').on('select2:select', function(e) {
        var data = e.params.data;
        @this.set('district_id', data.id);
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
