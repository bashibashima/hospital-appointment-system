<x-guest-layout>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
@csrf

<!-- Email -->
<div class="mb-4">
<x-input-label for="email" :value="__('Email')" />

<x-text-input
id="email"
class="block mt-1 w-full"
type="email"
name="email"
:value="old('email')"
required autofocus />
</div>

<!-- Password -->
<div class="mb-4">
<x-input-label for="password" :value="__('Password')" />

<x-text-input
id="password"
class="block mt-1 w-full"
type="password"
name="password"
required />
</div>

<!-- Remember + Forgot -->
<div class="flex items-center justify-between mb-4">

<label class="flex items-center">
<input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm">
<span class="ml-2 text-sm text-gray-600">Remember me</span>
</label>

@if (Route::has('password.request'))
<a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
Forgot password?
</a>
@endif

</div>

<!-- Button -->
<div>
<x-primary-button class="w-full justify-center">
Login
</x-primary-button>
</div>

</form>

</x-guest-layout>