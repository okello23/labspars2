<?php
namespace App\Traits;

use App\Models\InvStorageSection;
use App\Models\CaseManagement\Contact;

trait SaveContactTrait
{

    function validateData()
    {
        return [
            'ext_case_id' => 'required',
            'lab_no' => 'nullable',
            'case_id' => 'required',
            'form_serial' => 'nullable',
            'full_name' => 'required',
            'was_contact' => 'required',
            'occupation' => 'nullable',
            'risk_level' => 'required',
            'gender' => 'nullable',
            'date_of_birth' => 'nullable',
            'age' => 'nullable',
            'date_of_reporting' => 'nullable',
            'risk_reason' => 'required',
            'address' => 'required',
            'district_id' => 'required',
            'district' => 'nullable',
            'county_id' => 'required',
            'sub_county_id' => 'required',
            'sub_county' => 'nullable',
            'parish_id' => 'required',
            'village_id' => 'required',
            'village' => 'nullable',
            'facility_unit' => 'nullable',
            'case_contact' => 'nullable',
            'case_email' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'classification' => 'nullable',
            'date_onset' => 'required',
            'case_date' => 'required',
            'date_of_infection' => 'required',
            'outcome' => 'required',
            'date_of_outcome' => 'required',
            'lab_test_date' => 'required',
            'lab_results' => 'required',
            'disease_id' => 'required',
            // 'symptoms'=>'nullable|array',
            'symptoms_others' => 'nullable',
            'next_action' => 'required',
            'general_comments' => 'nullable',
            'sampling_district' => 'nullable',
            'sampling_facility' => 'nullable',
            'sampling_date' => 'nullable',
            'testing_lab' => 'nullable',
            'lab_test_type' => 'nullable',
            'alert_type' => 'nullable',
            'case_evacuated' => 'nullable',
            'evacuation_officer' => 'nullable',
            'evacuation_facility' => 'nullable',
            'evacuation_comments' => 'nullable',
            'created_by' => 'nullable',
            'date_edited' => 'nullable',
            'edited_by' => 'nullable',
            'travel_history' => 'nullable',
            'has_bleeding' => 'nullable',
            'bleeding_place' => 'nullable',
            'sample_taken' => 'nullable',
            'in_isolation' => 'nullable',
            'isolation_date' => 'nullable',
            'in_contact' => 'nullable',
            'hospitalization' => 'nullable'];
    }
    function saveContact(
        $external_id,
        $contact_no,
        $case_id,
        $contact_contact_id,
        $full_name,
        $occupation,
        $vaccines_received,
        $vaccines,
        $gender,
        $date_of_birth,
        $age,
        $date_of_reporting,
        $risk_level,
        $risk_reason,
        $address,
        $district_id,
        $county_id,
        $sub_county_id,
        $parish_id,
        $village_id,
        $contact_tel,
        $contact_email,
        $longitude,
        $latitude,
        $date_onset,
        $case_date,
        $date_of_infection,
        $outcome,
        $date_of_outcome,
        $lab_test_date,
        $lab_results,
        $date_of_first_contact,
        $date_of_last_contact,
        $contact_date_estimated,
        $disease,
        $symptoms,
        $symptoms_others,
        $exposure_type,
        $exposures,
        $relationship,
        $next_action,
        $followup_contact,
        $follow_up_start,
        $follow_up_end,
        $lost_follow_up,
        $general_comments,
        $through_hospital,
        $hospital_name,
        $house_rooms,
        $household_members,
        $washrooms,
        $washrooms_shared,
    )
    {
        $this->validate(
            $this->validateData()
        );
        $myContact = new Contact();
        $myContact->external_id = $external_id;
        $myContact->contact_no = $contact_no;
        $myContact->case_id = $case_id;
        $myContact->contact_contact_id = $contact_contact_id;
        $myContact->full_name = $full_name;
        $myContact->occupation = $occupation;
        $myContact->vaccines_received = $vaccines_received;
        $myContact->vaccines = $vaccines;
        $myContact->gender = $gender;
        $myContact->date_of_birth = $date_of_birth;
        $myContact->age = $age;
        $myContact->date_of_reporting = $date_of_reporting;
        $myContact->risk_level = $risk_level;
        $myContact->risk_reason = $risk_reason;
        $myContact->address = $address;
        $myContact->district_id = $district_id;
        $myContact->county_id = $county_id;
        $myContact->sub_county_id = $sub_county_id;
        $myContact->parish_id = $parish_id;
        $myContact->village_id = $village_id;
        $myContact->contact_tel = $contact_tel;
        $myContact->contact_email = $contact_email;
        $myContact->longitude = $longitude;
        $myContact->latitude = $latitude;
        $myContact->date_onset = $date_onset;
        $myContact->case_date = $case_date;
        $myContact->date_of_infection = $date_of_infection;
        $myContact->outcome = $outcome;
        $myContact->date_of_outcome = $date_of_outcome;
        $myContact->lab_test_date = $lab_test_date;
        $myContact->lab_results = $lab_results;
        $myContact->date_of_first_contact = $date_of_first_contact;
        $myContact->date_of_last_contact = $date_of_last_contact;
        $myContact->contact_date_estimated = $contact_date_estimated;
        $myContact->disease = $disease;
        $myContact->symptoms = implode(', ', $symptoms);
        $myContact->symptoms_others = $symptoms_others;
        $myContact->exposure_type = $exposure_type;
        $myContact->exposures = $exposures;
        $myContact->relationship = $relationship;
        $myContact->next_action = $next_action;
        $myContact->followup_contact = $followup_contact;
        $myContact->follow_up_start = $follow_up_start;
        $myContact->follow_up_end = $follow_up_end;
        $myContact->lost_follow_up = $lost_follow_up;
        $myContact->general_comments = $general_comments;
        $myContact->through_hospital = $through_hospital;
        $myContact->hospital_name = $hospital_name;
        $myContact->house_rooms = $house_rooms;
        $myContact->household_members = $household_members;
        $myContact->washrooms = $washrooms;
        $myContact->washrooms_shared = $washrooms_shared;
        $myContact->save();
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Contact added successfully!']);
    }
}
