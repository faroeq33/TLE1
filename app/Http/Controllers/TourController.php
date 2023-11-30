<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index(): View
    {
        if (Auth::check()) {
            $tours = Tour::where('user_id', Auth::id())->get();
            $formattedTours = [];

            foreach ($tours as $tour) {
                $dateTime = $tour->datetime;
                $timeOnly = date('H:i:s', strtotime($dateTime));
                $dateOnly = date('d-m-Y', strtotime($dateTime));


                // If you want to store these formatted values for each tour
                $formattedTours[] = [
                    'tour' => $tour,
                    'timeOnly' => $timeOnly,
                    'dateOnly' => $dateOnly,
                ];
            }

            return view('overview', compact('formattedTours'));
        }

        return view('home');
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
