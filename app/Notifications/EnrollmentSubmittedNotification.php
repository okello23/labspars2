<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->cc('customercare@cphl.go.ug', 'CPHL Customer Care')
            ->subject('Lab SPARS — Enrollment Request Received')
            ->greeting('Dear ' . $this->user->first_name . ',')
            ->line('Your self-enrollment request for Lab SPARS has been received and is pending administrator approval.')
            ->line('You will receive another email with your login credentials once your account has been approved.')
            ->line('If you did not initiate this request, please ignore this email.')
            ->salutation('Central Public Health Laboratories (CPHL)');
    }
}