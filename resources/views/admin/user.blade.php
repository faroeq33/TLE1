@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b text-center">Name</th>
                <th class="py-2 px-4 border-b text-center">Email</th>
                <th class="py-2 px-4 border-b text-center">Organisation</th>
                <th class="py-2 px-4 border-b text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $user->organisation->name ?? '-' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Edit</a>
                        <form method="post" action="{{ route('admin.delete', $user->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
