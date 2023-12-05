<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisation;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //User code

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

    //Tour code

    public function view_create_tour()
    {
        $users = User::with('organisation')->get();
        return view('admin.view_create_tour', compact('users'));
    }

    public function create_tour(Request $request)
    {
        $validatedData = $request->validate([
            'datetime' => 'required|date',
            'customer' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $tour = new Tour([
            'datetime' => $validatedData['datetime'],
            'customer' => $validatedData['customer'],
            'email' => $validatedData['email'],
            'description' => $validatedData['description'],
        ]);

        $tour->user()->associate(User::find($validatedData['user_id']));
        $tour->login_code = mt_rand(000000, 999999);
        $tour->save();

        return redirect()->route('admin.view_user')->with('success', 'Tour created successfully!');
    }

    public function view_edit_tour(User $user)
    {
        // Redirect to the edit page
    }

    public function edit_tour(User $user)
    {
        // Add your logic for editing a user
    }

    public function delete_tour(User $user)
    {
        // Add logic for deleting a tour
    }

}
