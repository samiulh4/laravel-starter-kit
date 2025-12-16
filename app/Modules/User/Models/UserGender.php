<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserGender extends Model
{
    protected $table = 'users_gender';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
