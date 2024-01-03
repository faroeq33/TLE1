@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded p-6 shadow-md">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Tour Aanmaken') }}</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ __('Validatie Error') }}</strong>
                    <span class="block sm:inline">{{ __('Los deze errors op:') }}</span>
                    <ul class="list-disc mt-2 ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.create_tour') }}">
                @csrf

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-600">{{ __('Selecteer Gebruiker') }}</label>
                    <select name="user_id" id="user_id" class="mt-1 p-2 w-full border rounded-md">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->organisation ? $user->organisation->name : 'Geen Organisatie' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="datetime" class="block text-sm font-medium text-gray-600">{{ __('Tour Datum en Tijd') }}</label>
                    <input type="datetime-local" name="datetime" id="datetime" class="mt-1 p-2 w-full border rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="customer" class="block text-sm font-medium text-gray-600">{{ __('Klant Naam') }}</label>
                    <input type="text" name="customer" id="customer" class="mt-1 p-2 w-full border rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Klant Email') }}</label>
                    <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-600">{{ __('Klant Beschrijving') }}</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded-md" rows="4" required></textarea>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Tour Aanmaken') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
