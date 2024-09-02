<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CompanyProfile\CompanyProfile;

class CompanyProfileComponent extends Component
{
    use WithFileUploads;
    public $createNew = false;
    public $toggleForm = false;

    public $company_name;
    public $slogan;
    public $about;
    public $company_type;
    public $physical_address;
    public $address2;
    public $contact;
    public $alt_contact;
    public $email;
    public $alt_email;
    public $tin;
    public $logo;
    public $logo2;
    public $website;
    public $fax;

    public $profile;
    public $existingLogo;
    public $existingLogo2;

    public function mount(){
        $profile=CompanyProfile::first();
        if ($profile) {
            $this->company_name = $profile->company_name;
            $this->slogan = $profile->slogan;
            $this->about = $profile->about;
            $this->company_type = $profile->company_type;
            $this->physical_address = $profile->physical_address;
            $this->address2 = $profile->address2;
            $this->contact = $profile->contact;
            $this->alt_contact = $profile->alt_contact;
            $this->email = $profile->email;
            $this->alt_email = $profile->alt_email;
            $this->tin = $profile->tin;
            $this->existingLogo = $profile->logo;
            $this->existingLogo2 = $profile->logo2;
            $this->website = $profile->website;
            $this->fax = $profile->fax;

            $this->createNew=false;
        }else{
            $this->createNew=true;
        }

        $this->profile=$profile;
    }

    public function storeProfileInformation()
    {
        $this->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'max:255'],
            'physical_address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'logo' => ['required', 'image', 'mimes:jpg,png', 'max:300'],
        ]);

        $logoPath = '';
        $logo2Path = '';
    
        if ($this->logo && $this->logo2) {
            $this->validate(['logo' => 'image|max:300|dimensions:max_width=600,max_height=400',
                'logo2' => 'image|max:300|dimensions:max_width=600,max_height=400']);

            $logoName = 'logo.'.$this->logo->extension();
            $logoPath = $this->logo->storeAs('companylogo', $logoName, 'public');

            $logo2Name = 'logo2.'.$this->logo2->extension();
            $logo2Path = $this->logo2->storeAs('companylogo', $logo2Name, 'public');

        } elseif ($this->logo) {
            $this->validate(['logo' => 'image|max:300|dimensions:max_width=600,max_height=400']);

            $logoName = 'logo.'.$this->logo->extension();
            $logoPath = $this->logo->storeAs('companylogo', $logoName, 'public');
            $logo2Path = null;
        } else {
            $logoPath = null;
            $logo2Path = null;
        }

        CompanyProfile::create([
            'company_name' => $this->company_name,
            'slogan' => $this->slogan,
            'about' => $this->about,
            'company_type' => $this->company_type,
            'physical_address' => $this->physical_address,
            'address2' => $this->address2,
            'contact' => $this->contact,
            'alt_contact' => $this->alt_contact,
            'email' => $this->email,
            'alt_email' => $this->alt_email,
            'fax' => $this->fax,
            'website' => $this->website,
            'tin' => $this->tin,
            'logo' => $logoPath,
            'logo2' => $logo2Path,
        ]);

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Company profile saved successfully']);
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'max:255'],
            'physical_address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            // 'logo' => ['required', 'image', 'mimes:jpg,png', 'max:300'],
        ]);

        $logoPath = '';
        $logo2Path = '';
    
        if ($this->logo && $this->logo2) {
            $this->validate(['logo' => 'image|max:300|dimensions:max_width=600,max_height=400',
                'logo2' => 'image|max:300|dimensions:max_width=600,max_height=400']);

            $logoName = 'logo.'.$this->logo->extension();
            $logoPath = $this->logo->storeAs('companylogo', $logoName, 'public');

            $logo2Name = 'logo2.'.$this->logo2->extension();
            $logo2Path = $this->logo2->storeAs('companylogo', $logo2Name, 'public');

            if (file_exists(storage_path('app/public/').$this->existingLogo)) {
                @unlink(storage_path('app/public/').$this->existingLogo);
            }

            if (file_exists(storage_path('app/public/').$this->existingLogo2)) {
                @unlink(storage_path('app/public/').$this->existingLogo2);
            }

        } elseif ($this->logo) {
            $this->validate(['logo' => 'image|max:300|dimensions:max_width=600,max_height=400']);

            $logoName = 'logo.'.$this->logo->extension();
            $logoPath = $this->logo->storeAs('companylogo', $logoName, 'public');
            if (file_exists(storage_path('app/public/').$this->existingLogo)) {
                @unlink(storage_path('app/public/').$this->existingLogo);
            }

            $logo2Path = $this->existingLogo2;
        } else {
            $logoPath = $this->existingLogo;
            $logo2Path = $this->existingLogo2;
        }

        $this->profile->update([
            'company_name' => $this->company_name,
            'slogan' => $this->slogan,
            'about' => $this->about,
            'company_type' => $this->company_type,
            'physical_address' => $this->physical_address,
            'address2' => $this->address2,
            'contact' => $this->contact,
            'alt_contact' => $this->alt_contact,
            'email' => $this->email,
            'alt_email' => $this->alt_email,
            'fax' => $this->fax,
            'website' => $this->website,
            'tin' => $this->tin,
            'logo' => $logoPath,
            'logo2' => $logo2Path,
        ]);

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Company profile updated successfully']);
    }

    public function render()
    {
        return view('livewire.company-profile.company-profile-component');
    }
}
