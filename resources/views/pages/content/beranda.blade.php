@extends('layouts.dashboard')

@section('title', 'Kelola Beranda')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Kelola Beranda</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui title, deskripsi, foto, atau tambahkan konten baru.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('konten.beranda.update') }}" enctype="multipart/form-data" class="mt-7 space-y-6">
                @csrf
                <div>
                    <h2 class="font-outfit text-lg font-bold text-slate-900">Perbarui konten beranda</h2>
                    <p class="mt-1 text-sm text-slate-500">Ubah title, deskripsi, dan foto yang sudah tampil.</p>
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
                <div class="space-y-4">
                    @foreach ($cards as $card)
                        <div class="rounded-lg border border-slate-200 p-5">
                            <label class="text-xs font-semibold text-slate-600">Kategori</label>
                            <input name="cards[{{ $card->id }}][category]" value="{{ $card->category }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                            <label class="mt-4 block text-xs font-semibold text-slate-600">Title</label>
                            <input name="cards[{{ $card->id }}][title]" value="{{ $card->title }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                            <label class="mt-4 block text-xs font-semibold text-slate-600">Deskripsi</label>
                            <textarea name="cards[{{ $card->id }}][summary]" rows="3" class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $card->summary }}</textarea>
                            <label class="mt-4 block text-xs font-semibold text-slate-600">Tanggal</label>
                            <input name="cards[{{ $card->id }}][published_label]" value="{{ $card->published_label }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                            @if ($card->image)
                                <img src="{{ asset($card->image) }}" alt="{{ $card->title }}" class="mt-3 h-28 w-48 rounded-lg object-cover">
                            @endif
                            <label class="mt-4 block text-xs font-semibold text-slate-600">Foto pengganti</label>
                            <input type="file" name="cards[{{ $card->id }}][image]" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-sm">
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end border-t border-slate-200 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg px-6 py-3 text-sm font-bold shadow-sm" style="background-color: #0284c7; color: #ffffff;">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan semua perubahan
                    </button>
                </div>
            </form>

            <div class="my-8 border-t border-slate-200"></div>

            <form method="POST" action="{{ route('konten.beranda.card.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <h2 class="font-outfit text-lg font-bold text-slate-900">Tambah konten baru</h2>
                    <p class="mt-1 text-sm text-slate-500">Konten baru akan menjadi kartu tambahan di halaman beranda.</p>
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Kategori</label>
                        <input name="category" required placeholder="INFO TERBARU" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Tanggal</label>
                        <input name="published_label" required placeholder="28 Agustus 2026" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Judul konten</label>
                        <input name="title" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Ringkasan</label>
                        <textarea name="summary" rows="3" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Foto konten</label>
                        <input type="file" name="image" required accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-sm">
                    </div>
                </div>
                <div class="flex justify-end border-t border-slate-200 pt-6">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg px-6 py-3 text-sm font-bold shadow-sm hover:opacity-90" style="background-color: #0284c7; color: #ffffff;">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Tambah konten baru
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
