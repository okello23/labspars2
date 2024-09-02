<div>

    <!-- /Declaration Modal -->
    <div id="info-alert-modal" class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class=" bx bx-info-circle h1 text-warning"></i>
                        <h4 class="mt-2">Declaration!</h4>
                        <hr>
                        <p class="mt-3">I <strong class="text-danger">{{ auth()->user()->fullName }}</strong> hereby
                            state
                            that the information i will be providing to <strong class="text-success">Makerere
                                University Biomedical Research Center</strong> using this System is truthful and
                            that <strong class="text-success">Makerere University Biomedical Research
                                Center</strong> reserves the right to check the authenticity of the information
                            provided. <strong class="text-success">Makerere University Biomedical Research
                                Center</strong> shall not be held liable for any wrong information provided by
                            <strong class="text-danger">{{ auth()->user()->fullName }}</strong> and
                            which is used as such.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" wire:click='declinePolicy'>Decline</button>
                    <button class="btn btn-outline-success" wire:click='acceptPolicy'>Confirm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /end of Declaration Modal -->
</div>
