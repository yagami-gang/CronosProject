<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('site.pages.profile.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('site.pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images/avatars'), $filename);
            $user->avatar = 'images/avatars/' . $filename;
        }
    
        $user->update($request->only(['name', 'email', 'phone', 'address']));
    
        return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès !');
    }

    public function passwordGet()
    {
        return view('site.pages.profile.password');
    }

    public function passwordPost(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::route('profile.show')->with('success', 'Mot de passe modifié avec succès !');
    }
}
