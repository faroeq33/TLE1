@extends('layouts.app')

@section('content')
    <table>
        <tr>
            <td>Datum</td>
            <td>Tijd</td>
            <td>Klant</td>
            <td>Meer info</td>
            <td>Start livestream</td>
        </tr>

        @foreach($formattedTours as $formattedTour)
            <tr>
                <td> {{ $formattedTour['dateOnly'] }} </td>
                <td> {{ $formattedTour['timeOnly'] }} </td>
                <td> {{ $formattedTour['tour']->customer }} </td>
                <td>
{{--                    <form method="GET" action="{{ route('TourController.more', $formattedTour['tour']->id) }}">--}}
{{--                        @csrf--}}
{{--                        @method('get')--}}
{{--                        <button type="submit">Meer info</button>--}}
{{--                    </form>--}}
                </td>
                <td>
{{--                    <form method="GET" action="{{ route('TourController.startLivestream', $formattedTour['tour']->id) }}">--}}
{{--                        @csrf--}}
{{--                        @method('get')--}}
{{--                        <button type="submit">Start livestream</button>--}}
{{--                    </form>--}}
                </td>
            </tr>
        @endforeach
    </table>

@endsection
