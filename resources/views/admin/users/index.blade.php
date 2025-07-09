@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Manage Users</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto bg-white rounded shadow">
        <thead class="bg-blue-100">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Current Role</th>
                <th class="p-3 text-left">Change Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->role }}</td>
                <td class="p-3">
                    <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}">
                        @csrf
                        <select name="role" class="border border-gray-300 rounded px-2 py-1">
                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                            <option value="doctor" @selected($user->role == 'doctor')>Doctor</option>
                            <option value="patient" @selected($user->role == 'patient')>Patient</option>
                        </select>
                        <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
