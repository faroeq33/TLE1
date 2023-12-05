<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{

    public function overview()
    {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $tours = Tour::all();
        } else {
            $tours = $user->tours;
        }

        return view('tour.overview', compact('tours'));
    }


    public function detail($id): View
    {
        $user = Auth::user();
        $tour = Tour::find($id);

        // Check if the authenticated user is an admin or linked with the tour
        if ($user->is_admin || ($tour && $tour->user_id == $user->id)) {
            return view('tour.detail', compact('tour'));
        }

        // Returns the view "home" for unauthorized users
        return view('home');
    }


    public function livestreamConnect ($login_code):  View
    {
        return view('livestream');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
