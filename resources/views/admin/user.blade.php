@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="mb-4 text-3xl font-bold">Admin Dashboard</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-center border-b">Name</th>
                    <th class="px-4 py-2 text-center border-b">Email</th>
                    <th class="px-4 py-2 text-center border-b">Organisation</th>
                    <th class="px-4 py-2 text-center border-b">Rol</th>
                    <th class="px-4 py-2 text-center border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 text-center border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-center border-b">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-center border-b">{{ $user->organisation->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-center border-b">{{ $user->is_admin ? 'Admin' : 'Gids' }}</td>

                        <td class="px-4 py-2 text-center border-b">
                            <a href="{{ route('admin.edit', $user->id) }}"
                                class="px-2 py-1 text-white bg-blue-500 rounded hover:bg-blue-700">Edit</a>
                            <form method="post" action="{{ route('admin.delete', $user->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
