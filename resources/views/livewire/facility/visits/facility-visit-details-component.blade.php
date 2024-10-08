<div class="row clearfix">
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                @include('livewire.facility.visits.inc.visit-header')
            </div> <!-- end card header -->
            <div class="card-body">

                <div class="row">

                    <div class="stepwizard overflow-auto">
                        <div class="stepwizard-row setup-panel overflow-auto">
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-1" type="button"
                                    class="btn {{ $step != 1 ? 'btn-default' : 'btn-success' }}">LABORATORY INFORMATION</a>
                            </div>
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-2" type="button"
                                    class="btn {{ $step != 2 ? 'btn-default' : 'btn-success' }}">STOCK MANAGEMENT</a>
                            </div>
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-3" type="button"
                                    class="btn {{ $step != 3 ? 'btn-default' : 'btn-success' }}">PSTORAGE & LAB FACILITIES MANAGEMENT</a>
                            </div>
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-4" type="button"
                                    class="btn {{ $step != 4 ? 'btn-default' : 'btn-success' }}">ORDERING</a>
                            </div>
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-5" type="button"
                                    class="btn {{ $step != 5 ? 'btn-default' : 'btn-success' }}">LABORATORY EQUIPMENT </a>
                            </div>
                            <div class="multi-wizard-step overflow-auto">
                                <a href="#step-5" type="button"
                                    class="btn {{ $step != 5 ? 'btn-default' : 'btn-success' }}">LABORATORY INFORMATION SYSTEM</a>
                            </div>
                        </div>
                    </div>
                    @if($step == 1)
                    <div class="row setup-content {{ $step != 1 ? 'display-none' : '' }}" id="step-1">

                        <div class="col-md-12">
                            <div class="border border-success rounded">
                                @include('livewire.facility.visits.inc.facility-visit-info')
                                <hr>
                                <div class="container">

                                    @if ($toggleForm)
                                        <x-button
                                            class="btn btn-success nextBtn btn-lg float-right fa fa-arrow-circle-right"
                                            wire:click="updateFirstStepSubmit({{ $edit_id }})">Update</x-button>
                                    @else
                                        <x-button
                                            class="btn btn-success nextBtn btn-lg float-right fa fa-arrow-circle-right"
                                            wire:click="firstStepSubmit">Next</x-button>
                                    @endif
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($step == 2)
                    <div class="row setup-content {{ $step != 2 ? 'display-none' : '' }}" id="step-2">
                        <div class="col-md-12">
                            <div class="border border-success rounded">
                                {{-- @include('livewire.chw.inc.section-b-component') --}}
                                <hr>
                                <div class="container">
                                    <div class="btn-group float-right" role="group">
                                        <x-button
                                            class="btn btn-success nextBtn btn-lg float-right fa fa-arrow-circle-right"
                                            wire:click="secondStepSubmit">Next</x-button>
                                    </div>
                                    
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($step == 3)
                    <div class="row setup-content {{ $step != 3 ? 'display-none' : '' }}" id="step-3">
                        <div class="col-md-12">
                            <div class="border border-success rounded">
                                {{-- @include('livewire.chw.inc.section-c-component') --}}
                                <hr>
                                <div class="container">
                                    <div class="btn-group float-right" role="group">
                                        <x-button class="btn-success  nextBtn btn-lg fa fa-arrow-circle-right"
                                            wire:click="thirdStepSubmit">Next</x-button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <x-button class="btn-danger float-right nextBtn btn-lg fa fa-arrow-circle-left"
                                            wire:click="back(2)">Back</x-button>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($step == 4)
                    <div class="row setup-content {{ $step != 4 ? 'display-none' : '' }} overflow-auto"
                        id="step-4">
                        <div class="col-md-12">

                            <div class="border border-success rounded overflow-auto">
                                {{-- @include('livewire.chw.inc.section-d-component') --}}
                                <hr>
                                <div class="container">
                                    <div class="btn-group float-right" role="group">
                                        <x-button class="btn-success  nextBtn btn-lg fa fa-arrow-circle-right"
                                            wire:click="fourthStepSubmit">Next</x-button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <x-button class="btn-danger float-right nextBtn btn-lg fa fa-arrow-circle-left"
                                            wire:click="back(3)">Back</x-button>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($step == 5)
                    <div class="row setup-content {{ $step != 5 ? 'display-none' : '' }} overflow-auto"
                        id="step-5">
                        <div class="col-md-12">

                            <div class="border border-success rounded overflow-auto">
                                {{-- @include('livewire.chw.inc.language-incentives-and-functions') --}}
                                <hr>
                                <div class="container">
                                    <div class="btn-group float-right" role="group">
                                        <x-button class="btn-success  nextBtn btn-lg fa fa-arrow-circle-right"
                                            wire:click="fifthStepSubmit">Finish</x-button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <x-button class="btn-danger float-right nextBtn btn-lg fa fa-arrow-circle-left"
                                            wire:click="back(4)">Back</x-button>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
