@extends('layouts.app')

@section('content')
    <table>
        @foreach($tour as $Tour)
            <tr>
                <td>Datum</td>
                <td>Tijd</td>
                <td>Klant</td>
                <td>Meer info</td>
                <td>Start livestream</td>
            </tr>

            <tr>
                <td> {{ $dateOnly }} </td>
                <td> {{ $timeOnly }} </td>
                <td> {{ $Tour->customer }} </td>
                <td>
                    <form method="GET" action="{{ route('TourController.more', [$Tour->id]) }}">
                        @csrf
                        @method('get')
                        <button type="submit">Meer info</button>
                    </form>
                </td>
            <td>    <form method="GET" action="{{ route('TourController.startLivestream', [$Tour->id]) }}">
                        @csrf
                        @method('get')
                        <button type="submit">Meer info</button>
                    </form> </td>
            </tr>
        @endforeach
    </table>
@endsection
