@extends('layouts.app')

@section('title', 'Profil - Akademik POLNEP')

@section('content')
    <section class="bg-slate-50 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600">Akun Pengguna</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-900">Pengaturan Profil</h1>
                <p class="mt-2 text-slate-600">Kelola informasi akun, kata sandi, dan keamanan akun Anda.</p>
            </div>

            <div class="space-y-6">
                <div class="figma-card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
                </div>

                <div class="figma-card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
                </div>

                <div class="figma-card p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection
