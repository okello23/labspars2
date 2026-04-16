<?php

namespace App\Console\Commands;

use App\Models\Facility\FacilityVisit;
use App\Notifications\IncompleteEntriesReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class IncompleteEntryReminderCommand extends Command
{
    protected $signature = 'reminders:incomplete-entries';
    protected $description = 'Send reminder emails to users with incomplete LSS entries';

    public function handle(): int
    {
        $pendingVisits = FacilityVisit::query()
            ->with(['facility', 'createdBy'])
            ->where('status', 'Pending')
            ->whereNotNull('created_by')
            ->get()
            ->groupBy('created_by');

        $sent = 0;

        foreach ($pendingVisits as $visits) {
            $user = $visits->first()?->createdBy;

            if (!$user || blank($user->email)) {
                continue;
            }

            $entries = $visits->map(function ($visit) {
                return [
                    'facility_name' => $visit->facility?->name ?? 'Unknown Facility',
                    'visit_number' => $visit->visit_number,
                    'date_of_visit' => blank($visit->date_of_visit)
                        ? 'N/A'
                        : Carbon::parse($visit->date_of_visit)->format('d M Y'),
                ];
            })->values()->all();

            $user->notify(new IncompleteEntriesReminderNotification($entries));
            $sent++;
        }

        $this->info("Sent incomplete entry reminders to {$sent} user(s).");

        return self::SUCCESS;
    }
}
