<div class="row">

  <div class="card-body">
    <h2>{{$evd['evd_suspects']}}</h2>
    <div class="progress my-2" style="height:4px;">
      <div class="progress-bar bg-info"
      role="progressbar"
      style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center">
      <p class="mb-0" style="white-space: normal; color:#2596be">
        {{__('EVD Suspected Cases')}}</p>
      </div>
    </div>

    <div class="card-body">
      <h2>{{$evd['positive']}}</h2>
      <div class="progress my-2" style="height:4px;">
        <div class="progress-bar bg-danger"
        role="progressbar"
        style="width: 100%"></div>
      </div>
      <div class="d-flex align-items-center">
        <p class="mb-0" style="white-space: normal; color:#2596be">
          {{__('Confirmed EVD Cases')}}</p>
        </div>
      </div>


  <div class="card-body">
    <h2>{{$evd_contacts_count}}</h2>
    <div class="progress my-2" style="height:4px;">
      <div class="progress-bar bg-warning"
      role="progressbar"
      style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center">
      <p class="mb-0" style="white-space: normal; color:#2596be">
        {{__('EVD Contacts')}}</p>
      </div>
    </div>

    <div class="card-body">
      <h2>{{$evd_invalid_results}}</h2>
      <div class="progress my-2" style="height:4px;">
        <div class="progress-bar bg-danger"
        role="progressbar"
        style="width: 100%"></div>
      </div>
      <div class="d-flex align-items-center">
        <p class="mb-0" style="white-space: normal; color:#2596be">
          {{__('Invalid Results')}}</p>
        </div>
      </div>


      <div class="card-body">
        <h2>{{$evd_posthumous_count}}</h2>
        <div class="progress my-2" style="height:4px;">
          <div class="progress-bar bg-warning"
          role="progressbar"
          style="width: 100%"></div>
        </div>
        <div class="d-flex align-items-center">
          <p class="mb-0" style="white-space: normal; color:#2596be">
            {{__('Posthumously tested for EVD')}}</p>
          </div>
        </div>
        </div>

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

<div class="col-md-12">
  <div class="card-body shadow p-3 mb-5 bg-transparent rounded">
  <div class="card">
    <h5  style="color:#2596be"><u>{{ __('Ebola Summaries') }}</u></h5>
    <div class="card-body">
      <div id="evdChart"></div>
    </div>

    </div>
    </div>
  </div>

<div class="row">
<div class="col-md-6">
<div class="card-body shadow p-3 mb-5 bg-transparent rounded">
<div class="card">
  <h5 style="color:#2596be"><u>{{ __('Cummulative VHF Summaries') }}</u></h5>

      <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
        <thead>
          <tr>
            <th>Suspected Cases</th>
            <th>Confirmed</th>
            <th>Confirmed Deaths</th>
            <th>Male</th>
            <th>Female</th>

          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$vhfs['vhf_count'] }}</td>
            <td>{{$vhfs['vhf_confirmed'] }}</td>
            <td>{{$vhfs['vhf_dead'] }}</td>
            <td>{{$vhfs['vhf_male'] }}</td>
            <td>{{$vhfs['vhf_female'] }}</td>
          </tr>
        </tbody>
      </table>
  </div>
  </div>
  </div>

<div class="col-md-6">
<div class="card-body shadow p-3 mb-5 bg-transparent rounded">
<div class="card">
  <h5 style="color:#2596be"><u>{{ __('Cummulative Cholera Summaries') }}</u></h5>

      <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
        <thead>
          <tr>
            <th>Suspected Cases</th>
            <th>Confirmed</th>
            <th>Confirmed Deaths</th>
            <th>Male</th>
            <th>Female</th>
          </tr>
        </thead>
        <tbody>
          <td>{{$cholera['count'] }}</td>
          <td>{{$cholera['confirmed'] }}</td>
          <td>{{$cholera['dead'] }}</td>
          <td>{{$cholera['male'] }}</td>
          <td>{{$cholera['female'] }}</td>
          </tr>
        </tbody>
      </table>
  </div>

  </div>
</div>
</div>
<!--end row-->

              <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

              <script>
                var options = {
                  series: [{
                    name: 'EVD Suspected Cases',
                    data: [
                      @foreach ($evd['period'] as $key => $value)
                      {{ count($value) }},
                      @endforeach
                      ],
                    title: {
                      text: 'EVD Suspected Cases'
                    }
                  },
                  {
                    name: 'Positive',
                    data: [
                    @foreach ($evd['evdPos'] as $key => $value)
                    {{ count($value) }},
                    @endforeach
                    ],
                    title: {
                      text: 'Positive'
                    }
                  },
                  {
                    name: 'Negative',
                    data: [
                    @foreach ($evd['evdNeg'] as $key =>$value)
                    {{ count($value)}},
                    @endforeach
                    ],
                    title: {
                      text: 'Negative'
                    }
                  },
                  {
                    name: 'Invalid',
                    data: [
                    @foreach ($evd['evdInvalid'] as $key =>$value)
                    {{ count($value)}},
                    @endforeach
                    ],
                    title: {
                      text: 'Invalid'
                    }
                  },
                  {
                    name: 'inconclusive',
                    data: [
                    @foreach ($evd['evdInconclusive'] as $key =>$value)
                    {{ count($value)}},
                    @endforeach
                    ],
                    title: {
                      text: 'inconclusive'
                    }
                  },
                  ],
                  chart: {
                    height: 300,
                    type: 'bar'
                  },
                  dataLabels: {
                    enabled: true
                  },
                  stroke: {
                    curve: 'smooth'
                  },
                  markers: {
                    size: 0
                  },
                  yaxis: {

                    title: {
                      text: 'No. of tests',
                    },
                    min: 0
                  },
                  xaxis: {
                    categories: [

                    @foreach ($evd['period'] as $key => $value)
                    '{{ $key }}',
                    @endforeach
                    ],
                    title: {
                      text: 'Months'
                    }
                  },
                };
                var evdChart = new ApexCharts(document.querySelector("#evdChart"), options);
                evdChart.render();
              </script>
