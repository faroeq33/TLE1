<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tour;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        return view('tour.overview')->with('user', $user)->with('tours', $tours);
    }


    public function detail($id): View
    {
        $user = Auth::user();
        $tour = Tour::find($id);

        // Check if the authenticated user is an admin or linked with the tour
        if ($user->is_admin || ($tour && $tour->user_id == $user->id)) {
            return view('tour.detail')->with('user', $user)->with('tour', $tour);
        }
        return view('tour.overview');
    }


    public function guideLivestream ($login_code)
    {
//        ddd   ($login_code);
        return view('index', [
            'tour' => Tour::with('user')->where('tour.login_code', '=', $login_code)
            ]);
    }

    public function ipCarStream ($login_code)
    {
//        ddd   ($login_code);
        return view('stream', [
            'tour' => Tour::with('user')->where('tour.login_code', '=', $login_code)
        ]);
    }

    public function viewerLivestream ($login_code)
    {
//        ddd   ($login_code);
        return view('viewer', [
            'tour' => Tour::with('user')->where('tour.login_code', '=', $login_code)
        ]);
    }
}
