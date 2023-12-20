@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded p-6 shadow-md">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Create User') }}</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ __('Validation Error') }}</strong>
                    <span class="block sm:inline">{{ __('Please correct the errors below and try again.') }}</span>
                    <ul class="list-disc mt-2 ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.create_user') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 p-2 w-full border rounded-md" required/>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 p-2 w-full border rounded-md" required/>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">{{ __('Password') }}</label>
                    <input type="text" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required/>
                </div>

                <div class="mb-4">
                    <label for="organisation_id"
                           class="block text-sm font-medium text-gray-600">{{ __('organisation') }}</label>
                    <select name="organisation_id" id="organisation_id" class="mt-1 p-2 w-full border rounded-md">
                        <option value="">No Organisation</option>
                        @foreach ($organisations as $organisation)
                            <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="is_admin" class="block text-sm font-medium text-gray-600">{{ __('Is Admin') }}</label>
                    <input type="checkbox" name="is_admin" id="is_admin" value="1"{{ old('is_admin') ? 'checked' : '' }}>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Create User') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
