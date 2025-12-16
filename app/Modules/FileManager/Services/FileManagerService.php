<?php

namespace App\Modules\FileManager\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Modules\FileManager\Models\FileUpload;
use Intervention\Image\Laravel\Facades\Image;

class FileManagerService
{
    public function uploadImage(
        UploadedFile $file,
        array $data = []
    ): int|null {
        $directory = $data['directory'] ?? 'uploads/files';
        $maxWidth = $data['maxWidth'] ?? 300;
        $maxHeight = $data['maxHeight'] ?? 300;
        try {
            $fileName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $fullDirectory = public_path($directory);

            if (!is_dir($fullDirectory)) {
                mkdir($fullDirectory, 0755, true);
            }

            $filePath = $directory . '/' . $fileName;

            $image = Image::read($file)->scale($maxWidth, $maxHeight);
            $image->save($fullDirectory . '/' . $fileName);

            $fileUpload = new FileUpload();
            $fileUpload->file_path = $filePath;
            $fileUpload->table_name = $data['table_name'] ?? null;
            $fileUpload->field_name = $data['field_name'] ?? null;
            $fileUpload->save();

            return $fileUpload->id;
        } catch (Exception $e) {
            Log::error('Exception occurred [FMS-1001]', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    public function getFileUrlById(int|null $fileId): string
    {
        try {
            if ($fileId === null) {
                throw new Exception("File ID cannot be null.");
            }

            $fileUpload = FileUpload::find($fileId);

            if (!$fileUpload) {
                throw new Exception("File not found.");
            }

            return asset($fileUpload->file_path);
        } catch (Exception $e) {
            Log::error('Exception occurred [FFUI-102]', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'fileId' => $fileId,
            ]);
            return asset('assets/img/no-image-available.png');
        }
    }
}
