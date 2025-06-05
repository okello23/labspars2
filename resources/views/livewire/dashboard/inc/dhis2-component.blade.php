<div class="row">

<div class="col-md-2">
  <div class="card-body">
    <h2>{{$count_kmp_facilities}}</h2>
    <div class="progress my-2" style="height:4px;">
      <div class="progress-bar bg-info"
      role="progressbar"
      style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center">
      <p class="mb-0" style="white-space: normal; color:#2596be">
        {{__('Number of Facilities in KMA')}}</p>
      </div>
    </div>

    <div class="card-body">
      <h2>{{$count_kampala_facilities}}</h2>
      <div class="progress my-2" style="height:4px;">
        <div class="progress-bar bg-danger"
        role="progressbar"
        style="width: 100%"></div>
      </div>
      <div class="d-flex align-items-center">
        <p class="mb-0" style="white-space: normal; color:#2596be">
          {{__('Number of Facilities in Kampala')}}</p>
        </div>
      </div>

      <div class="card-body">
        <h2>{{$count_wakiso_facilities}}</h2>
        <div class="progress my-2" style="height:4px;">
          <div class="progress-bar bg-success"
          role="progressbar"
          style="width: 100%"></div>
        </div>
        <div class="d-flex align-items-center">
          <p class="mb-0" style="white-space: normal; color:#2596be">
            {{__('Number of Facilities in Wakiso')}}</p>
          </div>
        </div>

        <div class="card-body">
          <h2>{{$count_mukono_facilities}}</h2>
          <div class="progress my-2" style="height:4px;">
            <div class="progress-bar bg-warning"
            role="progressbar"
            style="width: 100%"></div>
          </div>
          <div class="d-flex align-items-center">
            <p class="mb-0" style="white-space: normal; color:#2596be">
              {{__('Number of Facilities in Mukono')}}</p>
            </div>
          </div>

          <div class="card-body">
            <h2>{{$reporting_kmp_facilities}}</h2>
            <div class="progress my-2" style="height:4px;">
              <div class="progress-bar bg-brown-1"
              role="progressbar"
              style="width: 100%"></div>
            </div>
            <div class="d-flex align-items-center">
              <p class="mb-0" style="white-space: normal; color:#2596be">
                {{__('Number of KMA Facilities Reporting 33B')}}</p>
              </div>
            </div>
          </div> <!-- end col -->

<div class="col-md-6">
  <div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="card">
    <h5  style="color:#2596be"><u>{{ __('HMIS 033b - Weekly Epi Surveillance Report - Reporting rate') }}</u></h5>

      <x-table-utilities>

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="period">Period</label>
          <div class="group_input undefined">
            <select class="form-control selectr" wire:model="period">
              <option value="">Select...</option>
              @foreach ($periods as $key => $value)
              <option value="{{$value->period}}">{{$value->period}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!--
          <div class="mb-1 col-md-1">
            <label for="orderBy" class="form-label">OrderBy</label>
            <select wire:model="orderBy"class="form-control selectr" >
              <option value="orgUnit">Facility</option>
              <option value="period">Period</option>
              <option value="id">Latest</option>
            </select>
          </div> -->

        </x-table-utilities>

        <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
          <thead>
            <tr>
              <th>#</th>
              <th>KMA</th>
              <th>Completeness</th>
              <th>Timeliness</th>
              <th>Period</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reporting_rate as $key => $value)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$value->facility->subcounty->name}}</td>
              <td>{{$value->reporting_rate}}</td>
              <td>{{$value->reporting_rate_on_time}}</td>
              <td>{{$value->period}}</td>

              @endforeach
            </tr>
          </tbody>
        </table>
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="btn-group float-right">
            {{ $reporting_rate->links('vendor.livewire.bootstrap') }}
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="card">
    <h5  style="color:#2596be"><u>{{ __('eIDSR Events & Alerts') }}</u></h5>

      <x-table-utilities>

        </x-table-utilities>

        <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
          <thead>
            <tr>
              <th>#</th>
              <th>KMA</th>
              <th>Alert Type</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <!-- @foreach ($reporting_rate as $key => $value) -->
            <tr>
              <!-- <td>{{$key+1}}</td>
              <td>{{$value->facility->subcounty->name}}</td>
              <td>{{$value->reporting_rate}}</td>
              <td>{{$value->reporting_rate_on_time}}</td>
              <td>{{$value->period}}</td> -->

              <!-- @endforeach -->
            </tr>
          </tbody>
        </table>
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="btn-group float-right">
            <!-- {{ $reporting_rate->links('vendor.livewire.bootstrap') }} -->
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

</div>
<!--end col -->
</div>
<div class="card-body shadow p-3 mb-5 bg-transparent rounded">
<div class="card">
  <h5 style="color:#2596be"><u>{{ __('Health Facility 033b Submissions') }}</u></h5>
    <x-table-utilities>
      <!--
        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="from" class="form-label required">From</label>
          <div class="group_input undefined">
            <input class="form-control" type="date" wire:model="from" max="{{date('Y-m-d')}}">
          </div>
        </div>

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="from" class="form-label required">To</label>
          <div class="group_input undefined">
            <input class="form-control" type="date" wire:model="to" max="{{date('Y-m-d')}}">
          </div>
        </div> -->

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="hmis33b_period">Period</label>
          <div class="group_input undefined">
            <select class="form-control selectr" wire:model="hmis33b_period">
              <option value="">Select...</option>
              @foreach ($periods as $key => $value)
              <option value="{{$value->period}}">{{$value->period}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="district_id">Distric / KMA</label>
          <div class="group_input undefined">
            <select class="form-control selectr" wire:model="district_id">
              <option value="">Select...</option>
              @foreach ($districts as $key => $value)
              <option value="{{$value->dhis2_code}}">{{$value->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="division_id">Subcounties / Divisions</label>
          <div class="group_input undefined">
            <select class="form-control selectr" wire:model="division_id">
              <option value="">Select...</option>
              @foreach ($divisions as $key => $value)
              <option value="{{$value->dhis2_code}}">{{$value->name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-6 col-md-2 px-1 mb-2">
          <label for="contact_tel">Data Element</label>
          <div class="group_input undefined">
            <select class="form-control selectr" wire:model="data_element">
              <option value="">Select...</option>
              @foreach ($data_elements as $key => $value)
              <option value="{{$value->dataElement}}">{{$value->dataElement}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-1 col-md-1">
          <label for="orderBy" class="form-label">OrderBy</label>
          <select wire:model="orderBy"class="form-control selectr" >
            <option value="orgUnit">Facility</option>
            <option value="period">Period</option>
            <option value="id">Latest</option>
          </select>
        </div>

      </x-table-utilities>

      <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
        <thead>
          <tr>
            <th>#</th>
            <th>Health Facility</th>
            <th>SubCounty / Division</th>
            <th>District</th>
            <th>033b Data Element</th>
            <th>Total #</th>
            <th>Reporting Period</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($hmis33b_reports as $key => $value)
          <tr>
            <td>{{$key+1 }}</td>
            <td>{{$value->facility->facility_name }}</td>
            <td>{{$value->facility->subcounty->name }}</td>
            <td>{{$value->facility->district->name }}</td>
            <td>{{$value->dataElement }}</td>
            <td>{{$value->value }}</td>
            <td>{{$value->period }}</td>
            @endforeach
          </tr>
        </tbody>
      </table>
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="btn-group float-right">
          {{ $hmis33b_reports->links('vendor.livewire.bootstrap') }}
        </div>
      </div>
    </div>
  </div>

  </div>
</div>
<!--end row-->
