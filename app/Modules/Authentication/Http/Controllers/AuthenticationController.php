<?php

namespace App\Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Authentication\Http\Requests\AuthSignUpRequest;
use App\Modules\Authentication\Http\Requests\AuthSignInRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Modules\User\Models\AppUser;
use App\Modules\Authentication\Services\AuthService;


class AuthenticationController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authSignUp()
    {
        return view("Authentication::pages.sign-up");
    } // End authSignUp()

    public function authSignIn()
    {
        return view("Authentication::pages.sign-in");
    } // End authSignUp()

    public function authRegister(AuthSignUpRequest $request)
    {
        $data = $request->validated();
        $data['avatar_file'] = $request->file('avatar') ?? null;
        try {
            $this->authService->register($data);
            session()->flash('success', 'Account created successfully. Please log in. [AUTH-1001]');
            return redirect('/auth/sign-in');
        } catch (Exception $e) {
            Log::error('SignUp Error [AUTH-1002]:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withInput()->withErrors(['error' => 'There was an error creating your account. [AUTH-1002]']);
        }
    } // End signUpStore()

    public function authLogin(AuthSignInRequest $request)
    {
        $data = $request->validated();

        try {
            $user = AppUser::where('identity', $data['identity'])->where('user_status', 1)->first();

            if (!$user) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Account not found or inactive. [AUTH-2001]']);
            }
            if (!Hash::check($data['password'], $user->password)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Invalid credentials. [AUTH-2002]']);
            }

            Auth::login($user, $request->boolean('remember-me'));

            return redirect()->intended('/dashboard');
        } catch (Exception $e) {

            Log::error('SignIn Error [AUTH-2003]:', [
                'request' => $request->except(['password']),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => 'There was an error during login. Please try again later. [AUTH-2003]']);
        }
    }

    public function authSignOut()
    {
        Auth::logout(); // Logs out the user
        request()->session()->invalidate(); // Invalidates the session
        request()->session()->regenerateToken(); // Regenerates the CSRF token for security
        return redirect('/auth/sign-in');
    }
} // End of AuthenticationController class
