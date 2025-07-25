   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-4">Doctor Registration</h2>

        <!-- Session Message -->
        @if (session('message'))
            <div class="mb-4 text-green-600">{{ session('message') }}</div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('doctor.register.submit') }}">
            @csrf

            <label class="block mt-2 text-sm">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded p-2 mt-1">

            <label class="block mt-4 text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded p-2 mt-1">

            <label class="block mt-4 text-sm">Password</label>
            <input type="password" name="password" required class="w-full border rounded p-2 mt-1">

            <label class="block mt-4 text-sm">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border rounded p-2 mt-1">

            <label class="block mt-4 text-sm">Specialization</label>
            <select name="specialization_id" class="w-full border rounded p-2 mt-1">
                <option value="">-- Select --</option>
                @foreach ($specializations as $spec)
                    <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mt-4 text-sm">Bio</label>
            <textarea name="bio" rows="3" class="w-full border rounded p-2 mt-1">{{ old('bio') }}</textarea>

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded mt-6 hover:bg-blue-700">
                Register as Doctor
            </button>
        </form>
    </div>

</body>
</html>
