<x-guest-layout>
    <form method="POST" action="{{ route('doctor.register.submit') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input name="name" type="text" class="block w-full mt-1" required />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input name="email" type="email" class="block w-full mt-1" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input name="password" type="password" class="block w-full mt-1" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input name="password_confirmation" type="password" class="block w-full mt-1" required />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full">
                Register as Doctor
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
