@extends('layouts.app')

@section('content')
    <table>
        <tr>
            <td>Datum</td>
            <td>Tijd</td>
            <td>Klant</td>
            <td>Terug naar overzicht</td>
            <td>Start livestream</td>
        </tr>

        @foreach($formattedTours as $formattedTour)
            <tr>
                <td> {{ $formattedTour['dateOnly'] }} </td>
                <td> {{ $formattedTour['timeOnly'] }} </td>
                <td> {{ $formattedTour['tour']->customer }} </td>
                <td>
                    <form method="GET" action="{{ route('overview') }}">
                        @csrf
                        @method('GET')
                        <button type="submit">Terug naar overzicht</button>
                    </form>
                </td>
                <td>
                    <form method="GET" action="{{ route('livestream', $formattedTour['tour']->login_code) }}">
                        @csrf
                        @method('get')
                        <button type="submit">Start livestream</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
