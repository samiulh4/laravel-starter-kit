<?php
namespace App\Modules\Authentication\Services;

use App\Modules\FileManager\Services\FileManagerService;
use App\Modules\User\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthService
{
    protected FileManagerService $fileUpload;

    public function __construct(FileManagerService $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }

    public function register(array $data): AppUser
    {
        return DB::transaction(function () use ($data) {
            $avatar_file_id = null;
            if (!empty($data['avatar_file'])) {
                $imageData = [];
                $imageData['directory'] = 'uploads/avatars';
                $imageData['table_name'] = 'users';
                $imageData['field_name'] = 'avatar_file_id'; 
                $avatar_file_id = $this->fileUpload->uploadImage(
                    $data['avatar_file'],
                    $imageData
                );
            }

            $user = AppUser::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'gender_code' => $data['gender_code'],
                'identity' => $data['email'],
                'password' => Hash::make($data['password']),
                'avatar_file_id' => $avatar_file_id,
            ]);

            return $user;
        });
    }
}