<?php

namespace App\Providers;

use App\Models\NetworkManagement\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
  /**
  * Register any application services.
  *
  * @return void
  */
  public function register()
  {
    // Passport::ignoreRoutes();
  }

  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    if (Auth::user()) {   // Check is user logged in
      View::share('facilityInfo', Institution::where('id', auth()->user()->id)->first());
    } else {
      View::share('facilityInfo', []);
    }

    Blade::directive('money_formart', function ($figure) {
      return "<?php echo number_format($figure,3); ?>";
    });

    Blade::directive('number_formart', function ($figure) {
      return "<?php echo number_format($figure); ?>";
    });

    Blade::directive('dateTimeFormater', function ($date) {
      return "<?php echo date('d-M-Y G:i:s', strtotime($date)); ?>";
    });

    if (env('APP_ENV') !== 'local') {
      URL::forceScheme('https');
    }
  }
}
