<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email', 'description', 'platform', 'browser', 'client_ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('email', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('platform', 'like', '%'.$search.'%')
                ->orWhere('browser', 'like', '%'.$search.'%')
                ->orWhere('client_ip', 'like', '%'.$search.'%');
    }
}
