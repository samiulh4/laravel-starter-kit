<?php
namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class WebAuthUserController extends Controller
{
    public function userProfileView()
    {
        return view("User::pages.web.auth-user-view");

    } // End userProfileView()
   
}// End of WebAuthUserController class


?>