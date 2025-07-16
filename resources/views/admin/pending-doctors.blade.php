<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Pending Doctor Approvals</h2>
    </x-slot>

    <div class="py-4">
        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($pendingDoctors->isEmpty())
            <p>No doctors waiting for approval.</p>
        @else
            <ul class="space-y-4">
                @foreach ($pendingDoctors as $doctor)
                    <li class="flex justify-between items-center border-b pb-2">
                        <div>
                            <strong>{{ $doctor->name }}</strong> - {{ $doctor->email }}
                        </div>
                        <form method="POST" action="{{ route('admin.approve.doctor', $doctor->id) }}">
                            @csrf
                            <button class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
