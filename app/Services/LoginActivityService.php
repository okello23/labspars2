<?php

namespace App\Services;

use App\Models\LoginRecord as LoginActivityModel;
use Jenssegers\Agent\Facades\Agent;

class LoginActivityService
{
    public static function addToLog($description, $email, $ip): void
    {
        $log = [];
        $platform = Agent::platform();
        $browser = Agent::browser();

        $log['user_id'] = auth()->check() ? auth()->user()->id : null;
        $log['email'] = $email;
        $log['description'] = $description;
        $log['platform'] = $platform;
        $log['browser'] = $browser;
        $log['client_ip'] = $ip;

        LoginActivityModel::create($log);
    }
}
