<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $tour = Tour::where('user_id', Auth::id() )->get();

            $dateTime = Tour::datetime();
            $timeOnly = $dateTime->format('H:i:s');
            $dateOnly = $dateTime->format('d-m-Y');
        }
        return view('', compact('tour', $timeOnly, $dateOnly));
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
