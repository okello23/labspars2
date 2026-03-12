<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use App\Notifications\SendPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class EnrollmentApprovalsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search  = '';
    public $perPage = 10;

    // Approval confirmation
    public $confirmingApproval = false;
    public $approvingUserId    = null;
    public $approvingUserName  = '';

    // Rejection
    public $confirmingRejection = false;
    public $rejectingUserId     = null;
    public $rejectingUserName   = '';
    public $rejection_reason    = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // ── Approval ─────────────────────────────────────────────────────────────────

    public function confirmApprove($userId)
    {
        $user = User::findOrFail($userId);

        $this->approvingUserId   = $userId;
        $this->approvingUserName = trim($user->title . ' ' . $user->surname . ' ' . $user->first_name);
        $this->confirmingApproval = true;
    }

    public function approve()
    {
        $user          = User::findOrFail($this->approvingUserId);
        $plainPassword = $this->generatePassword();

        $user->update([
            'password'    => Hash::make($plainPassword),
            'is_active'   => 1,
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $details = [
            'greeting'   => 'Hello ' . $user->first_name . ' ' . $user->surname . ',',
            'body'       => 'Your Lab SPARS account has been approved. Use the credentials below to log in:' .
                            "\n\nEmail: " . $user->email .
                            "\nPassword: " . $plainPassword .
                            "\n\nYou will be required to change your password on first login.",
            'actiontext' => 'Login to Lab SPARS',
            'actionurl'  => url('/'),
        ];

        try {
            $user->notify(new SendPasswordNotification($details));
            $this->dispatchBrowserEvent('alert', [
                'type'    => 'success',
                'message' => $user->first_name . ' ' . $user->surname . ' approved — credentials sent.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Approval notification failed: ' . $e->getMessage());
            $this->dispatchBrowserEvent('alert', [
                'type'    => 'warning',
                'message' => 'User approved but email failed. Check logs.',
            ]);
        }

        $this->resetApproval();
    }

    public function cancelApproval()
    {
        $this->resetApproval();
    }

    private function resetApproval()
    {
        $this->confirmingApproval = false;
        $this->approvingUserId    = null;
        $this->approvingUserName  = '';
    }

    // ── Rejection ─────────────────────────────────────────────────────────────────

    public function confirmReject($userId)
    {
        $user = User::findOrFail($userId);

        $this->rejectingUserId     = $userId;
        $this->rejectingUserName   = trim($user->title . ' ' . $user->surname . ' ' . $user->first_name);
        $this->rejection_reason    = '';
        $this->confirmingRejection = true;
    }

    public function reject()
    {
        $this->validate([
            'rejection_reason' => ['required', 'string', 'min:10'],
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejection.',
            'rejection_reason.min'      => 'Reason must be at least 10 characters.',
        ]);

        $user = User::findOrFail($this->rejectingUserId);

        $user->update([
            'status'           => 'rejected',
            'is_active'        => 0,
            'rejection_reason' => $this->rejection_reason,
            'approved_by'      => auth()->id(),
            'approved_at'      => now(),
        ]);

        $details = [
            'greeting'   => 'Hello ' . $user->first_name . ' ' . $user->surname . ',',
            'body'       => 'Unfortunately your Lab SPARS enrollment request could not be approved.' .
                            "\n\nReason: " . $this->rejection_reason .
                            "\n\nFor further assistance please contact CPHL on Email: customercare@cphl.go.ug or Toll Free: 0800 221 100",
            'actiontext' => 'Visit Lab SPARS',
            'actionurl'  => url('/'),
        ];

        try {
            $user->notify(new SendPasswordNotification($details));
            $this->dispatchBrowserEvent('alert', [
                'type'    => 'success',
                'message' => $user->first_name . ' ' . $user->surname . '\'s enrollment has been rejected.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Rejection notification failed: ' . $e->getMessage());
        }

        $this->resetRejection();
    }

    public function cancelRejection()
    {
        $this->resetRejection();
    }

    private function resetRejection()
    {
        $this->confirmingRejection = false;
        $this->rejectingUserId     = null;
        $this->rejectingUserName   = '';
        $this->rejection_reason    = '';
    }

    // ── Helpers ───────────────────────────────────────────────────────────────────

    /**
     * Generate a strong password matching UsersComponent policy:
     * mixed case + numbers + symbol, min 8 chars.
     */
    private function generatePassword(): string
    {
        $upper   = strtoupper(Str::random(2));
        $lower   = strtolower(Str::random(4));
        $numbers = rand(10, 99);
        $symbol  = ['!', '@', '#', '$', '%', '&', '*'][array_rand(['!', '@', '#', '$', '%', '&', '*'])];

        return str_shuffle($upper . $lower . $numbers . $symbol);
    }

    // ── Render ────────────────────────────────────────────────────────────────────

    public function render()
    {
        $enrollments = User::where('is_active', 2)
            ->when($this->search, fn ($q) =>
                $q->where('surname', 'like', '%' . $this->search . '%')
                  ->orWhere('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->orderBy('created_at', 'asc')
            ->paginate($this->perPage);

        return view('livewire.user-management.enrollment-approvals-component', [
            'enrollments' => $enrollments,
        ])->layout('layouts.app');
    }
}