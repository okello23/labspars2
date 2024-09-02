<div>
  {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

  @if (Session::has('message'))
     <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <span class="info-box-icon bg-info"><i class="fas fa-dna"></i></span>
    <div class="info-box-content">
      <h4>3rd </h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
        <div class="table-responsive">
          <x-table-utilities>
            <div class="col-md-3">
              <label for="view_option" class="text-nowrap mr-2 mb-0">View Options</label>
              <select class="form-control" wire:model="view_option" style="width:100%; ">
                <option value="">Filter...</option>
                <option value="">All samples</option>
                <option value=0>Pending reception</option>
                <option value="1">Pending accessioning</option>
                <option value="3">Accessioned samples</option>
                <option value="6">Removed from accession list</option>
              </select>
            </div>

            <div class="mt-3">
              <a type="button" class="btn btn-outline-success me-2" wire:click="export()"><i
                class="fa fa-file-excel-o" title="{{ __('Export') }}"></i> {{__('Export')}}</a>
              </div>

            <div class="mt-3 col-md-2">
              <a type="button" class="btn btn-outline-info me-2" wire:click="accessionSamples"><i
                class="fa fa-edit" title="{{ __('Accession Samples') }}"></i> {{__('Accession Samples')}}</a>
              </div>

            </x-table-utilities>

            <div class="table-responsive">
              <table id="IdChw" class="table table-sm table-striped table-bordered mb-0 w-100 sortable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th sortable direction="asc">Sample Collection Facility</th>
                    <th>Art #</th>
                    <th>Form Number</th>
                    <th>Sample Collection Date</th>
                    <th>Sample Type</th>
                    <th>VL Copies</i></th>
                    <th>VL Test Date</th>
                    <th>Date Of Sample Reception</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($applications as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->facilityName}}</td>
                    <td>{{$value->patientArtNumber}}</td>
                    <td>{{$value->formNumber}}</td>
                    <td>{{$value->dateCollected}}</td>
                    <td>{{$value->sampleType}}</td>
                    <td>{{$value->vlCopies}}</td>
                    <td>{{$value->testDate}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>
                      @if($value->status == 0)
                      <span class="badge badge-danger">Pending Reception</span>
                      @elseif($value->status == 1)
                      <span class="badge badge-warning">Pending Accessioning</span>
                      @elseif($value->status == 3)
                      <span class="badge badge-success">Accessioned</span>
                      @elseif($value->status == 6)
                      <span class="badge badge-info">Removed From Accession List</span>
                      @endif
                      </td>

                    <td>
                      @if($value->status == 0)

                      <button type="button" class="btn btn-sm btn-outline-success fa fa-thumbs-up"
                      wire:click="receiveSample({{ $value->id }})" title="receive"></button>

                      <button type="button" class="btn btn-sm btn-outline-danger fa fa-thumbs-down"
                      href='#' data-toggle='modal' data-target='#rejectSample'
                      data-id="{{$value->id}}" title="reject"></button>

                      @elseif($value->status == 6)
                      <button type="button" class="btn btn-sm btn-outline-success fa fa-plus"
                      wire:click="AddToAccessionList({{ $value->id }})" title="add to accession list"> Add to List </button>

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

        @push('scripts')
        <script>
          window.addEventListener('close-modal', event => {
            $('#rejectSample').modal('hide');
            $('#accessionSamplesModal').modal('hide');
          });

          window.addEventListener('show-modal', event => {
            $('#confirmDelete').modal('show');
          });

          window.addEventListener('accession-samples-modal', event => {
            $('#accessionSamplesModal').modal('show');
          });
        </script>
        @endpush

      </div>
