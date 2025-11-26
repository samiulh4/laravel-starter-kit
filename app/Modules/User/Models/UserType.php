<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'users_type';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
