<div class="card-body">
    <h2>{{$cases}}</h2>
    <div class="progress my-2" style="height:4px;">
      <div class="progress-bar bg-info"
      role="progressbar"
      style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center">
      <p class="mb-0" style="white-space: normal; color:#2596be">
        {{__('Total Number of Cases')}}</p>
      </div>
    </div>

    <div class="card-body">
      <h2>{{$contacts}}</h2>
      <div class="progress my-2" style="height:4px;">
        <div class="progress-bar bg-warning"
        role="progressbar"
        style="width: 100%"></div>
      </div>
      <div class="d-flex align-items-center">
        <p class="mb-0" style="white-space: normal; color:#2596be">
          {{__('Total Number of Contacts')}}</p>
        </div>
      </div>

      <div class="card-body">
        <h2>{{$deaths}}</h2>
        <div class="progress my-2" style="height:4px;">
          <div class="progress-bar bg-danger"
          role="progressbar"
          style="width: 100%"></div>
        </div>
        <div class="d-flex align-items-center">
          <p class="mb-0" style="white-space: normal; color:#2596be">
            {{__('Total Number of Deaths')}}</p>
          </div>
        </div>

        <div class="card-body">
          <h2>{{$recoveries}}</h2>
          <div class="progress my-2" style="height:4px;">
            <div class="progress-bar bg-success"
            role="progressbar"
            style="width: 100%"></div>
          </div>
          <div class="d-flex align-items-center">
            <p class="mb-0" style="white-space: normal; color:#2596be">
              {{__('Total Recoveries')}}</p>
            </div>
          </div>
  </div>

<div class="col-md-10">
  <div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="card">
    <h5  style="color:#2596be"><u>{{ __('KMA Covid-19 Summary') }}</u></h5>

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

        </x-table-utilities>

        <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
          <thead>
            <tr>
              <th>#</th>
              <th>Testing Laboratory</th>
              <th>Cases</th>
              <th>Contacts</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($covid_cases as $key => $value)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$value->testing_lab}}</td>
              <td>{{$value->reporting_rate}}</td>
              <td>{{$value->reporting_rate_on_time}}</td>

              @endforeach
            </tr>
          </tbody>
        </table>
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="btn-group float-right">
            {{ $covid_cases->links('vendor.livewire.bootstrap') }}
          </div>
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

</div>
<!--end row-->
