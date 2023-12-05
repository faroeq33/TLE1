<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisation;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function view_user()
    {
        $users = User::all();
        return view('admin.view_user', compact('users'));
    }

    public function view_create_user()
    {
        $organisations = Organisation::all();
        return view('admin.view_create_user', compact('organisations'));
    }

    public function create_user(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'organisation_id' => 'nullable|exists:organisations,id',
            'is_admin' => 'nullable|boolean',
        ]);

        $user = new User($validatedData);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.view_user')->with('success', 'User registered successfully!');
    }

    public function view_edit_user(User $user)
    {
        return view('admin.view_edit_user');
    }

    public function edit_user(User $user)
    {
        // Add your logic for editing a user
    }

    public function delete_user(User $user)
    {
        $user->delete();

        return redirect()->route('admin.view_user')->with('success', 'User deleted successfully.');
    }

}
