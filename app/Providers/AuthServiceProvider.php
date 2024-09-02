<?php

namespace App\Providers;

use Laravel\Passport\Passport;
// use Illuminate\Support\Facades\Gate;
// use Laravel\Passport\PassportServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use App\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
  /**
  * The model to policy mappings for the application.
  *
  * @var array<class-string, class-string>
  */
  protected $policies = [
    'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
  * Register any authentication / authorization services.
  *
  * @return void
  */
  public function boot()
  {
    $this->registerPolicies();
    Passport::loadKeysFrom(__DIR__.'/secrets/oauth');

    Passport::tokensCan([
      'make-test-request' => 'Make test requests',
      'get-test-result' => 'Get test results',
      'query-sample' => 'Query samples'
    ]);
    // Passport::hashClientSecrets();

    // Passport::tokensExpireIn(now()->addDays(15));
    // Passport::refreshTokensExpireIn(now()->addDays(30));
    // Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    // Passport::routes();
  }
}
