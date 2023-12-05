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


    public function detail($id): View {
        //Checks if the user is logged in
        if (Auth::check()) {
            //Finds tour with the corresponding sent id in the database
            $tour = Tour::find($id);
            $formattedTours = [];

            //Takes the datetime and puts it in a timeOnly and date only variable
            $dateTime = $tour->datetime;
            $timeOnly = date('H:i:s', strtotime($dateTime));
            $dateOnly = date('d-m-Y', strtotime($dateTime));

            //Stores these variables inside formatted tours
            $formattedTours[] = [
                'tour' => $tour,
                'timeOnly' => $timeOnly,
                'dateOnly' => $dateOnly
            ];
            //Returns the view "detail" with formatted tours
            return view('tour.detail', compact('formattedTours'));
        }
        //Returns the view "home"
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
