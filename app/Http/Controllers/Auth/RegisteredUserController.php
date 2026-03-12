<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Facility\Facility;
use App\Models\User;
use App\Notifications\EnrollmentPendingAdminNotification;
use App\Notifications\EnrollmentSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the self-enrollment form.
     * Mirrors exactly what UsersComponent::render() provides for facilities.
     */
    public function create()
    {
        $facilities = Facility::orderBy('name')
        ->with('healthSubDistrict') // eager load level relationship
        ->get(['id', 'name']);
        $districts = $facilities->pluck('healthSubDistrict.name', 'healthSubDistrict.name')->unique()->sort();

        // If you have a District model, swap in the correct namespace below
        // $districts = \App\Models\District::orderBy('name')->get(['id', 'name']);

        $titles     = ['Mr', 'Mrs', 'Ms', 'Dr', 'Prof'];
        $toggleForm = false;
        $category = ['Lab Technician', 'Lab Technologist', 'Medical Officer', 'Data Officer','DLFP', 'Hub Coordinator','Other'];

        return view('auth.inc.self-enroll', compact('facilities', 'titles', 'category','toggleForm', 'districts'));
    }

    /**
     * Handle self-enrollment submission.
     * Maps to the same fields UsersComponent::storeUser() uses.
     * User is created inactive + pending — password auto-generated on admin approval.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:6'],
            'surname'     => ['required', 'string', 'max:25'],
            'first_name'  => ['required', 'string', 'max:25'],
            'other_name'  => ['nullable', 'string', 'max:25'],
            'email'       => ['required', 'string', 'email:filter', 'max:30', 'unique:users,email'],
            'contact'     => ['required', 'string', 'max:20'],
            'facility_id' => ['required', 'exists:facilities,id'],
        ]);

        $user = User::create([
            'title'       => $request->title,
            'surname'     => $request->surname,
            'first_name'  => $request->first_name,
            'other_name'  => $request->other_name,
            'name'        => $request->first_name,           // matches UsersComponent: name = first_name
            'email'       => $request->email,
            'contact'     => $request->contact,
            'facility_id' => $request->facility_id,
            'category'    => 'Institution',
            'password'    => bcrypt(\Illuminate\Support\Str::random(32)), // placeholder; reset on approval
            'is_active'   => 2,
            'status'      => 'pending',
        ]);

        // Notify the enrollee
        try {
            $user->notify(new EnrollmentSubmittedNotification($user));
        } catch (\Exception $e) {
            logger()->error('Enrollment submitted notification failed: ' . $e->getMessage());
        }

        // Notify admins
        $admins = User::where('is_active', 1)
            ->whereHas('roles', fn ($q) => $q->where('name', 'admin'))
            ->get();

        if ($admins->isNotEmpty()) {
            try {
                Notification::send($admins, new EnrollmentPendingAdminNotification($user));
            } catch (\Exception $e) {
                logger()->error('Admin enrollment notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('login')
            ->with('success', 'Your enrollment request has been submitted. You will receive your login credentials by email once approved.');
    }
}