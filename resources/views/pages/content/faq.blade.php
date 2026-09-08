@extends('layouts.dashboard')

@section('title', 'Kelola FAQ')

@section('content')
    <div class="min-h-screen bg-[#375766] p-4 sm:p-8">
        <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
            <h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Konten FAQ</h1>
            <p class="mt-2 text-sm text-slate-500">Edit pertanyaan, jawaban, dan urutan tampil pada halaman FAQ.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('konten.faq.update') }}" class="mt-7 space-y-5">
                @csrf
                @forelse ($items as $item)
                    <div class="rounded-lg border border-slate-200 p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-700">FAQ {{ $loop->iteration }}</p>
                            <div class="flex items-center gap-3"><span class="rounded bg-slate-100 px-2 py-1 text-[10px] text-slate-500">ID {{ $item->id }}</span><button type="submit" form="delete-faq-{{ $item->id }}" class="text-xs font-semibold text-red-600 hover:text-red-800">Hapus</button></div>
                        </div>
                        <label class="text-sm font-semibold text-slate-700">Pertanyaan</label>
                        <input name="items[{{ $item->id }}][question]" value="{{ $item->question }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        <label class="mt-4 block text-sm font-semibold text-slate-700">Jawaban</label>
                        <textarea name="items[{{ $item->id }}][answer]" rows="4" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $item->answer }}</textarea>
                        <label class="mt-4 block text-sm font-semibold text-slate-700">Urutan tampil</label>
                        <input type="number" name="items[{{ $item->id }}][order_position]" value="{{ $item->order_position }}" min="1" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <form id="delete-faq-{{ $item->id }}" method="POST" action="{{ route('konten.faq.destroy', $item->id) }}" onsubmit="return confirm('Hapus FAQ ini?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @empty
                    <p class="rounded-lg bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">Belum ada FAQ.</p>
                @endforelse
                @if ($items->isNotEmpty())
                    <div class="flex justify-end border-t border-slate-200 pt-5">
                        <button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Simpan semua perubahan</button>
                    </div>
                @endif
            </form>

            <div class="my-8 border-t border-slate-200"></div>

            <form method="POST" action="{{ route('konten.faq.store') }}" class="space-y-5">
                @csrf
                <div>
                    <h2 class="font-outfit text-lg font-bold text-slate-900">Tambah FAQ baru</h2>
                    <p class="mt-1 text-sm text-slate-500">Pertanyaan baru akan langsung tersedia di halaman FAQ publik.</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Pertanyaan</label>
                    <input name="question" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Jawaban</label>
                    <textarea name="answer" rows="4" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Urutan tampil</label>
                    <input type="number" name="order_position" value="{{ ($items->max('order_position') ?? 0) + 1 }}" min="1" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div class="flex justify-end border-t border-slate-200 pt-5">
                    <button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Tambah FAQ</button>
                </div>
            </form>
        </div>
    </div>
@endsection
