@extends('layouts.dashboard')

@section('title', 'Kelola Beranda')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Kelola Beranda</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui hero beranda dan pilih berita yang ingin ditampilkan.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('konten.beranda.update') }}" enctype="multipart/form-data" class="mt-7 space-y-6">
                @csrf
                <div>
                    <h2 class="font-outfit text-lg font-bold text-slate-900">Perbarui konten beranda</h2>
                    <p class="mt-1 text-sm text-slate-500">Ubah title, deskripsi, foto, dan berita yang tampil di halaman utama.</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Title utama</label>
                    <input name="hero_title" value="{{ $settings['hero_title'] ?? 'AKADEMIK' }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Deskripsi utama</label>
                    <textarea name="hero_description" rows="4" class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $settings['hero_description'] ?? '' }}</textarea>
                </div>
                <div class="rounded-lg border border-slate-200 p-5">
                    <label class="text-sm font-semibold text-slate-700">Foto utama beranda</label>
                    @if (!empty($settings['hero_image']))
                        <img src="{{ asset($settings['hero_image']) }}" alt="Foto utama saat ini" class="mt-3 h-32 w-full rounded-lg object-cover">
                    @endif
                    <input type="file" name="hero_image" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full rounded-lg border border-slate-300 p-2 text-sm">
                </div>
                <div class="rounded-lg border border-slate-200 p-5">
                    <h2 class="font-outfit text-lg font-bold text-slate-900">Berita di beranda</h2>
                    <p class="mt-1 text-sm text-slate-500">Pilih berita terbit untuk ditampilkan. Jika tidak ada yang dipilih, tiga berita terbaru akan tampil otomatis.</p>
                    <div class="mt-5 grid gap-3">
                        @forelse ($posts as $post)
                            <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-4 hover:border-sky-400">
                                <input type="checkbox" name="featured_post_ids[]" value="{{ $post->id }}"
                                    @checked(in_array($post->id, json_decode($settings['featured_post_ids'] ?? '[]', true) ?: []))
                                    class="mt-1 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                <span>
                                    <span class="block text-sm font-semibold text-slate-800">{{ $post->title }}</span>
                                    <span class="mt-1 block text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}</span>
                                </span>
                            </label>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada berita terbit. Terbitkan berita terlebih dahulu melalui menu Kelola Berita.</p>
                        @endforelse
                    </div>
                </div>
                <div class="flex justify-end border-t border-slate-200 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg px-6 py-3 text-sm font-bold shadow-sm" style="background-color: #0284c7; color: #ffffff;">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan semua perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
