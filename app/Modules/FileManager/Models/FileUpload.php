<?php

namespace App\Modules\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $table = 'files_upload';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
