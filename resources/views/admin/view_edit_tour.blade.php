@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded p-6 shadow-md">
            <h2 class="text-2xl font-semibold mb-4">{{ __('Edit Tour') }}</h2>

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

            <form method="POST" action="{{ route('admin.edit_tour', ['tour' => $tour]) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-600">{{ __('Select User') }}</label>
                    <select name="user_id" id="user_id" class="mt-1 p-2 w-full border rounded-md">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $tour->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->organisation ? $user->organisation->name : 'No Organisation' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="datetime" class="block text-sm font-medium text-gray-600">{{ __('Tour Date and Time') }}</label>
                    <input type="datetime-local" name="datetime" id="datetime" class="mt-1 p-2 w-full border rounded-md" />
                </div>

                <div class="mb-4">
                    <label for="customer" class="block text-sm font-medium text-gray-600">{{ __('Customer Name') }}</label>
                    <input type="text" name="customer" id="customer" class="mt-1 p-2 w-full border rounded-md" value="{{ $tour->customer }}" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Customer Email') }}</label>
                    <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" value="{{ $tour->email }}" />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-600">{{ __('Tour Description') }}</label>
                    <textarea name="description" id="description" class="mt-1 p-2 w-full border rounded-md" rows="4">{{ $tour->description }}</textarea>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Update Tour') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
