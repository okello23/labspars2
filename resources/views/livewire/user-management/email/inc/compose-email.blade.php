 <div class="modal fade bd-example-modal-lg" id="compose-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Compose Mail</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" placeholder="To">
                        </div><!--end form-group-->
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Cc">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Bcc">
                                </div>
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div><!--end form-group-->
                        <textarea id="basic-conf">Hello, World!</textarea>
                    </form>                     
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button class="btn btn-de-primary btn-sm"><span>Send</span> <i class="far fa-paper-plane ms-2"></i></button>
                    <button type="button" class="btn btn-de-danger btn-sm" data-bs-dismiss="modal"><span>Delete</span><i class="far fa-trash-alt ms-2"></i></button> 
                </div><!--end modal-footer-->
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->