<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Events\SaveUser;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        Inertia::share('prefixname', config('jamie.prefixname'));
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prefixname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'photo' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $image_path = asset('storage/'.$request->file('photo')->store('image', 'public'));
        }
        $user = User::create([
            'name' => $request->firstname.' '.$request->lastname,
            'prefixname' => $request->prefixname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffixname' => $request->suffixname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $image_path,
        ]);

        event(new Registered($user));
        event(new saveUser($user ) );

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
