<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client;

class ApplicationRegistration extends Model
{
  use HasFactory;

  public function client()
  {
    return $this->belongsTo(Client::class, 'oauth_client_id','id');
  }

  public static function search($search)
  {
    return empty($search) ? static::query()
    : static::query()
    ->where('owner', 'like', '%'.$search.'%')
    ->orWhere('oauth_client_id', 'like', '%'.$search.'%')
    ->orWhere('application_version', 'like', '%'.$search.'%')
    ->orWhere('purpose_for_integration', 'like', '%'.$search.'%')
    ->orWhereHas('client', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    });
  }
}
