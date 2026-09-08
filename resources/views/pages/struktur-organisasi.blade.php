@extends('layouts.app')

@section('title', 'Struktur Organisasi - Akademik POLNEP')

@section('content')
    @php
        $photo = static function ($person) {
            return $person->photo && file_exists(public_path($person->photo)) ? asset($person->photo) : asset('images/foto.png');
        };
    @endphp

    <section class="bg-[#f3f6f8] pb-16 pt-10 sm:pb-20 sm:pt-14">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="font-outfit text-4xl font-extrabold uppercase leading-none text-sky-400 sm:text-5xl">Struktur</h1>
                <h2 class="font-outfit text-4xl font-extrabold uppercase leading-none text-[#123f68] sm:text-5xl">Organisasi</h2>
                <p class="mx-auto mt-5 max-w-2xl text-sm font-bold uppercase leading-6 text-slate-500 sm:text-base">
                    Susunan pengelola administrasi akademik, kemahasiswaan, perencanaan, dan sistem informasi Politeknik Negeri Pontianak.
                </p>
            </div>

            <div class="relative mx-auto mt-9 max-w-3xl">
                @if ($leaders->count())
                    <div class="flex flex-col items-center">
                        @foreach ($leaders as $leader)
                            <article class="relative flex min-h-[145px] w-full max-w-[280px] flex-col items-center justify-center rounded-xl border border-slate-200 bg-white p-5 text-center shadow-[0_4px_14px_rgba(15,23,42,0.04)]">
                                <img src="{{ $photo($leader) }}" alt="{{ $leader->name }}" class="mx-auto h-16 w-16 rounded-full object-cover ring-2 ring-slate-300">
                                <h3 class="mt-3 text-sm font-bold text-[#123f68]">{{ $leader->name }}</h3>
                                <p class="mt-1 text-[10px] font-bold uppercase text-sky-600">{{ $leader->jabatan }}</p>
                                <p class="mt-2 text-[9px] text-slate-400">NIP {{ $leader->nip }}</p>
                            </article>
                            @if (!$loop->last)
                                <div class="h-8 w-px bg-slate-300" aria-hidden="true"></div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($members->count())
                    @if ($leaders->count())
                        <div class="mx-auto h-8 w-px bg-slate-300" aria-hidden="true"></div>
                    @endif
                    <div class="mx-auto mt-10 max-w-2xl text-center">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">&mdash; Kepala Sub-Bagian / Urusan Layanan &mdash;</p>
                    </div>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($members as $member)
                            <article class="flex min-h-[150px] flex-col items-center justify-center rounded-xl border border-slate-200 bg-white p-5 text-center shadow-[0_4px_14px_rgba(15,23,42,0.04)]">
                                <img src="{{ $photo($member) }}" alt="{{ $member->name }}" class="mx-auto h-14 w-14 rounded-full object-cover ring-2 ring-slate-200">
                                <h3 class="mt-3 text-xs font-bold text-[#123f68]">{{ $member->name }}</h3>
                                <p class="mt-1 text-[10px] font-bold uppercase text-sky-600">{{ $member->jabatan }}</p>
                                <p class="mt-2 text-[9px] text-slate-400">{{ $member->nip }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
