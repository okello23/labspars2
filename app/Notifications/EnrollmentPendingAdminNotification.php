<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentPendingAdminNotification extends Notification
{
    use Queueable;

    public function __construct(public User $enrollee) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Lab SPARS — New Enrollment Request Pending Approval')
            ->greeting('Hello,')
            ->line('A new user has submitted a self-enrollment request and requires your approval.')
            ->line('**Name:** ' . $this->enrollee->surname . ' ' . $this->enrollee->first_name)
            ->line('**Email:** ' . $this->enrollee->email)
            ->line('**Contact:** ' . $this->enrollee->contact)
            ->line('**Submitted:** ' . $this->enrollee->created_at->format('d M Y H:i'))
            ->action('Review Enrollment', url('/admin/manage/users/enrollments'))
            ->salutation('Lab SPARS System');
    }
}