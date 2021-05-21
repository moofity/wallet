<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\IUserService;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle social provider callback after authentication on their side
     */
    public function handleProviderCallback(IUserService $userService, string $driver): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($driver)->user();
            $user = $userService->findOrCreate(
                $socialUser->getEmail(),
                [
                    'provider_name' => $driver,
                    'provider_id' => $socialUser->getId(),
                    'name' => $socialUser->getName(),
                    'email_verified_at' => now()
                ]
            );

            auth()->login($user, true);
            return redirect($this->redirectPath());
        } catch (Exception $e) {
            Log::notice('Exception thrown while handling social provider callback', ['message' => $e->getMessage()]);
            return redirect()->route('login');
        }
    }

    /**
     * Redirect to social provider
     */
    public function redirectToProvider(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }
}
