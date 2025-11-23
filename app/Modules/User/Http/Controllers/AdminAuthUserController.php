<?php
namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminAuthUserController extends Controller
{
    public function userProfileEdit()
    {
        return view("User::pages.admin-auth-user-edit");
    } // End userProfileEdit()
   
}// End of AdminAuthUserController class


?>