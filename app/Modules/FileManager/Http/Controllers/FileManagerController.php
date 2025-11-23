<?php
namespace App\Modules\FileManager\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class FileManagerController extends Controller
{
    public function index()
    {
        return 'Hello from User Module';
    } // End authSignUp()
   
}// End of UserController class


?>