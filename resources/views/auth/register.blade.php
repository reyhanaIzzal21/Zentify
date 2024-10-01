<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zentify | Daftar</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('item/logo-ico.png') }}" type="image/png">
</head>

<body>
    <x-guest-layout>
        <div class="min-h-screen flex items-center justify-center bg-[var(--hitam)] text-[var(--putih)]">
            <img src="{{ asset('item/3d-headset.png') }}" alt="" class="headset">
            <img src="{{ asset('item/3d-torus.gif') }}" alt="" class="trous">
            <img src="{{ asset('item/3d-torus.gif') }}" alt="" class="trous-two">

            <!-- Wrapper -->
            <div class="rounded-lg shadow-lg max-w-3xl w-full flex overflow-hidden p-4 container-register">
                <!-- Gambar -->
                <div class="hidden md:block w-1/2 bg-cover bg-center custom-icon "
                    style="background-image: url('{{ asset('item/item-register.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;">
                </div>

                <!-- Card Container -->
                <div class="w-full md:w-1/2 p-8 space-y-6 flex flex-col justify-center">
                    <h1 class="text-5xl font-bold text-center text-[var(--biru)]">Daftar</h1>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('register') }}" autocomplete="off" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-1">
                            <x-input-label for="name" :value="__('Nama')" class="text-[var(--putih)] font-medium" />
                            <x-text-input id="name"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="text" name="name" :value="old('name')" required autofocus placeholder="Name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-1">
                            <x-input-label for="email" :value="__('Email')" class="text-[var(--putih)] font-medium" />
                            <x-text-input id="email"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="email" name="email" :value="old('email')" required placeholder="Email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-1">
                            <x-input-label for="password" :value="__('Password')" class="text-[var(--putih)] font-medium" />
                            <x-text-input id="password"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="password" name="password" required placeholder="Password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-1">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                                class="text-[var(--putih)] font-medium" />
                            <x-text-input id="password_confirmation"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="password" name="password_confirmation" required placeholder="Confirm Password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('login') }}"
                                class="underline text-sm text-[var(--biru)] hover:text-[var(--biru-tua)]">
                                {{ __('Log In') }}
                            </a>

                            <x-primary-button
                                class="ms-4 bg-[var(--biru)] hover:bg-[var(--biru-tua)] text-[var(--putih)] py-3 rounded-lg font-semibold shadow-lg transition ease-in-out duration-300">
                                {{ __('Daftar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-guest-layout>

</body>

</html>
