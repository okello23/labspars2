<div>

    @section('title', 'LSS Visits')
    <!-- @include('livewire.layouts.partials.inc.create-resource') -->
    <div class="row">

  <div class="info-box" style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
    <div class="info-box-content">
      <h4>LSS Visits (<span class="text-danger fw-bold">{{ $visits->total() }}</span>)</h4>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 100%; height: 25%; "></div>
      </div>
      <span class="progress-description">
                        <div class="table-responsive">
    <x-lss-visit-table-utilities>
            <div class="md-3">
              <div class="mb-1  col-md-12">
                <label for="region_id" class="form-label">Region</label>
                <select class="form-control" wire:model="region_id">
                    <option value="">All</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="md-3">
              <div class="mb-1  col-md-12">
                <label for="ownership" class="form-label">District</label>
               <select class="form-control" wire:model="district_id" @if(empty($districts_list)) disabled @endif>
                    <option value="">Select District</option>
                    @foreach($districts_list as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="md-3">
                <div class="mb-1  col-md-12">
                    <label for="from_date" class="form-label">From Date</label>
                    <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                </div>
            </div>
                
            <div class="md-3">
                <div class="mb-1 col-md-12">
                     <label for="to_date" class="form-label">To Date</label>
                     <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                </div>
            </div>    
                  

          </x-lss-visit-table-utilities>
                            <table id="datableButton" class="table table-striped table-sm table-bordered mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Facility Name</th>
                                        <th>Visit Number</th>
                                        <th>In Charge Name</th>
                                        <th>In Charge Contact</th>
                                        <th>Date Of Visit</th>
                                        <th>Date Of Next Visit</th>
                                        <th>District</th>
                                        <th>Health Sub District</th>
                                        <th>Region</th>
                                        <th>Create By</th>
                                        <th>Stage</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $key => $facilityvisit)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $facilityvisit->facility->name }} {{ $facilityvisit->facility?->level}}</td>
                                            <td>{{ $facilityvisit->visit_number ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->in_charge_name ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->in_charge_contact }}</td>
                                            <td>{{ $facilityvisit->date_of_visit }}</td>
                                            <td>{{ $facilityvisit->date_of_next_visit }}</td>
                                            <td>{{ $facilityvisit->facility?->healthSubDistrict->district->name ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->facility->healthSubDistrict->name ?? 'N/A' }}</td>
                                            <td>{{ $facilityvisit->facility->healthSubDistrict?->district->region?->name}}</td>
                                            <td>{{ $facilityvisit->createdBy->name }}</td>
                                            <td>{{ $facilityvisit->stage }}</td>
                                            <td><span class="badge badge-primary">{{ $facilityvisit->status }}</span></td>
                                            <td>
                                               
                                                <a href="{{ URL::signedRoute('facility-visit_view', $facilityvisit->visit_code) }}"
                                                    class="action-ico btn btn-sm btn-info mx-1" >
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ URL::signedRoute('facility-visit_details', $facilityvisit->visit_code) }}"
                                                    class="action-ico btn btn-sm btn-success mx-1" >
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-right">
                                    {{ $visits->links('vendor.livewire.bootstrap') }}
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>

    @include('livewire.facility.visits.inc.new-facility-visit')
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#addUpdateRecord').modal('hide');
                $('#delete_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
