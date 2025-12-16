<?php
namespace App\Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

class EcommerceWebController extends Controller
{
    public function index()
    {
        return view('Ecommerce::pages.web.index');
    }
}


?>