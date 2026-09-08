@extends('layouts.dashboard')

@section('title', 'Kelola Dokumen Akademik')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Dokumen Akademik</h1>
            <p class="mt-2 text-sm text-slate-500">Edit dokumen yang tersedia atau tambahkan dokumen baru.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('konten.dokumen.update') }}" enctype="multipart/form-data" class="mt-7 space-y-5">
                @csrf
                @forelse ($items as $item)
                    <div class="rounded-lg border border-slate-200 p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-700">Dokumen {{ $loop->iteration }}</p>
                            <div class="flex items-center gap-3"><span class="rounded bg-slate-100 px-2 py-1 text-[10px] uppercase text-slate-500">{{ $item->file_type ?: 'pdf' }}</span><button type="submit" form="delete-document-{{ $item->id }}" class="text-xs font-semibold text-red-600 hover:text-red-800">Hapus</button></div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="text-sm font-semibold text-slate-700">Judul dokumen</label>
                                <input name="items[{{ $item->id }}][title]" value="{{ $item->title }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Kategori</label>
                                <select name="items[{{ $item->id }}][category_id]" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                                    <option value="">Tanpa kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($item->category_id == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Tanggal terbit</label>
                                <input type="date" name="items[{{ $item->id }}][published_at]" value="{{ $item->published_at ? \Illuminate\Support\Carbon::parse($item->published_at)->format('Y-m-d') : '' }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Ganti file</label>
                                <input type="file" name="items[{{ $item->id }}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs">
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Ganti thumbnail</label>
                                <input type="file" name="items[{{ $item->id }}][thumbnail]" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs">
                            </div>
                        </div>
                    </div>
                    <form id="delete-document-{{ $item->id }}" method="POST" action="{{ route('konten.dokumen.destroy', $item->id) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @empty
                    <p class="rounded-lg bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">Belum ada dokumen.</p>
                @endforelse
                @if ($items->isNotEmpty())
                    <div class="flex justify-end border-t border-slate-200 pt-5"><button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Simpan semua perubahan</button></div>
                @endif
            </form>

            <div class="my-8 border-t border-slate-200"></div>

            <form method="POST" action="{{ route('konten.dokumen.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div><h2 class="font-outfit text-lg font-bold text-slate-900">Tambah dokumen baru</h2><p class="mt-1 text-sm text-slate-500">Dokumen baru akan tampil pada halaman Dokumen Akademik.</p></div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2"><label class="text-sm font-semibold text-slate-700">Judul dokumen</label><input name="title" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
                    <div><label class="text-sm font-semibold text-slate-700">Kategori</label><select name="category_id" class="mt-2 w-full rounded-lg border-slate-300 text-sm"><option value="">Tanpa kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                    <div><label class="text-sm font-semibold text-slate-700">Tanggal terbit</label><input type="date" name="published_at" value="{{ now()->format('Y-m-d') }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
                    <div><label class="text-sm font-semibold text-slate-700">File dokumen</label><input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs"></div>
                    <div><label class="text-sm font-semibold text-slate-700">Thumbnail</label><input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs"></div>
                </div>
                <div class="flex justify-end border-t border-slate-200 pt-5"><button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Tambah dokumen</button></div>
            </form>
        </div>
    </div>
@endsection
