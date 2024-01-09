@extends('layouts.app')

@section('content')
    <div class="custom-container pt-4">
        <div class="flex flex-wrap justify-center">
            <div class="px-4 md:w-2/3">
                <div class="relative flex flex-col min-w-0 break-words  border border-gray-300 rounded border-1">
                    <div class="px-6 py-3 mb-0 text-gray-900 bg-gray-200 border-gray-300 border-b-1">
                        {{ __('Verify Your Email Address') }}</div>

                    <div class="p-6">
                        @if (session('resent'))
                            <div class="relative px-3 py-3 mb-4 text-green-800 bg-green-200 border border-green-300 rounded"
                                role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-primary">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
