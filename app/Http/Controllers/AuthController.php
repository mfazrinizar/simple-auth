<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $rules = [
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Validation Failed',
                    'errors'  => $validator->errors()
                ], 422);
            } else {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('welcome')
                ->withSuccess('You have successfully logged in.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        } else {
            return redirect()
                ->back()
                ->withErrors(['login' => 'Invalid credentials, please try again.'])
                ->withInput();
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        // Define your validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,8}$/'
            ],
            'password' => 'required|string|min:8|confirmed',
        ];

        // If you want to handle validation yourself instead of the default redirect:
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Validation Failed',
                    'errors'  => $validator->errors()
                ], 422);
            } else {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $data = $request->all();
        $user = $this->create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Great! You have successfully registered.',
                'user'    => $user
            ], 201);
        }

        return redirect()->route('login')->withSuccess('Great! You have successfully registered.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function welcome()
    {
        if (Auth::check()) {
            return view('welcome');
        }

        return redirect()->route('login')->with('error', 'You must log in to access the dashboard.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
