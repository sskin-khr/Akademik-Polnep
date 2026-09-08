@extends('layouts.dashboard')

@section('title', 'Kelola Visi & Misi')

@section('content')
	<div class="min-h-screen bg-[#375766] p-4 sm:p-8">
		<div class="mx-auto max-w-4xl rounded-xl bg-white p-6 sm:p-8">
			<a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sky-700">&larr; Kembali ke dashboard</a>
			<h1 class="mt-5 font-outfit text-2xl font-extrabold text-slate-900">Konten Visi &amp; Misi</h1>
			<p class="mt-2 text-sm text-slate-500">Atur hero halaman, teks visi, dan teks misi.</p>

			@if (session('status'))
				<div class="mt-5 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
			@endif

			<form method="POST" action="{{ route('konten.visi-misi.update') }}" enctype="multipart/form-data" class="mt-7 space-y-6">
				@csrf

				<div class="rounded-lg border border-slate-200 p-5">
					<p class="mb-4 text-xs font-bold uppercase tracking-wider text-sky-700">Bagian atas halaman</p>
					<label class="text-sm font-semibold text-slate-700">Label kecil</label>
					<input name="visi_misi_hero_label" value="{{ $settings['visi_misi_hero_label'] ?? 'Profil Akademik' }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
					<label class="mt-4 block text-sm font-semibold text-slate-700">Judul utama</label>
					<input name="visi_misi_hero_title" value="{{ $settings['visi_misi_hero_title'] ?? 'Visi & Misi' }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
					<label class="mt-4 block text-sm font-semibold text-slate-700">Deskripsi hero</label>
					<textarea name="visi_misi_hero_description" rows="3" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $settings['visi_misi_hero_description'] ?? 'Arah langkah dan komitmen Politeknik Negeri Pontianak dalam menyelenggarakan pendidikan vokasi yang unggul dan berdaya saing.' }}</textarea>
					@if (!empty($settings['visi_misi_hero_image']))
						<img src="{{ asset($settings['visi_misi_hero_image']) }}" alt="Hero Visi dan Misi" class="mt-3 h-32 w-full rounded-lg object-cover">
					@endif
					<label class="mt-4 block text-sm font-semibold text-slate-700">Foto bagian atas</label>
					<input type="file" name="visi_misi_hero_image" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-lg border border-slate-300 p-2 text-sm">
				</div>

				<div class="rounded-lg border border-slate-200 p-5">
					<p class="mb-1 text-xs font-bold uppercase tracking-wider text-sky-700">Kartu Misi</p>
					<p class="mb-4 text-sm text-slate-500">Ubah judul dan deskripsi tiga misi yang tampil di halaman publik.</p>
					@php
						$defaultMisiCards = [
							['title' => 'Pendidikan Vokasi Berkualitas', 'text' => 'Menyelenggarakan pendidikan tinggi vokasi yang relevan dengan kebutuhan industri dan masyarakat.'],
							['title' => 'Penelitian & Inovasi Terapan', 'text' => 'Mengembangkan penelitian terapan dan teknologi guna memberi solusi nyata bagi masyarakat.'],
							['title' => 'Pengabdian Masyarakat', 'text' => 'Mewujudkan pengabdian melalui pengetahuan dan hasil teknologi yang meningkatkan kesejahteraan.'],
						];
						$misiCards = json_decode($settings['visi_misi_cards'] ?? '[]', true) ?: $defaultMisiCards;
					@endphp
					<div class="space-y-5">
						@foreach ($misiCards as $index => $card)
							<div class="rounded-lg bg-slate-50 p-4">
								<p class="mb-3 text-xs font-bold text-sky-600">Misi 0{{ $index + 1 }}</p>
								<label class="text-sm font-semibold text-slate-700">Judul</label>
								<input name="misi_cards[{{ $index }}][title]" value="{{ $card['title'] }}" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">
								<label class="mt-4 block text-sm font-semibold text-slate-700">Deskripsi</label>
								<textarea name="misi_cards[{{ $index }}][text]" rows="3" required class="mt-2 w-full rounded-lg border-slate-300 text-sm">{{ $card['text'] }}</textarea>
							</div>
						@endforeach
					</div>
				</div>

				@foreach ($items as $item)
					<div class="rounded-lg border border-slate-200 p-5">
						<p class="mb-4 text-xs font-bold uppercase tracking-wider text-sky-700">{{ $item->section_type }}</p>
						<input name="items[{{ $item->id }}][title]" value="{{ $item->title }}" required class="mb-3 w-full rounded-lg border-slate-300 text-sm">
						<textarea name="items[{{ $item->id }}][description]" rows="4" required class="w-full rounded-lg border-slate-300 text-sm">{{ $item->description }}</textarea>

						@if ($item->section_type === 'visi' && $item->image_url)
							<img src="{{ asset($item->image_url) }}" alt="{{ $item->title }}" class="mt-3 h-28 w-48 rounded-lg object-cover">
						@endif

						@if ($item->section_type === 'visi')
							<input type="file" name="items[{{ $item->id }}][image]" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full rounded-lg border border-slate-300 p-2 text-sm">
						@endif
					</div>
				@endforeach

				<button type="submit" class="rounded-lg bg-sky-600 px-5 py-3 text-sm font-bold text-white hover:bg-sky-700">Simpan perubahan</button>
			</form>
		</div>
	</div>
@endsection
