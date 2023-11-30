@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="mb-4 text-3xl font-bold text-center">Meer informatie over tour</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <tr>
                <td class="px-4 py-2 text-center border-b">Datum</td>
                <td class="px-4 py-2 text-center border-b">Tijd</td>
                <td class="px-4 py-2 text-center border-b">Klant</td>
                <td class="px-4 py-2 text-center border-b">Meer informatie</td>
            </tr>

            @foreach($formattedTours as $formattedTour)
                <tr>
                    <td class="px-4 py-2 text-center border-b"> {{ $formattedTour['dateOnly'] }} </td>
                    <td class="px-4 py-2 text-center border-b"> {{ $formattedTour['timeOnly'] }} </td>
                    <td class="px-4 py-2 text-center border-b"> {{ $formattedTour['tour']->customer }} </td>
                    <td class="px-4 py-2 border-b"> {{ $formattedTour['tour']->description }}</td>
                </tr>
            @endforeach
        </table>
        <div class="container mx-auto">
            <div class="px-4 py-2 mx-4 flex justify-end">
                <form method="GET" action="{{ route('overview') }}" class="inline">
                    @csrf
                    @method('get')
                    <button class="px-2 py-1 mx-2 text-white bg-blue-500 rounded hover:bg-blue-700" type="submit">Terug naar overzicht</button>
                </form>

                <form method="GET" action="{{ route('livestream', $formattedTour['tour']->login_code) }}" class="inline">
                    @csrf
                    @method('get')
                    <button class="px-2 py-1 mx-2 text-white bg-red-500 rounded hover:bg-red-700" type="submit">Start livestream</button>
                </form>
            </div>
        </div>
    </div>
@endsection
