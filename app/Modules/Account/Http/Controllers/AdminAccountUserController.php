<?php

namespace App\Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Modules\User\Models\AppUser;
use App\Modules\User\Models\UserGender;
use App\Modules\User\Models\UserType;
use App\Modules\Account\Models\UserAccount;
use App\Modules\FileManager\Services\FileManagerService;


class AdminAccountUserController extends Controller
{
    public function accountUserEdit()
    {
        $data = [];
        $data['user'] = AppUser::find(Auth::id());
        $fileService = new FileManagerService();
        $data['avatar'] = $fileService->getFileUrlById($data['user']->avatar_file_id ?? null);
        $data['account'] = UserAccount::where('user_id', $data['user']->id)->first();
        $data['userTypes'] = UserType::pluck('name', 'user_type_code');
        $data['genders'] = UserGender::pluck('name', 'gender_code');
        return view("Account::pages.account-user-edit", $data);
    }

    public function accountUserUpdate(Request $request) :  \Illuminate\Http\JsonResponse
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile_no' => 'nullable|string|max:20',
                //'user_type_code' => 'required|string|exists:user_types,user_type_code',
                //'gender_code' => 'required|string|exists:user_genders,gender_code',
                'national_id' => 'nullable|string|max:50',
                'passport_id' => 'nullable|string|max:50',
                //'timeZones' => 'nullable|string',
                'avatar_file_id' => 'nullable|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = AppUser::find(Auth::id());

            // Update user data
            $user->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'gender_code' => $request->gender_code,
                'avatar_file_id' => $request->avatar_file_id
            ]);

            // Update or create user account data
            UserAccount::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'national_id' => $request->national_id,
                    'passport_id' => $request->passport_id,
                    //'timezone' => $request->timeZones
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!',
                'data' => $user
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating user profile: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload user avatar via AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,gif|max:800'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid file',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('avatar')) {
                $fileService = new FileManagerService();
                $imageData = [];
                $imageData['directory'] = 'uploads/avatars';
                $imageData['table_name'] = 'users';
                $imageData['field_name'] = 'avatar_file_id'; 
                $avatar_file_id = $fileService->uploadImage(
                    $request->file('avatar'),
                    $imageData
                );
                 return response()->json([
                    'status' => true,
                    'message' => 'Avatar uploaded successfully!',
                    'avatar_file_id' => $avatar_file_id
                ], 200);  
            }
           
              

            return response()->json([
                'status' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (Exception $e) {
            Log::error('Error uploading avatar: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while uploading avatar'
            ], 500);
        }
    }

    /**
     * Delete user account via AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAccount(Request $request)
    {
        try {
            $user = Auth::user();

            Log::info('User account deleted', ['user_id' => $user->id]);

            // Delete user and related data
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Account deleted successfully!',
                'redirect' => route('login')
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting account: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting account'
            ], 500);
        }
    }

    /**
     * Get user profile data via AJAX
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserProfile()
    {
        try {
            $user = Auth::user();
            $account = UserAccount::where('user_id', $user->id)->first();

            return response()->json([
                'status' => true,
                'data' => [
                    'user' => $user,
                    'account' => $account
                ]
            ], 200);

        } catch (Exception $e) {
            Log::error('Error fetching user profile: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching profile'
            ], 500);
        }
    }
}

