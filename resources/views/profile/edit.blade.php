<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zentify | Detail Profile: {{ Auth::user()->name }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('item/logo-ico.png') }}" type="image/png">
</head>

<body>
    @extends('layouts.user')

    @section('content')
        <section class="profile-section bg-gray-900 text-white py-12">
            <div class="container mx-auto">
                <h2 class="profile-section-title text-3xl font-bold mb-6 text-center">
                    Profile: {{ Auth::user()->name }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Profile Information Form -->
                    <div class="profile-card bg-gray-800 p-6 rounded-lg shadow-lg col-span-2">
                        <h3 class="text-2xl font-semibold mb-4">Perbarui Informasi Profil</h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Update Password Form -->
                    <div class="profile-card bg-gray-800 p-6 rounded-lg shadow-lg col-span-2 md:col-span-1">
                        <h3 class="text-2xl font-semibold mb-4">Perbarui Password</h3>
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Delete Account -->
                    <div class="profile-card-danger bg-red-700 p-6 rounded-lg shadow-lg col-span-2">
                        <h3 class="text-2xl font-semibold mb-4">Danger Zone</h3>
                        <p class="mb-4">Hapus akun Anda dan semua data Anda. Tindakan ini tidak dapat dibatalkan.</p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </section>
    @endsection

</body>

</html>
