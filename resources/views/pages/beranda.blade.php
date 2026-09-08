@extends('layouts.app')

@section('title', 'Beranda - Akademik POLNEP')

@section('content')

    <div class="relative h-[380px] sm:h-[480px] lg:h-[540px] w-full">
        <img src="{{ asset($heroImage) }}" alt="Gedung Utama POLNEP"
            class="w-full h-full object-cover opacity-80">
    </div>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-left max-w-2xl mx-0 mb-14 space-y-4">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 font-outfit tracking-tight">
                    {{ $heroTitle }}
                </h1>
                <p class="text-slate-600 text-base leading-8">
                    {{ $heroDescription }}
                </p>
            </div>

            <div>
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-12">
                    <div class="max-w-2xl">
                        <h2 class="text-lg font-bold text-slate-900 uppercase">
                            Pusat Informasi & Pengumuman
                        </h2>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                            Gunakan kata kunci untuk mencari draf surat edaran resmi dari Biro Akademik POLNEP.
                        </p>
                    </div>

                    <div class="w-full lg:w-auto lg:flex lg:justify-end">
                        <div class="relative w-full max-w-[320px]">
                            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" id="informasi-search" placeholder="Cari pengumuman akademik..."
                                class="w-full max-w-[320px] rounded-full border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-700 shadow-sm outline-none focus:border-sky-600 focus:ring-2 focus:ring-sky-100">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse ($informasiTerbaru as $info)
                        <div class="figma-card overflow-hidden flex flex-col justify-between">
                            <div>
                                <div class="h-48 overflow-hidden relative">
                                    <img src="{{ asset($info->thumbnail ?: 'images/foto.png') }}" alt="{{ $info->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    <span
                                        class="absolute top-3 left-3 bg-emerald-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                        {{ $info->category_name ?? 'Berita' }}
                                    </span>
                                </div>

                                <div class="p-6 space-y-3">
                                    <p class="text-xs text-slate-400 font-semibold">
                                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Illuminate\Support\Carbon::parse($info->published_at)->translatedFormat('d F Y') }}
                                    </p>
                                    <h3
                                        class="text-base font-bold text-slate-900 font-outfit line-clamp-2 hover:text-sky-600 transition-colors">
                                        {{ $info->title }}
                                    </h3>
                                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-3">
                                        {{ $info->excerpt }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="{{ route('berita.detail', $info->slug) }}"
                                    class="figma-btn-primary w-full py-3 px-4 text-sm flex items-center justify-center gap-2">
                                    <span>Lihat Detail</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full py-10 text-center text-slate-500">Belum ada berita yang dapat ditampilkan.</p>
                    @endforelse
                </div>
                <div class="mt-16 pb-4 flex justify-center">
                    <a href="{{ route('berita') }}"
                        class="figma-btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-semibold rounded-lg min-w-[220px]">
                        <span>Lihat Semua Berita</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
