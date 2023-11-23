@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <div class="flex flex-wrap justify-center">
            <div class="px-4 md:w-2/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white border border-gray-300 rounded border-1">
                    <div class="px-6 py-3 mb-0 text-gray-900 bg-gray-200 border-gray-300 border-b-1">
                        {{ __('Reset Password') }}</div>

                    <div class="p-6">
                        @if (session('status'))
                            <div class="relative px-3 py-3 mb-4 text-green-800 bg-green-200 border border-green-300 rounded"
                                role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="flex flex-wrap mb-3">
                                <label for="email"
                                    class="pt-2 pb-2 pl-4 pr-4 mb-0 leading-normal md:w-1/3 text-md-end">{{ __('Email Address') }}</label>

                                <div class="pl-4 pr-4 md:w-1/2">
                                    <input id="email" type="email"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded @error('email') bg-red-700 @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="mt-1 text-sm text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap mb-0">
                                <div class="pl-4 pr-4 md:w-1/2 md:mx-1/3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
