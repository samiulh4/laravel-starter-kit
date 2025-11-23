<?php
namespace App\Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index()
    {
        return view('Web::index');
    }
}


?>