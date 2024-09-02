<div class="card-body">
    <h2>{{$cases}}</h2>
    <div class="progress my-2" style="height:4px;">
      <div class="progress-bar bg-info"
      role="progressbar"
      style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center">
      <p class="mb-0" style="white-space: normal; color:#2596be">
        {{__('Total Suspects Registered')}}</p>
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
          {{__('Confirmed Deaths')}}</p>
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
            {{__('Confirmed Survivors')}}</p>
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
    <h5  style="color:#2596be"><u>{{ __('Cholera cases & trends') }}</u></h5>

      <div id="choleraCasesAndTrend">

      </div>
    </div>
    </div>
  </div>
</div>
</div>

</div>
<!--end col -->
</div>
