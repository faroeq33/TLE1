@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <div class="flex flex-wrap justify-center">
            <div class="px-4 md:w-2/3">
                <div class="relative flex flex-col min-w-0 break-words border border-gray-300 rounded border-1">
                    <div class="px-6 py-3 mb-0 text-gray-900 bg-gray-200 border-gray-300 border-b-1">{{ __('Dashboard') }}
                    </div>

                    <div class="p-6">
                        @if (session('status'))
                            <div class="relative px-3 py-3 mb-4 text-green-800 bg-green-200 border border-green-300 rounded"
                                role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
