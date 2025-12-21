<?php
namespace App\Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ecommerce\Models\EcommerceProduct;

class EcommerceWebController extends Controller
{
    public function index()
    {
        $products = EcommerceProduct::all();
        return view('Ecommerce::pages.web.index', compact('products'));
    }
}


?>