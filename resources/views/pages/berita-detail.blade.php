@extends('layouts.app')

@section('title', $post->title . ' - Akademik POLNEP')

@section('content')
    <article class="bg-[#f3f6f8] py-8 sm:py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-[10px] font-bold uppercase tracking-wide text-slate-500">
                <a href="{{ route('beranda') }}" class="hover:text-sky-700">Beranda</a>
                <span class="mx-1">/</span>
                <a href="{{ route('berita') }}" class="hover:text-sky-700">Berita</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700">{{ $post->category_name ?? 'Akademik' }}</span>
            </nav>

            <div class="mx-auto mt-5 max-w-5xl">
                <span class="inline-flex rounded-full bg-sky-500 px-4 py-1.5 text-[10px] font-bold uppercase tracking-wide text-white">
                    {{ $post->category_name ?? 'Berita' }}
                </span>
                <h1 class="mt-3 max-w-4xl font-outfit text-3xl font-extrabold leading-[1.08] tracking-tight text-[#123f68] sm:text-5xl">
                    {{ $post->title }}
                </h1>

                <div class="mt-4 flex flex-wrap items-center gap-x-8 gap-y-3 text-xs text-slate-600 sm:gap-x-10">
                    <span class="inline-flex items-center whitespace-nowrap"><i class="fa-regular fa-calendar mr-2 text-slate-700"></i>{{ \Illuminate\Support\Carbon::parse($post->published_at)->translatedFormat('d M Y') }}</span>
                    <span class="inline-flex items-center whitespace-nowrap"><i class="fa-regular fa-clock mr-2 text-slate-700"></i>{{ $post->read_time ?: 1 }} Menit baca</span>
                    <span class="inline-flex items-center whitespace-nowrap"><i class="fa-regular fa-user mr-2 text-slate-700"></i>Admin Akademik</span>
                    <span class="inline-flex items-center whitespace-nowrap"><i class="fa-regular fa-eye mr-2 text-slate-700"></i>{{ $post->views ?: 0 }} tayangan</span>
                </div>

                <div class="mt-6 overflow-hidden rounded-lg border-[3px] border-sky-500 bg-white shadow-sm">
                    <img src="{{ asset($post->thumbnail ?: 'images/foto.png') }}" alt="{{ $post->title }}" class="aspect-[16/8] w-full object-cover">
                </div>

                <div class="prose prose-slate mt-6 max-w-none text-sm leading-6 text-slate-600 sm:text-base sm:leading-7">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </div>
    </article>
@endsection
