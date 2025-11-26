<?php

namespace App\Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'users_account';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

}
