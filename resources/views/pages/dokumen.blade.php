@extends('layouts.app')

@section('title', 'Dokumen Akademik - Akademik POLNEP')

@section('content')
    @php
        $thumbnail = static function ($document) {
            return $document->thumbnail && file_exists(public_path($document->thumbnail)) ? asset($document->thumbnail) : asset('images/foto.png');
        };
    @endphp

    <section class="bg-white pb-16 pt-12 sm:pb-20 sm:pt-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="font-outfit text-4xl font-extrabold uppercase leading-none text-sky-400 sm:text-5xl">Dokumen</h1>
                <h2 class="font-outfit text-4xl font-extrabold uppercase leading-none text-[#123f68] sm:text-5xl">Akademik</h2>
                <p class="mx-auto mt-6 max-w-3xl text-sm font-bold uppercase leading-6 text-slate-600 sm:text-base">
                    Akses, lihat, dan unduh dokumen akademik yang tersedia.
                </p>
            </div>

            <div class="mt-9 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-2" id="document-filters">
                    <button type="button" data-filter="all" class="document-filter rounded-lg bg-sky-500 px-4 py-2 text-xs font-semibold text-white shadow-sm">Semua</button>
                    <button type="button" data-filter="pdf" class="document-filter rounded-lg bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-500 transition hover:bg-sky-50 hover:text-sky-700">PDF</button>
                </div>
                <label class="relative block w-full sm:max-w-[270px]">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                    <input id="document-search" type="search" placeholder="Cari dokumen..." class="w-full rounded-lg border-0 bg-white py-2.5 pl-9 pr-3 text-xs text-slate-700 shadow-sm ring-1 ring-slate-200 outline-none focus:ring-2 focus:ring-sky-300">
                </label>
            </div>

            <div class="mt-3 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="document-grid">
                @forelse ($documents as $document)
                    <article data-type="{{ strtolower($document->file_type ?: 'pdf') }}" data-search="{{ strtolower($document->title . ' ' . ($document->category_name ?? '') . ' ' . ($document->file_type ?? '')) }}" class="document-card overflow-hidden rounded-xl border border-sky-400 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="h-44 overflow-hidden">
                            <img src="{{ $thumbnail($document) }}" alt="{{ $document->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 text-[10px] text-slate-400">
                                <span class="rounded bg-sky-50 px-2 py-1 font-bold uppercase text-sky-500">{{ $document->file_type ?: 'PDF' }}</span>
                                <span><i class="fa-regular fa-calendar mr-1"></i>{{ \Illuminate\Support\Carbon::parse($document->published_at)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3 pt-3">
                                <h2 class="line-clamp-2 text-xs font-semibold uppercase text-slate-500">{{ $document->title }}</h2>
                                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" rel="noopener" aria-label="Buka {{ $document->title }}" class="shrink-0 text-slate-600 hover:text-sky-600"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full py-10 text-center text-sm text-slate-500">Belum ada dokumen akademik.</p>
                @endforelse
            </div>
            <p id="document-empty" class="hidden py-12 text-center text-sm text-slate-500">Tidak ada dokumen yang sesuai.</p>
        </div>
    </section>

    @push('scripts')
        <script>
            const documentFilters = document.querySelectorAll('.document-filter');
            const documentCards = document.querySelectorAll('.document-card');
            const documentSearch = document.getElementById('document-search');
            const documentEmpty = document.getElementById('document-empty');
            let activeDocumentFilter = 'all';

            function filterDocuments() {
                const keyword = documentSearch.value.toLowerCase().trim();
                let visible = 0;
                documentCards.forEach((card) => {
                    const matchesType = activeDocumentFilter === 'all' || card.dataset.type === activeDocumentFilter;
                    const matchesSearch = card.dataset.search.includes(keyword);
                    card.classList.toggle('hidden', !(matchesType && matchesSearch));
                    if (matchesType && matchesSearch) visible++;
                });
                documentEmpty.classList.toggle('hidden', visible !== 0);
            }

            documentFilters.forEach((filter) => filter.addEventListener('click', () => {
                activeDocumentFilter = filter.dataset.filter;
                documentFilters.forEach((item) => {
                    item.classList.remove('bg-sky-500', 'text-white');
                    item.classList.add('bg-slate-100', 'text-slate-500');
                });
                filter.classList.remove('bg-slate-100', 'text-slate-500');
                filter.classList.add('bg-sky-500', 'text-white');
                filterDocuments();
            }));
            documentSearch.addEventListener('input', filterDocuments);
        </script>
    @endpush
@endsection
