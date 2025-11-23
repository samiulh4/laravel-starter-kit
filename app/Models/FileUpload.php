<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'files_upload';

    protected $fillable = [
        'file_path',
        'table_name',
        'field_name',
        'field_status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user that has this avatar file.
     */
    public function userAvatar()
    {
        return $this->hasOne(User::class, 'avatar_file_id', 'id');
    }
}
