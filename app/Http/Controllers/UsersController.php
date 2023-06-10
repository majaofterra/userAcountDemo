<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rules;
use App\Events\SaveUser;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Inertia::share('users', User::get());
        return Inertia::render('Users/index');
    }

    public function trashed()
    {
        Inertia::share('users', User::onlyTrashed()->get());
        return Inertia::render('Users/trashed');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Inertia::share('prefixname', config('jamie.prefixname'));
        return Inertia::render('Users/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'prefixname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'max:255',
            'photo' => 'required|mimes:png,jpg,jpeg|max:2048',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
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
            'password' => bcrypt($request->password),
            'photo' => $image_path,
        ]);
        event(new saveUser($user) );
        return redirect()->route('users.index');
   }

    /**
     * Display the specified resource.
     */
    public function show(User $user,String $id)
    {
        Inertia::share('user', User::find(Hashids::decode($id)[0]));
        return Inertia::render('Users/show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user,String $id)
    {
        Inertia::share('prefixname', config('jamie.prefixname'));
        Inertia::share('user', User::find(Hashids::decode($id)[0]));
        return Inertia::render('Users/edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user,String $id)
    {
        $request->validate([
            'prefixname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'max:255',
            'lastname' => 'required|string|max:255',
            'suffixname' => 'max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $userID = Hashids::decode($id)[0];

        $image_path = User::select('photo')->where('id', $userID)->pluck('photo')->first();
        if ($request->hasFile('photo')) {
            $image_path = asset('storage/'.$request->file('photo')->store('image', 'public'));
        }

        User::where('id', $userID )
        ->update([
            'name' => $request->firstname.' '.$request->lastname,
            'prefixname' => $request->prefixname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffixname' => $request->suffixname,
            'email' => $request->email,
            'photo' => $image_path,
        ]);

        event(new saveUser(User::find($userID) ) );

        return redirect()->route('users.index');
    }

    /**
     * soft remove the specified resource from storage.
     */
    public function destroy(User $user, String $id)
    {
        User::find(Hashids::decode($id)[0])->delete();
        return  User::select('name','id','photo')->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(String $id)
    {
        User::withTrashed()->find(Hashids::decode($id)[0])->forceDelete();
        return  User::onlyTrashed()->select('name','id')->get();
    }

    /**
     * restore the specified resource from storage.
     */
    public function restore(String $id)
    {
        User::withTrashed()->find(Hashids::decode($id)[0])->restore();
        return  User::onlyTrashed()->select('name','id')->get();
    }
    
}
