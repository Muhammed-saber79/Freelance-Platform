<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    protected $guard = 'web';
    public function __construct (Request $request) {
        if ($request->is('admin/*')) {
            $this->guard = 'admin';
        }
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'routePrefix' => $this->guard == 'admin' ? 'admin.' : ''
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /**
         * This is the original way to apply authentication.
         */
        $request->authenticate($this->guard);

        /**
         * This is the second way to do the same functionality.
         * 
         * $user = User::where('email', '=', $request->post('email'))->first();

         * if( !$user || !Hash::check($request->post('password'), $user->password) ){
         *      throw ValidationException::withMessages([
         *          'email' => 'Invalid Credentials...!'
         *      ]);
         * }
         * 
         * Auth::login($user);
         */

        /**
         * This is the third way to do the same functionality.
         * 
         * Auth::attempt([
         * 'email' => $request->post('email'),
         * 'password' => $request->post('password'),
         * ]);
         * 
         */
        
        $request->session()->regenerate();

        return redirect()->intended( $this->guard == 'admin' ? '/dashboard' : RouteServiceProvider::HOME );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard($this->guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
