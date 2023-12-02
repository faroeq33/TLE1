<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function view_user()
    {
        $users = User::all();
        return view('admin.view_user', compact('users'));
    }

    public function view_create_user()
    {
        return view('admin.view_create_user');
    }

    public function create_user()
    {
        // Add your logic for editing a user
    }

    public function view_edit_user()
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

        return redirect()->route('admin.user')->with('success', 'User deleted successfully.');
    }

}
