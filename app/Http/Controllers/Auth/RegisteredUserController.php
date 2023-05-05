<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Product;
use Mail;
use App\Mail\RegMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $layout = Product::layout();
        return view('auth.register', compact('layout'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (stripos($request->username, 'DROP TABLE') !== false) {
            return redirect()->back()->withInput()->with('error', 'Hehe!');
        }
        $request->validate([
            'birthday' => ['required', 'before:18 years ago'],
            'username' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $random = '';
        for ($i = 0; $i < 60; $i++) {
            $random .= $characters[rand(0, strlen($characters) - 1)];
        }
        $u = "/storage/users/profile.jpg";
        $user = User::create([
            'username' => $request->username,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'token' => $random,
            'date_of_birth' => $request->birthday,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'file' => $u,
            'remember_token' => ""
        ]);
        event(new Registered($user));
        if (request("emailselect") == "on") {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
            $random1 = '';
            for ($i = 0; $i < 60; $i++) {
                $random1 .= $characters[rand(0, strlen($characters) - 1)];
            }
            $email = Email::create([
                'userid' => $user->id,
                'email' => $request->email,
                'token' => $random1
            ]);
        }
        $mailData = [
            'activator' => $random,
            'name' => $request->firstname
        ];
        Mail::to($request->email)->send(new RegMail($mailData));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
