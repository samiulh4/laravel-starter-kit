<?php

namespace App\Functions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Functions\EncryptionFunction;

class HelperFunction
{
    public static function getAuthUserId() : int|null
    {
        // Auth::id() is a shortcut that directly returns the authenticated user's ID or null if not authenticated.
        return Auth::id();
    }

    public static function getUserEntryId($user)
    {
        return Auth::id() ?? $user->id;
    }
}
