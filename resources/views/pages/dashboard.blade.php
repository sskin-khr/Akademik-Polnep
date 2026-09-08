@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto min-h-screen max-w-[1440px] p-2 sm:p-4">
        <div class="flex min-h-[calc(100vh-1rem)] overflow-hidden rounded-xl bg-white sm:min-h-[calc(100vh-2rem)]">
            <aside class="hidden w-[205px] shrink-0 flex-col p-5 sm:flex">
                <a href="{{ route('beranda') }}" class="mb-6 block px-1"><img src="{{ asset('images/logo_polnep.webp') }}" alt="Logo POLNEP" class="h-12 w-40 object-contain object-left"></a>
                <nav class="rounded-xl bg-[#f0f1f3] p-2 text-[12px] text-slate-700">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-4 rounded-lg bg-white px-3 py-3 font-semibold text-slate-900 shadow-sm"><i class="fa-solid fa-house w-4 text-center"></i> Beranda</a>
                    <a href="{{ route('beranda') }}#visimisi" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-white"><i class="fa-regular fa-bookmark w-4 text-center"></i> Visi &amp; Misi</a>
                    <a href="{{ route('beranda') }}#struktur" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-white"><i class="fa-regular fa-user w-4 text-center"></i> Struktur Organisasi</a>
                    <a href="{{ route('beranda') }}#berita" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-white"><i class="fa-regular fa-bookmark w-4 text-center"></i> Berita</a>
                    <div class="my-2 border-t border-slate-400"></div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-white"><i class="fa-solid fa-gear w-4 text-center"></i> Setting</a>
                    <a href="#help" class="flex items-center gap-4 rounded-lg px-3 py-3 hover:bg-white"><i class="fa-regular fa-circle-question w-4 text-center"></i> Help</a>
                </nav>
            </aside>

            <main class="min-w-0 flex-1 bg-[#375766] p-4 sm:p-5 lg:p-6">
                <div class="mb-4 flex items-center justify-between text-white"><div class="flex items-center gap-3"><button type="button" class="sm:hidden" aria-label="Buka menu"><i class="fa-solid fa-bars"></i></button><h1 class="font-outfit text-lg font-bold">Dashboard</h1></div><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="text-white/70 hover:text-white" title="Keluar"><i class="fa-solid fa-arrow-right-from-bracket"></i></button></form></div>

            <section class="overflow-hidden rounded-xl bg-white">
                <div class="bg-[#b5d1e1] px-5 py-3 text-xs font-bold text-slate-800">Memulai</div>
                <div class="grid grid-cols-1 gap-y-3 px-5 py-6 sm:grid-cols-2 sm:gap-x-5 sm:gap-y-4">
                    @foreach ([['Tambah Konten Beranda', 'Memperbaiki atau menambahkan konten di beranda', 'fa-house', 'konten.beranda'], ['Tambah Konten Visi & Misi', 'Memperbaiki atau menambahkan konten di halaman visi & misi', 'fa-book-open', 'konten.visi-misi'], ['Tambah Konten Struktur', 'Memperbaiki atau menambahkan konten di struktur organisasi', 'fa-sitemap', 'konten.struktur'], ['Tambah Konten Berita', 'Memperbaiki atau menambahkan konten di halaman berita', 'fa-newspaper', 'konten.berita'], ['Tambah Konten FAQ', 'Memperbaiki atau menambahkan pertanyaan FAQ', 'fa-circle-question', 'konten.faq'], ['Kelola Dokumen', 'Memperbaiki atau menambahkan dokumen akademik', 'fa-file-lines', 'konten.dokumen']] as $index => $action)
                        <a href="{{ route($action[3]) }}" class="group flex min-h-[40px] items-center gap-3 @if ($index % 2 === 1) border-slate-200 sm:border-l sm:pl-5 @endif"><i class="fa-solid fa-circle-plus shrink-0 text-sky-500"></i><span class="min-w-0"><strong class="block text-xs font-bold text-slate-900">{{ $action[0] }}</strong><small class="block text-[9px] leading-3 text-slate-600">{{ $action[1] }}</small></span></a>
                    @endforeach
                </div>
            </section>

            <section class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-lg bg-white px-3 py-3"><p class="text-[9px] font-semibold text-slate-500">{{ $stat['label'] }}</p><p class="mt-1 font-outfit text-xl font-extrabold text-slate-700">{{ number_format($stat['value']) }}</p><p class="text-[9px] text-sky-500">Info</p></div>
                @endforeach
            </section>

            <section class="mt-3 overflow-hidden rounded-xl bg-white"><div class="bg-[#b5d1e1] px-4 py-3 text-xs font-bold text-slate-800">Berita Utama</div><div class="overflow-x-auto"><table class="w-full min-w-[600px] text-left text-[10px] text-slate-700"><thead class="bg-[#f5f9fb] text-[9px] text-slate-500"><tr><th class="px-3 py-3 font-semibold">Title</th><th class="px-3 py-3 font-semibold">Kategori</th><th class="px-3 py-3 font-semibold">Status</th><th class="px-3 py-3 font-semibold">Diperbarui</th><th class="px-3 py-3 font-semibold">Aksi</th></tr></thead><tbody class="divide-y divide-slate-100">
                        @forelse ($postsTerbaru as $post)
                            <tr><td class="max-w-[230px] truncate px-3 py-3">{{ $post->title }}</td><td class="px-3 py-3">{{ $post->category_name ?? '-' }}</td><td class="px-3 py-3">{{ ucfirst($post->status) }}</td><td class="px-3 py-3">{{ \Carbon\Carbon::parse($post->updated_at)->format('d/m/Y') }}</td><td class="px-3 py-3 text-sky-600"><i class="fa-regular fa-eye"></i></td></tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-8 text-center text-slate-500">Belum ada berita.</td></tr>
                        @endforelse
                    </tbody></table></div></section>
            </main>
        </div>
    </div>
@endsection