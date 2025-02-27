<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;


function getStatusColor($status)
{
    $colors = [
        'Pending' => 'dark',
        'Approved' => 'success',
        'Rejected' => 'danger',
        'Declined' => 'warning',
        'Canceled' => 'danger',
        'Submitted' => 'info',
        'Active' => 'info',
        'Viewed' => 'primary',
        'Processing' => 'secondary',
        'Closed' => 'primary',
        'Signed' => 'success',
        'Completed' => 'success',
        'Paid' => 'success',
        'Ongoing' => 'secondary',
        'Acknowledged' => 'success',
        // Add more statuses and corresponding colors as needed
    ];

    return $colors[$status] ?? 'secondary';
}

// Get percentage of any value based on the total value
function calculatePercentage($total, $subset, $precision = 2)
{
    if ($total == 0) {
        return 0.0; // To avoid division by zero
    }

    $percentage = ($subset / $total) * 100;

    return round($percentage, $precision);
}


function removeSymbolsAndTransform($inputString)
{
    // Convert the string to uppercase
    $uppercaseString = strtoupper($inputString);

    // Define an array of symbols you want to remove
    $symbols = ['-', '(', ')', '/', '_', ' '];

    // Use str_replace to remove the specified symbols
    $cleanString = str_replace($symbols, '', $uppercaseString);

    return $cleanString;
}

function formatDate($expression)
{
    return $expression != null ? date('d-M-Y', strtotime($expression)) : "'N/A";
}

function moneyFormat($figure)
{
    return $figure != null ? number_format($figure, 2) : "'N/A";
}

// Down load any file in the storage directory

function getDifferenceInDays($start_date, $end_date)
{
    $start_date = Carbon::parse($start_date);
    $end_date = Carbon::parse($end_date);
    // Calculate the difference in days
    $diffInDays = $end_date->diffInDays($start_date);

    return $diffInDays + 1;
}

function countWorkingDays($startDate, $endDate)
{
    $workingDays = 0;
    // $period = CarbonPeriod::create($startDate, $endDate);
    // // && !in_array($date->toDateString(), $holidays)

    // foreach ($period as $date) {
    //     // Check if the day is a working day (Monday to Friday)
    //     if ($date->isWeekday()) {
    //         $workingDays++;
    //     }
    // }

    // return $workingDays;

    $start = Carbon::createFromFormat('Y-m-d', $startDate);
    $end = Carbon::createFromFormat('Y-m-d', $endDate);

    $workingDays = 0;
    while ($start <= $end) {
        if (!$start->isWeekend()) {
            $workingDays++;
        }
        $start->addDay();
    }

    return $workingDays;
}
if (!function_exists('checkYesNoNA')) {
    /**
     * Check if the value is 1, 0 or other.
     *
     * @param int $value
     * @return string
     */
    function checkYesNoNA($value)
    {
        if ($value === 1) {
            return '1';
        } elseif ($value === 0) {
            return '0';
        }
        return 'NA';
    }
}