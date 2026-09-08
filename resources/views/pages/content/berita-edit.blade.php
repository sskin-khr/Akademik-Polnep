@extends('layouts.dashboard')

@section('title', 'Edit Berita')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('konten.berita') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke berita</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Edit Berita</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui isi berita yang dipilih.</p>

            <form method="POST" action="{{ route('konten.berita.existing.update', $post->id) }}" enctype="multipart/form-data" class="mt-7 grid gap-5 md:grid-cols-2">
                @csrf
                @method('PUT')
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700">Judul berita</label>
                    <input name="title" value="{{ $post->title }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Kategori</label>
                    <select name="category_id" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($post->category_id == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Status</label>
                    <select name="status" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        <option value="draft" @selected($post->status === 'draft')>Draf</option>
                        <option value="published" @selected($post->status === 'published')>Terbit</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700">Foto thumbnail</label>
                    @if ($post->thumbnail)
                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="mt-3 h-32 w-56 rounded-lg object-cover">
                    @endif
                    <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full rounded-lg border border-slate-300 p-2 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700">Ringkasan</label>
                    <textarea name="excerpt" rows="3" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $post->excerpt }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700">Isi berita</label>
                    <textarea name="content" rows="9" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $post->content }}</textarea>
                </div>
                <div class="md:col-span-2 flex justify-end border-t border-slate-200 pt-5">
                    <button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
