<!-- Modal -->
<div class="modal fade" id="registerApplication" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5>Bearer Token</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <div class="container-fluid " style="float:left; width: 100%; overflow-x: auto;  overflow-y: auto;">
            <h5 style="text-align:left; color:red" id="modal_header_name"></h5>
            <div class="form-body">
              @csrf
              <div class="row">


                <div class="col-md-12">
                  <textarea class="form-control" wire:model.defer="bearer_token" rows="20" cols="100" readonly>
                  </textarea>

                  @error('end_points')
                  <div class="text-danger text-small">{{ $message }}</div>
                  @enderror
                </div>
                <br><br>

                <!-- <span class="d-block text-muted">
                Note that filling in this form does not automatically ready your application / system for integration.<br>
                Keep checking the email address supplied above for a token and guide / manual to successfully complete the integration.<br>
                Incase the email takes more than 2 working days to come through, please call the CPHL customer care on 0800-221 100 for more assistance.<br>
                Cheers!
              </span> -->
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Close</button>

          @if($token_status == 2)
          <span class="badge badge-danger">Token Revoked</span>
          @elseif($token_status == 1)
          <button class="btn btn-success fa fa-ban" wire:click="revokeBearerToken({{$value->id}})"> Revoke </button>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>
</div>
