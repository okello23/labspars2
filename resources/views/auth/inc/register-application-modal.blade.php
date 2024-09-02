<!-- Modal -->
<div class="modal fade" id="registerApplication" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5>Register Your Application</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <div class="container-fluid " style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
            <h5 style="text-align:left; color:red" id="modal_header_name"></h5>
            <div class="form-body">
              <form method="post" action="/save-registration">
                @csrf
                <div class="row">

                  <div class="col-md-6">
                    <x-label for="application_name" class="fw-bold">Application Name</x-label>
                    <input type="text" class="form-control" name="name" required>

                    @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="app_url" class="fw-bold">Application URL/IP Address</x-label>
                    <input type="text" class="form-control" name="app_url" required>

                    @error('app_url')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="app_vendor" class="fw-bold">Vendor / Owner</x-label>
                    <input type="text" class="form-control" name="app_vendor" required>

                    @error('app_vendor')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>


                  <div class="col-md-6">
                    <x-label for="application_version" class="fw-bold" > Application Version</x-label>
                    <input type="text" class="form-control" name="application_version" required>

                    @error('application_version')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="purpose_for_integration" class="fw-bold">Purpose for Integration (Scope)</x-label>
                    <select class="form-control" name="purpose_for_integration" required>
                      <option value="">Select...</option>
                      <option value="make-test-request">Make test requests</option>
                      <option value="get-test-result">Get test results</option>
                      <option value="query-sample">Query samples</option>
                    </select>

                    @error('purpose_for_integration')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="application_admin_email" class="fw-bold">Application Admin's Email</x-label>
                    <input type="email" class="form-control" name="email" required>

                    @error('email')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12">
                    <x-label for="end_points" class="fw-bold">Application Endpoints</x-label>
                    <textarea class="form-control" name="end_points" placeholder="Add endpoints separated by commas if they are more than one. E.g /api/endpoint1, /api/endpoint2, /api/endpoint3" required>
                    </textarea>

                    @error('end_points')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="password" class="fw-bold">Password</x-label>
                    <input type="password" class="form-control" name="password" required>

                    @error('password')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <x-label for="password_confirmation" class="fw-bold">Confirm Password</x-label>
                    <input type="password_confirmation" class="form-control" name="password_confirmation" required>

                    @error('password_confirmation')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>
                  <br><br>

                  <span class="d-block text-muted">
                    Note that filling in this form does not automatically ready your application / system for integration.<br>
                    Keep checking the email address supplied above for a token and guide / manual to successfully complete the integration.<br>
                    Incase the email takes more than 2 working days to come through, please call the CPHL customer care on 0800-221 100 for more assistance.<br>
                    Cheers!
                  </span>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Close</button>
              <button type="submit" class="btn btn-success fa fa-save">Submit</button>

            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
