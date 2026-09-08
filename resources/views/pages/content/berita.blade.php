@extends('layouts.dashboard')

@section('title', 'Kelola Berita')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Konten Berita</h1>
            <p class="mt-2 text-sm text-slate-500">Tambahkan berita baru atau hapus berita yang sudah tidak diperlukan.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <div class="mt-7 space-y-3">
                @forelse ($posts as $post)
                    <div class="flex items-center justify-between gap-4 rounded-lg border border-slate-200 p-4">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-800">{{ $post->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ ucfirst($post->status) }} &middot; {{ $post->created_at ? \Illuminate\Support\Carbon::parse($post->created_at)->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-4">
                            <a href="{{ route('konten.berita.edit', $post->id) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800">Edit</a>
                            <form method="POST" action="{{ route('konten.berita.destroy', $post->id) }}" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="rounded-lg bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">Belum ada berita.</p>
                @endforelse
            </div>

            <div class="my-8 border-t border-slate-200"></div>

            <form method="POST" action="{{ route('konten.berita.update') }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2"><label class="text-sm font-semibold text-slate-700">Judul berita</label><input name="title" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
                <div><label class="text-sm font-semibold text-slate-700">Kategori</label><select name="category_id" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">@foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                <div><label class="text-sm font-semibold text-slate-700">Status</label><select name="status" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"><option value="draft">Draf</option><option value="published">Terbit</option></select></div>
                <div class="md:col-span-2"><label class="text-sm font-semibold text-slate-700">Foto thumbnail</label><input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-sm"></div>
                <div class="md:col-span-2"><label class="text-sm font-semibold text-slate-700">Ringkasan</label><textarea name="excerpt" rows="3" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></textarea></div>
                <div class="md:col-span-2"><label class="text-sm font-semibold text-slate-700">Isi berita</label><textarea name="content" rows="7" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></textarea></div>
                <div class="md:col-span-2 flex justify-end border-t border-slate-200 pt-5"><button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Tambah berita</button></div>
            </form>
        </div>
    </div>
@endsection
