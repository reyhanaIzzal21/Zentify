<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zentify | Login </title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('item/logo-ico.png') }}" type="image/png">
</head>

<body>
    <x-guest-layout>
        <div class="min-h-screen flex items-center justify-center bg-[var(--hitam)] text-[var(--putih)]">
            <img src="{{ asset('item/3d-headset.png') }}" alt="" class="headset">
            <img src="{{ asset('item/3d-torus.png') }}" alt="" class="trous">
            <img src="{{ asset('item/3d-torus.png') }}" alt="" class="trous-two">
            <!-- Wrapper -->
            <div class="rounded-lg shadow-lg max-w-3xl w-full flex overflow-hidden p-6 container-login">
                <!-- Gambar -->
                <div class="hidden md:block w-1/2 bg-cover bg-center custom-icon"
                    style="background-image: url('{{ asset('item/item-login.png') }}'); background-size: contain; background-repeat: no-repeat; ">
                </div>

                <!-- Card Container -->
                <div class="w-full md:w-2/3 p-8 space-y-6 flex flex-col justify-center">
                    <h1 class="text-5xl font-bold text-center text-[var(--biru)]">Login</h1>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div class="space-y-1">
                            <x-input-label for="email" :value="__('Email')" class="text-[var(--putih)] font-medium" />
                            <x-text-input id="email"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="email" name="email" :value="old('email')" required autofocus placeholder="Email"
                                autocomplete="new-email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <!-- Password -->
                        <div class="space-y-1">
                            <x-input-label for="password" :value="__('Password')" class="text-[var(--putih)] font-medium" />
                            <x-text-input id="password"
                                class="block w-full bg-[var(--abu-lebih-muda)] border-none rounded-lg text-[var(--hitam)] placeholder-[var(--abu-muda)] focus:ring-2 focus:ring-[var(--biru)]"
                                type="password" name="password" required placeholder="Password"
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[var(--biru)]" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center text-[var(--putih)]">
                                <input id="remember_me" type="checkbox"
                                    class="rounded bg-[var(--abu-lebih-muda)] text-[var(--biru)] focus:ring-[var(--biru)] focus:ring-offset-[var(--abu)]">
                                <span class="ml-2 text-sm">Ingat Saya</span>
                            </label>
                            <a href="{{ route('register') }}"
                                class="text-sm text-[var(--biru)] hover:text-[var(--biru-tua)]">Belum punya akun?
                                Daftar</a>
                        </div>

                        <!-- Button -->
                        <div>
                            <button type="submit"
                                class="w-full bg-[var(--biru)] hover:bg-[var(--biru-tua)] text-[var(--putih)] py-3 rounded-lg font-semibold shadow-lg transition ease-in-out duration-300">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-guest-layout>



</body>

</html>
