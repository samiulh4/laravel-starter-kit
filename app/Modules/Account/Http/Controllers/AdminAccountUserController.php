<?php

namespace App\Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;

class AdminAccountUserController extends Controller
{
    public function accountUserEdit()
    {
        return view("Account::pages.account-user-edit");
    }
}
