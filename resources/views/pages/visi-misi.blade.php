@extends('layouts.app')

@section('title', 'Visi dan Misi - Akademik POLNEP')

@section('content')
    <section class="relative flex min-h-[138px] items-center justify-center overflow-hidden bg-slate-900 text-center sm:min-h-[190px]">
        <img src="{{ asset($settings['visi_misi_hero_image'] ?? 'images/visimisi.jpg') }}" alt="{{ $settings['visi_misi_hero_title'] ?? 'Visi dan Misi' }}" class="absolute inset-0 h-full w-full object-cover opacity-40">
        <div class="absolute inset-0 bg-slate-950/45"></div>
        <div class="relative z-10 px-4 py-8 sm:py-12">
            <p class="text-[10px] font-bold uppercase tracking-widest text-amber-300 sm:text-xs">{{ $settings['visi_misi_hero_label'] ?? 'Profil Akademik' }}</p>
            <h1 class="mt-1 font-outfit text-3xl font-extrabold uppercase leading-none text-sky-300 sm:mt-2 sm:text-5xl">{{ $settings['visi_misi_hero_title'] ?? 'Visi & Misi' }}</h1>
            <p class="mx-auto mt-3 max-w-2xl text-xs leading-5 text-white sm:mt-4 sm:text-base sm:leading-6">
                {{ $settings['visi_misi_hero_description'] ?? 'Arah langkah dan komitmen Politeknik Negeri Pontianak dalam menyelenggarakan pendidikan vokasi yang unggul dan berdaya saing.' }}
            </p>
        </div>
    </section>

    <section class="bg-[#f3f6f8] py-12 sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] md:gap-16 lg:gap-24">
                <div class="min-w-0 overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/lab.png') }}" alt="{{ $visi->title ?? 'Visi Kami' }}" class="aspect-square h-full w-full object-cover">
                </div>
                <div class="min-w-0 md:pl-4 lg:pl-8">
                    <p class="text-xs font-bold uppercase tracking-wide text-amber-500 sm:text-sm">{{ $visi->title ?? 'Visi Kami' }}</p>
                    <h2 class="mt-2 font-outfit text-xl font-extrabold leading-tight text-slate-900 sm:mt-3 sm:text-3xl">Menjadi Lembaga Pendidikan Vokasi Unggul dan Berdaya Saing Global</h2>
                    <p class="mt-4 text-xs leading-5 text-slate-600 sm:mt-5 sm:text-sm sm:leading-7">{{ $visi->description ?? 'Menjadi perguruan tinggi vokasi unggul yang menghasilkan lulusan kompeten, inovatif, dan siap bersaing di dunia kerja.' }}</p>
                </div>
            </div>

            <div class="mx-auto mt-28 max-w-2xl text-center sm:mt-36">
                <p class="text-xs font-bold uppercase tracking-widest text-amber-500">Langkah Nyata</p>
                <h2 class="mt-2 font-outfit text-3xl font-extrabold text-sky-500">Misi Kami</h2>
                <p class="mt-2 text-xs text-slate-500">Upaya strategis kami dalam mewujudkan visi institusi.</p>
            </div>

            <div class="mt-7 grid gap-4 md:grid-cols-3 sm:mt-8">
                @foreach ($misiCards as $index => $point)
                    <article class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-6">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-sky-50 text-xs font-bold text-sky-500">0{{ $index + 1 }}</span>
                        <h3 class="mt-4 font-outfit text-xs font-bold text-sky-500 sm:mt-5 sm:text-sm">{{ $point['title'] }}</h3>
                        <p class="mt-2 text-[10px] leading-4 text-slate-500 sm:mt-3 sm:text-xs sm:leading-5">{{ $point['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
