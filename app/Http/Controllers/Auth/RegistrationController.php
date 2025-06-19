<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller
{
    public function showCatererForm()
    {
        return view('auth.register-caterer');
    }

    public function storeCaterer(Request $request)
    {
        return $this->registerUser($request, 'caterer');
    }

    public function showDriverForm()
    {
        return view('auth.register-driver');
    }

    public function storeDriver(Request $request)
    {
        return $this->registerUser($request, 'driver');
    }

    protected function registerUser(Request $request, string $roleName)
    {
        // Anda bisa menambahkan validasi unik per peran di sini jika perlu
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted', 'required'],
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Beri Peran Aplikasi yang sesuai
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $user->roles()->attach($role);
        }
        
        // Buat tim personal mereka, di mana mereka akan menjadi owner/admin tim
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => $request->name."'s Team",
            'personal_team' => true,
        ]));
        
        // Login-kan user dan trigger event
        event(new Registered($user));
        Auth::login($user);

        // Arahkan ke dashboard utama setelah registrasi
        return redirect(config('fortify.home'));
    }
}
