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
        return view('admin.user', compact('users'));
    }

    public function edit(User $user)
    {
        // Add your logic for editing a user
    }

    public function update(Request $request, User $user)
    {
        // Add your logic for updating a user
    }

}
