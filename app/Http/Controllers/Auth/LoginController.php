<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ke mana user diarahkan setelah login.
     * Ini tidak dipakai kalau Anda override redirectTo().
     */
    protected $redirectTo = '/home';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override kredensial login untuk menerima email atau NIS.
     */
    protected function credentials(Request $request)
    {
        $loginInput = $request->input('email'); // dari input <input name="email">
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        return [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];
    }

    /**
     * Override redirect setelah login berdasarkan role.
     */
    protected function redirectTo()
    {
        return match (Auth::user()->role) {
            default => '/home',
        };
    }
}
