@extends('layouts.app')

@section('content')
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap justify-center">
            <div class="pl-4 pr-4 md:w-2/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white border border-gray-300 rounded border-1">
                    <div class="px-6 py-3 mb-0 text-gray-900 bg-gray-200 border-gray-300 border-b-1">{{ __('Login') }}
                    </div>

                    <div class="flex-auto p-6">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="flex flex-wrap mb-3">
                                <label for="email"
                                    class="pt-2 pb-2 pl-4 pr-4 mb-0 leading-normal md:w-1/3 text-md-end">{{ __('Email Address') }}</label>

                                <div class="pl-4 pr-4 md:w-1/2">
                                    <input id="email" type="email"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded @error('email') bg-red-700 @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="mt-1 text-sm  text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap mb-3">
                                <label for="password"
                                    class="pt-2 pb-2 pl-4 pr-4 mb-0 leading-normal md:w-1/3 text-md-end">{{ __('Password') }}</label>

                                <div class="pl-4 pr-4 md:w-1/2">
                                    <input id="password" type="password"
                                        class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded @error('password') bg-red-700 @enderror"
                                        name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="mt-1 text-sm  text-red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap mb-3">
                                <div class="pl-4 pr-4 md:w-1/2 md:mx-1/3">
                                    <div class="relative block mb-2">
                                        <input class="absolute mt-1 " type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="pl-6 mb-0 text-gray-700" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap mb-0">
                                <div class="pl-4 pr-4 md:w-2/3 md:mx-1/3">
                                    <button type="submit"
                                        class="inline-block px-3 py-1 font-normal leading-normal text-center text-white no-underline whitespace-no-wrap align-middle bg-blue-600 border rounded select-none hover:bg-blue-600">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="inline-block px-3 py-1 font-normal leading-normal text-center text-blue-700 no-underline whitespace-no-wrap align-middle bg-transparent border rounded select-none"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
