<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_file_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the avatar file associated with the user.
     */
    public function avatarFile()
    {
        return $this->belongsTo(FileUpload::class, 'avatar_file_id', 'id');
    }

    /**
     * Get the avatar URL for the user.
     * Returns the avatar file path or a default avatar if not available.
     */
    public function getAvatarUrl(): string
    {
        if ($this->avatarFile?->file_path && file_exists(public_path($this->avatarFile->file_path))) {
            return asset($this->avatarFile->file_path);
        }
        
        // Return a default avatar if no avatar is set or file doesn't exist
        return asset('assets/img/user-img.png');
    }
}
