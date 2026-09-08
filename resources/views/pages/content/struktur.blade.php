@extends('layouts.dashboard')

@section('title', 'Kelola Struktur Organisasi')

@section('content')
	<div class="min-h-screen bg-[#375766] p-4 sm:p-8">
		<div class="mx-auto max-w-5xl rounded-xl bg-white p-6 sm:p-8">
			<a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
			<h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Konten Struktur Organisasi</h1>
			<p class="mt-2 text-sm text-slate-500">Edit setiap box anggota atau tambahkan anggota baru.</p>

			@if (session('status'))
				<div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
			@endif

			<form method="POST" action="{{ route('konten.struktur.update') }}" enctype="multipart/form-data" class="mt-7 space-y-5">
				@csrf
				@foreach ($items as $item)
					<div class="rounded-lg border border-slate-200 p-5">
						<div class="mb-4 flex items-center justify-between">
							<p class="text-xs font-bold uppercase tracking-wider text-sky-700">Box {{ $loop->iteration }}</p>
							<div class="flex items-center gap-3">
								@if ($item->photo)
									<img src="{{ asset($item->photo) }}" alt="{{ $item->name }}" class="h-14 w-14 rounded-full object-cover">
								@endif
								<button type="submit" form="delete-structure-{{ $item->id }}" class="text-xs font-semibold text-red-600 hover:text-red-800">Hapus</button>
							</div>
						</div>
						<div class="grid gap-4 md:grid-cols-2">
							<div><label class="text-sm font-semibold text-slate-700">Nama</label><input name="items[{{ $item->id }}][name]" value="{{ $item->name }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
							<div><label class="text-sm font-semibold text-slate-700">Jabatan</label><input name="items[{{ $item->id }}][jabatan]" value="{{ $item->jabatan }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
							<div><label class="text-sm font-semibold text-slate-700">NIP</label><input name="items[{{ $item->id }}][nip]" value="{{ $item->nip }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
							<div>
								<label class="text-sm font-semibold text-slate-700">Posisi induk</label>
								<select name="items[{{ $item->id }}][parent_id]" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
									<option value="">Pimpinan utama</option>
									@foreach ($items as $parent)
										@if ($parent->id !== $item->id)
											<option value="{{ $parent->id }}" @selected($item->parent_id == $parent->id)>{{ $parent->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<div><label class="text-sm font-semibold text-slate-700">Urutan tampil</label><input type="number" name="items[{{ $item->id }}][order_position]" value="{{ $item->order_position }}" min="1" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
							<div><label class="text-sm font-semibold text-slate-700">Ganti foto</label><input type="file" name="items[{{ $item->id }}][photo]" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs"></div>
						</div>
					</div>
					<form id="delete-structure-{{ $item->id }}" method="POST" action="{{ route('konten.struktur.destroy', $item->id) }}" onsubmit="return confirm('Hapus anggota ini?')">
						@csrf
						@method('DELETE')
					</form>
				@endforeach
				<div class="flex justify-end border-t border-slate-200 pt-5"><button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Simpan semua perubahan</button></div>
			</form>

			<div class="my-8 border-t border-slate-200"></div>

			<form method="POST" action="{{ route('konten.struktur.store') }}" enctype="multipart/form-data" class="space-y-5">
				@csrf
				<div><h2 class="font-outfit text-lg font-bold text-slate-900">Tambah anggota baru</h2><p class="mt-1 text-sm text-slate-500">Anggota baru tampil sesuai posisi induk dan urutan yang dipilih.</p></div>
				<div class="grid gap-4 md:grid-cols-2">
					<div><label class="text-sm font-semibold text-slate-700">Nama</label><input name="name" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
					<div><label class="text-sm font-semibold text-slate-700">Jabatan</label><input name="jabatan" class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
					<div><label class="text-sm font-semibold text-slate-700">NIP</label><input name="nip" class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
					<div>
						<label class="text-sm font-semibold text-slate-700">Posisi induk</label>
						<select name="parent_id" class="mt-2 w-full rounded-lg border-slate-300 text-sm"><option value="">Pimpinan utama</option>@foreach ($items as $parent)<option value="{{ $parent->id }}">{{ $parent->name }}</option>@endforeach</select>
					</div>
					<div><label class="text-sm font-semibold text-slate-700">Urutan tampil</label><input type="number" name="order_position" value="{{ ($items->max('order_position') ?? 0) + 1 }}" min="1" required class="mt-2 w-full rounded-lg border-slate-300 text-sm"></div>
					<div><label class="text-sm font-semibold text-slate-700">Foto anggota</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-xs"></div>
				</div>
				<div class="flex justify-end border-t border-slate-200 pt-5"><button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Tambah anggota</button></div>
			</form>
		</div>
	</div>
@endsection
