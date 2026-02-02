<?php
namespace App\Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ecommerce\Models\EcommerceProduct;
use App\Functions\EncryptionFunction;

class EcommerceWebController extends Controller
{
    public function index()
    {
        $products = EcommerceProduct::all();
        return view('Ecommerce::pages.web.index', compact('products'));
    }
}


?>