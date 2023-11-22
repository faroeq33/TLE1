@extends('layouts.app')

@section('content')
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap justify-center">
            <div class="md:w-2/3 pr-4 pl-4">
                <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('Dashboard') }}
                    </div>

                    <div class="flex-auto p-6">
                        @if (session('status'))
                            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800"
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
