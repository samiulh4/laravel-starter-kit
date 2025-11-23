<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AppUser extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->created_by = $user->id;
            $user->updated_by = $user->id;
            $user->saveQuietly(); // Use saveQuietly to avoid triggering another save event
        });
        static::saving(function ($user) {
            $user->updated_by = $user->id;
        });
    }
}
