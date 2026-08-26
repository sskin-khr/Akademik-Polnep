@extends('layouts.app')

@section('title', 'Beranda - Akademik POLNEP')

@section('content')

    <div class="relative h-[380px] sm:h-[480px] lg:h-[540px] w-full">
        <img src="{{ asset('images/gedung_polnep.png') }}" alt="Gedung Utama POLNEP"
            class="w-full h-full object-cover opacity-80">
    </div>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-left max-w-2xl mx-0 mb-14 space-y-4">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 font-outfit tracking-tight">
                    AKADEMIK
                </h1>
                <p class="text-slate-600 text-base leading-8">
                    Pantau selalu informasi terupdate dari Biro Akademik untuk mendapatkan informasi-informasi penting
                    mengenai akademik seperti tahun ajaran baru, semester antara, layanan akademik, atau informasi akademik
                    lainnya di Politeknik Negeri Pontianak.
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

                <div class="mt-16 flex flex-wrap items-center gap-3 mb-14" id="filter-buttons">
                    <button data-filter="semua"
                        class="filter-btn px-5 py-2 rounded-full bg-white text-slate-700 text-sm font-semibold border border-slate-200 shadow-sm transition hover:bg-sky-600 hover:text-white"
                        id="filter-semua">
                        Semua
                    </button>
                    <button data-filter="info terbaru"
                        class="filter-btn px-5 py-2 rounded-full bg-white text-slate-700 text-sm font-semibold border border-slate-200 shadow-sm transition hover:bg-sky-600 hover:text-white"
                        id="filter-info">
                        Info Terbaru
                    </button>
                    <button data-filter="registrasi"
                        class="filter-btn px-5 py-2 rounded-full bg-white text-slate-700 text-sm font-semibold border border-slate-200 shadow-sm transition hover:bg-sky-600 hover:text-white"
                        id="filter-registrasi">
                        Registrasi
                    </button>
                    <button data-filter="akademik"
                        class="filter-btn px-5 py-2 rounded-full bg-white text-slate-700 text-sm font-semibold border border-slate-200 shadow-sm transition hover:bg-sky-600 hover:text-white"
                        id="filter-akademik">
                        Akademik
                    </button>
                    <button data-filter="beasiswa"
                        class="filter-btn px-5 py-2 rounded-full bg-white text-slate-700 text-sm font-semibold border border-slate-200 shadow-sm transition hover:bg-sky-600 hover:text-white"
                        id="filter-beasiswa">
                        Beasiswa
                    </button>
                </div>

                <div id="no-results" class="hidden text-center text-slate-500 py-8 col-span-full">Tidak ada hasil untuk
                    filter ini.</div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($informasiTerbaru as $info)
                        <div class="figma-card overflow-hidden flex flex-col justify-between"
                            data-category="{{ \Illuminate\Support\Str::slug($info['kategori']) }}">
                            <div>
                                <div class="h-48 overflow-hidden relative">
                                    <img src="{{ asset($info['gambar']) }}" alt="{{ $info['judul'] }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    <span
                                        class="absolute top-3 left-3 bg-emerald-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                        {{ $info['kategori'] }}
                                    </span>
                                </div>

                                <div class="p-6 space-y-3">
                                    <p class="text-xs text-slate-400 font-semibold">
                                        <i class="fa-regular fa-calendar mr-1"></i> {{ $info['tanggal'] }}
                                    </p>
                                    <h3
                                        class="text-base font-bold text-slate-900 font-outfit line-clamp-2 hover:text-sky-600 transition-colors">
                                        {{ $info['judul'] }}
                                    </h3>
                                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-3">
                                        {{ $info['ringkasan'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="#"
                                    class="figma-btn-primary w-full py-3 px-4 text-sm flex items-center justify-center gap-2">
                                    <span>Lihat Detail</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-16 pb-4 flex justify-center">
                    <a href="/berita"
                        class="figma-btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-semibold rounded-lg min-w-[220px]">
                        <span>Lihat Semua Berita</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
