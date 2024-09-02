{{-- The whole world belongs to you. --}}
<div class="row">
  <div class="col-12">
    <div class="card shadow p-3 mb-5 bg-transparent rounded">

      <div class="card-body">
        <div id="new-resource">
          <ul class="nav nav-tabs nav-default" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" data-bs-toggle="tab" role="tab"
              aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='fa fa-pie-chart font-18 me-1'></i>
                </div>
                <div class="tab-title">
                  <select class="form-control selectr"  wire:model="filter_options">
                    <option value="">{{__('Lab Spars Summaries')}}</option>
                    <option value="spider_graph">Spider Graph</option>
                  </select></div>
                </div>
              </a>
            </li>
          </ul>

          <div class="col-12">
            <div class="tab-content py-3">
              <div class="tab-pane fade show active" id="dhis2" role="tabpanel">


                <div class="table-responsive">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-start col-md-12">


                      <div class="card">
                <h5>Dashboard coming soon...</h5>

                      </div>
                    </div>
                  </div>

                </div>
              </div> <!-- end card body-->
            </div> <!-- end card -->
          </div><!-- end col-->
        </div>
      </div>
    </div>
  </div>
</div>
