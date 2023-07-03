<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\User;

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

    public function redirectToGoogle()
    {
        //echo ("redirecting to ggogle login");exit;
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            //dd($user, $finduser);

            if ($finduser) {
                
                /*
                Manually store the logged in user to use while adding artists, albums
                *To fix the issue of Auth:user() being empty after login
                */
                // session(['loggedInUser' => $finduser]);
                Auth::login($finduser);

                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('password23')

                ]);

                
                /*
                Manually store the logged in user to use while adding artists, albums
                *To fix the issue of Auth:user() being empty after login
                */
                // session(['loggedInUser' => $newUser]);
                Auth::login($newUser);

                return redirect()->back();
            }
        } catch (Exception $e) {
            //dd($e);
            // return redirect('authorize/google')->withErrors("Unable to authorze".$e);
            return redirect()->back()->withErrors("Unable to authorze" . $e);
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // dd('logoutAfterFeedback');
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/')->with('message', 'You have logged out successfully');
    }
}
