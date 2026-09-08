@extends('layouts.app')

@section('title', 'Berita - Akademik POLNEP')

@section('content')
    <section class="bg-[#f4f5f7] pb-20 pt-12 sm:pt-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="font-outfit text-3xl font-extrabold uppercase leading-tight text-sky-400 sm:text-5xl">Informasi Terkini</p>
                <h1 class="font-outfit text-3xl font-extrabold uppercase leading-tight text-slate-800 sm:text-5xl">Akademik</h1>
                <p class="mx-auto mt-5 max-w-2xl text-sm font-semibold uppercase leading-6 text-slate-600 sm:text-base">
                    Pantau selalu informasi terbaru mengenai tahun ajaran baru, semester antara, layanan akademik, dan agenda penting lainnya di Politeknik Negeri Pontianak.
                </p>
            </div>

            <div class="mt-9 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2" id="news-filters">
                    <button type="button" data-category="all" class="news-filter rounded-lg bg-sky-500 px-4 py-2 text-xs font-semibold text-white shadow-sm">Semua</button>
                    @foreach ($posts->pluck('category_name')->filter()->unique() as $category)
                        <button type="button" data-category="{{ \Illuminate\Support\Str::slug($category) }}" class="news-filter rounded-lg bg-white px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm ring-1 ring-slate-200 transition hover:bg-sky-50 hover:text-sky-700">{{ $category }}</button>
                    @endforeach
                </div>
                <label class="relative block w-full lg:max-w-[270px]">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                    <input id="news-search" type="search" placeholder="Cari pengumuman akademik..." class="w-full rounded-lg border-0 bg-white py-2.5 pl-9 pr-3 text-xs text-slate-700 shadow-sm ring-1 ring-slate-200 outline-none focus:ring-2 focus:ring-sky-300">
                </label>
            </div>

            <div id="news-grid" class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <article data-category="{{ \Illuminate\Support\Str::slug($post->category_name ?? 'berita') }}" data-search="{{ strtolower($post->title . ' ' . ($post->excerpt ?? '') . ' ' . ($post->category_name ?? '')) }}" class="news-card flex min-h-[430px] flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset($post->thumbnail ?: 'images/foto.png') }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                            <span class="absolute left-3 top-3 rounded bg-white/95 px-2.5 py-1 text-[10px] font-bold uppercase text-sky-700 shadow-sm">{{ $post->category_name ?? 'Berita' }}</span>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex items-center justify-between text-[10px] text-slate-400">
                                <span><i class="fa-regular fa-calendar mr-1"></i>{{ \Illuminate\Support\Carbon::parse($post->published_at)->translatedFormat('d M Y') }}</span>
                                <span>{{ $post->read_time ?: 3 }} min baca</span>
                            </div>
                            <h2 class="mt-3 line-clamp-2 font-outfit text-base font-bold leading-6 text-slate-800">{{ $post->title }}</h2>
                            <p class="mt-3 line-clamp-3 text-xs leading-5 text-slate-500">{{ $post->excerpt }}</p>
                            <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4 text-[10px] text-slate-400">
                                <span>Oleh: Admin Akademik</span>
                                <a href="{{ route('berita.detail', $post->slug) }}" class="font-bold text-sky-500 hover:text-sky-700">Detail <i class="fa-solid fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full py-10 text-center text-slate-500">Belum ada berita yang diterbitkan.</p>
                @endforelse
            </div>
            <p id="news-empty" class="hidden py-12 text-center text-sm text-slate-500">Tidak ada berita yang sesuai.</p>
        </div>
    </section>

    @push('scripts')
        <script>
            const filters = document.querySelectorAll('.news-filter');
            const cards = document.querySelectorAll('.news-card');
            const search = document.getElementById('news-search');
            const empty = document.getElementById('news-empty');
            let activeCategory = 'all';

            function filterNews() {
                const keyword = search.value.toLowerCase().trim();
                let visible = 0;
                cards.forEach((card) => {
                    const matchesCategory = activeCategory === 'all' || card.dataset.category === activeCategory;
                    const matchesSearch = card.dataset.search.includes(keyword);
                    card.classList.toggle('hidden', !(matchesCategory && matchesSearch));
                    if (matchesCategory && matchesSearch) visible++;
                });
                empty.classList.toggle('hidden', visible !== 0);
            }

            filters.forEach((filter) => filter.addEventListener('click', () => {
                activeCategory = filter.dataset.category;
                filters.forEach((item) => item.classList.replace('bg-sky-500', 'bg-white'));
                filters.forEach((item) => item.classList.replace('text-white', 'text-slate-500'));
                filter.classList.replace('bg-white', 'bg-sky-500');
                filter.classList.replace('text-slate-500', 'text-white');
                filterNews();
            }));
            search.addEventListener('input', filterNews);
        </script>
    @endpush
@endsection
