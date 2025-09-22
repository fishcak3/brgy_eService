<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');
form(LoginForm::class);

$login = function () {
    $this->form->validate();

    if (!Auth::attempt($this->form->only('email', 'password'), $this->form->remember)) {
        throw ValidationException::withMessages([
            'form.email' => __('auth.failed'),
        ]);
    }

    Session::regenerate();

    $user = Auth::user();

    switch ($user->role) {
        case 'resident':
            return redirect()->route('resident.dashboard');
        case 'staff':
            return redirect()->route('staff.dashboard');
        case 'superadmin':
            return redirect()->route('admin.dashboard');
        default:
            return redirect()->route('welcome');
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-yellow-50 p-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg">
        {{-- Header --}}
        <div class="text-center p-6 border-b">
            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold">
                B
            </div>
            <h1 class="text-2xl font-semibold">Barangay Bakitiw</h1>
            <p class="text-gray-600">E-Services Management System</p>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-4">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input 
                        wire:model="form.email"
                        id="email" 
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600" 
                        type="email" 
                        name="email" 
                        required 
                        autofocus 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        wire:model="form.password"
                        id="password" 
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-600 focus:ring-green-600" 
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center space-x-2">
                        <input 
                            wire:model="form.remember"
                            id="remember" 
                            type="checkbox" 
                            class="rounded text-green-600 border-gray-300 shadow-sm focus:ring-green-600" 
                            name="remember">
                        <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-green-600 hover:underline" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700">
                    {{ __('Sign In') }}
                </x-primary-button>
            </form>

            {{-- Demo Accounts --}}
            <div class="mt-6 pt-6 border-t text-center text-sm text-gray-600">
                <p class="mb-2">Demo Accounts:</p>
                <div class="space-y-1 text-xs">
                    <p><strong>Resident:</strong> resident@test.com</p>
                    <p><strong>Staff:</strong> staff@test.com</p>
                    <p><strong>Admin:</strong> admin@test.com</p>
                    <p><strong>Password:</strong> password123</p>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-green-600">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
