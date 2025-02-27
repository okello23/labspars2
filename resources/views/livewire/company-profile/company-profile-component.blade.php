<div>
    <div class="row">
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body">
                    <div class="profile-avatar text-center">
                        <img src="{{ $profile->logo ? asset('storage/' . $profile->logo) : asset('assets/images/avatars/user.png') }}"
                            class="rounded-circle shadow" width="120" height="120" alt="">
                    </div>
                    <div class="text-center mt-4">
                        <h6 class="mb-1">{{ $company_name }}</h6>
                        <div class="mt-1">{{ $slogan }}</div>
                    </div>
                    <hr>
                    <div class="text-start">
                        <h6 class="">About</h6>
                        <div class="mt-1">{{ $about }}</div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">
                        Company Type
                        <span class="badge bg-info rounded-pill">{{ $company_type ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Physical Address
                        <span class="badge bg-info rounded-pill">{{ $physical_address ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Address Line2
                        <span class="badge bg-info rounded-pill">{{ $address2 ?? 'N/A' }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Official Contact
                        <span class="badge bg-info rounded-pill">{{ $contact ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Alternative Contact
                        <span class="badge bg-info rounded-pill">{{ $alt_contact ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Official Email
                        <span class="badge bg-info rounded-pill">{{ $email ?? 'N/A' }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Alternative Email
                        <span class="badge bg-info rounded-pill">{{ $alt_email ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Fax
                        <span class="badge bg-info rounded-pill">{{ $fax ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        Website
                        <span class="badge bg-info rounded-pill">{{ $website ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                        TIN
                        <span class="badge bg-info rounded-pill">{{ $tin ?? 'N/A' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-0">
                        @if ($createNew)
                            Company Profile
                        @else
                            Update Information
                        @endif
                    </h5>
                    <hr>
                    <div class="card shadow-none border">
                        <div class="card-body">
                            <form
                                @if ($createNew) wire:submit.prevent="storeProfileInformation"
                            @else
                            wire:submit.prevent="updateProfileInformation" @endif>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="company_name" class="form-label">Company
                                            Name<span class="text-danger">*</span></label>
                                        <input type="text" id="company_name" class="form-control"
                                            wire:model.defer='company_name'>
                                        @error('company_name')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="about" class="form-label">About/Description</label>
                                        <textarea type="text" id="about" class="form-control" wire:model.defer='about'></textarea>
                                        @error('about')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="slogan" class="form-label">Slogan</label>
                                        <input type="text" id="slogan" class="form-control"
                                            wire:model.defer='slogan' placeholder="slogan">
                                        @error('slogan')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="company_type" class="form-label">Company
                                            Type<span class="text-danger">*</span></label>
                                        <select class="form-select" data-toggle="select2" id="company_type"
                                            wire:model.lazy='company_type'>
                                            <option selected value="">Select</option>
                                            <option value="GOVERMENT">GOVERMENT</option>
                                            <option value="NGO">NGO</option>
                                            <option value="PRIVATE">PRIVATE</option>
                                        </select>
                                        @error('company_type')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="physical_address" class="form-label">Physical Address<span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="physical_address" class="form-control"
                                            wire:model.defer='physical_address' placeholder="Plot, Street, Block, City">
                                        @error('physical_address')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="address2" class="form-label">Address Line
                                            2</label>
                                        <input type="text" id="address2" class="form-control"
                                            wire:model.defer='address2' placeholder="P.O BOX.....">
                                        @error('address2')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control"
                                            wire:model.defer='email'>
                                        @error('email')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="alt_email" class="form-label">Alternative Email</label>
                                        <input type="email" id="alt_email" class="form-control"
                                            wire:model.defer='alt_email'>
                                        @error('alt_email')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="contact" class="form-label">Official contact
                                            <span class="text-danger">*</span></label>
                                        <input type="text" id="contact" class="form-control"
                                            wire:model.defer='contact'>
                                        @error('contact')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="alt_contact" class="form-label">Alternative Contact</label>
                                        <input type="text" id="alt_contact" class="form-control"
                                            wire:model.defer='alt_contact'>
                                        @error('alt_contact')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="fax" class="form-label">Fax</label>
                                        <input type="text" id="fax" class="form-control"
                                            wire:model.defer='fax'>
                                        @error('fax')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="website" class="form-label">Official Website</label>
                                        <input type="url" id="website" class="form-control"
                                            wire:model.defer='website'>
                                        @error('website')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="tin" class="form-label">TIN</label>
                                        <input type="text" id="tin" class="form-control"
                                            wire:model.defer='tin'>
                                        @error('tin')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="logo" class="form-label">Logo<span
                                                class="text-danger">*</span></label>
                                        <input type="file" id="logo" class="form-control" wire:model='logo'>
                                        <div class="text-success text-small" wire:loading wire:target="logo">Uploading
                                            logo</div>
                                        @error('logo')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="logo2" class="form-label">Logo
                                            2</label>
                                        <input type="file" id="logo2" class="form-control"
                                            wire:model='logo2'>
                                        <div class="text-success text-small" wire:loading wire:target="logo2">
                                            Uploading alternative logo</div>
                                        @error('logo2')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- end row-->
                                    <div class="modal-footer">
                                        @if ($createNew)
                                            <x-button class="btn-success">{{ __('Save') }}</x-button>
                                        @else
                                            <x-button class="btn-success">{{ __('Update') }}</x-button>
                                        @endif
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>
