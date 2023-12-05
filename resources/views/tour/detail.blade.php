@extends('layouts.app')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded p-6 shadow-md">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Tour Details') }}</h2>

            <!-- Display tour details -->
            <div class="mb-4">
                <strong>Gids:</strong> {{ $tour->user->name }} - {{ $tour->user->organisation ? $tour->user->organisation->name : 'No Organisation' }}
            </div>
            <div class="mb-4">
                <strong>Klant:</strong> {{ $tour->customer }}
            </div>
            <div class="mb-4">
                <strong>Klant Email:</strong> {{ $tour->email }}
            </div>
            <div class="mb-4">
                <strong>Datum:</strong> {{ $tour->datetime->format('d F Y') }}
            </div>
            <div class="mb-4">
                <strong>Tijd:</strong> {{ $tour->datetime->format('H:i') }}
            </div>
            <div class="mb-4">
                <strong>Beschrijving:</strong> {{ $tour->description }}
            </div>
            <div class="mb-4">
                @if ($currentUser && $currentUser->is_admin)
                    <a href="{{ route('admin.view_edit_tour', $tour->id) }}" class="px-2 py-1 text-white bg-blue-500 rounded hover:bg-blue-700">Edit</a>
                    <form method="post" action="{{ route('admin.delete_tour', $tour->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                    </form>
                @else
                    <a href="{{ route('livestream', $tour->login_code) }}" class="px-2 py-1 text-white bg-green-500 rounded hover:bg-green-700">Start Livestream</a>
                @endif
            </div>


            <!-- Back button -->
            <a href="{{ route('overview') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Terug naar overzicht</a>
        </div>
    </div>
@endsection
