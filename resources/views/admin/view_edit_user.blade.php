@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded p-6 shadow-md">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Gebruiker Aanpassen') }}</h2>

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

            <form method="POST" action="{{ route('admin.edit_user', $user) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">{{ __('Naam') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 p-2 w-full border rounded-md" required/>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 p-2 w-full border rounded-md" required/>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">{{ __('Wachtwoord') }}</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md"/>
                </div>

                <div class="mb-4">
                    <label for="organisation_id"
                           class="block text-sm font-medium text-gray-600">{{ __('Organisatie') }}</label>
                    <select name="organisation_id" id="organisation_id" class="mt-1 p-2 w-full border rounded-md">
                        <option value="">Geen Organisatie</option>
                        @foreach ($organisations as $organisation)
                            <option value="{{ $organisation->id }}"{{ old('organisation_id', $user->organisation_id) == $organisation->id ? ' selected' : '' }}>
                                {{ $organisation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="is_admin" class="block text-sm font-medium text-gray-600">{{ __('Admin Gebruiker') }}</label>
                    <input type="checkbox" name="is_admin" id="is_admin" value="1"{{ old('is_admin', $user->is_admin) ? ' checked' : '' }}>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Gebruiker Aanpassen') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
