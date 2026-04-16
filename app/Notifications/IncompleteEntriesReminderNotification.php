<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncompleteEntriesReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private array $entries)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Lab SPARS Reminder: Incomplete LSS Entries Need Attention')
            ->greeting('Hello ' . ($notifiable->fullName ?? $notifiable->name ?? 'User') . ',')
            ->line('You have incomplete LSS entries that still need action.')
            ->line('Please either complete these entries or cancel them if they should not proceed.');

        foreach (array_slice($this->entries, 0, 10) as $entry) {
            $mail->line(
                sprintf(
                    '%s | Visit %s | %s',
                    $entry['facility_name'],
                    $entry['visit_number'],
                    $entry['date_of_visit']
                )
            );
        }

        if (count($this->entries) > 10) {
            $mail->line('And ' . (count($this->entries) - 10) . ' more incomplete entries.');
        }

        return $mail
            ->action('Review Incomplete Entries', route('facility-visits'))
            ->line('Thank you for keeping your records up to date.');
    }
}
