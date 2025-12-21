<?php

namespace App\Modules\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceProduct extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
