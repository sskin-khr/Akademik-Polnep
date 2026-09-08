<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KontenController extends Controller
{
    private function authorizeEditor(): void
    {
        abort_unless(in_array(request()->user()->role, ['admin', 'penulis'], true), 403);
    }

    private function authorizeAdmin(): void
    {
        abort_unless(request()->user()->role === 'admin', 403);
    }

    public function beranda(): View
    {
        $this->authorizeAdmin();

        return view('pages.content.beranda', [
            'settings' => DB::table('site_settings')->pluck('value', 'key'),
            'posts' => DB::table('posts')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderByDesc('published_at')
                ->get(),
        ]);
    }

    public function updateBeranda(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:120'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'featured_post_ids' => ['nullable', 'array'],
            'featured_post_ids.*' => ['integer', 'exists:posts,id'],
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = 'storage/'.$request->file('hero_image')->store('uploads/beranda', 'public');
        }

        $data['featured_post_ids'] = json_encode(array_values($data['featured_post_ids'] ?? []));

        foreach ($data as $key => $value) {
            if ($value !== null) {
                DB::table('site_settings')->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now(), 'created_at' => now()]);
            }
        }

        return back()->with('status', 'Konten beranda berhasil diperbarui.');
    }

    public function visiMisi(): View
    {
        $this->authorizeAdmin();

        return view('pages.content.visi-misi', [
            'items' => DB::table('visi_misi')->orderBy('id')->get(),
            'settings' => DB::table('site_settings')->pluck('value', 'key'),
        ]);
    }

    public function updateVisiMisi(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'visi_misi_hero_label' => ['required', 'string', 'max:80'],
            'visi_misi_hero_title' => ['required', 'string', 'max:120'],
            'visi_misi_hero_description' => ['required', 'string', 'max:500'],
            'visi_misi_hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'misi_cards' => ['required', 'array', 'size:3'],
            'misi_cards.*.title' => ['required', 'string', 'max:120'],
            'misi_cards.*.text' => ['required', 'string', 'max:500'],
            'items' => ['required', 'array'],
            'items.*.title' => ['required', 'string', 'max:120'],
            'items.*.description' => ['required', 'string', 'max:1000'],
            'items.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('visi_misi_hero_image')) {
            $data['visi_misi_hero_image'] = 'storage/'.$request->file('visi_misi_hero_image')->store('uploads/visi-misi', 'public');
        }

        foreach (['visi_misi_hero_label', 'visi_misi_hero_title', 'visi_misi_hero_description', 'visi_misi_hero_image'] as $key) {
            if (isset($data[$key])) {
                DB::table('site_settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $data[$key], 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'visi_misi_cards'],
            ['value' => json_encode(array_values($data['misi_cards'])), 'updated_at' => now(), 'created_at' => now()]
        );

        foreach ($data['items'] as $id => $item) {
            unset($item['image']);
            $image = $request->file("items.$id.image");
            if ($image) {
                $item['image_url'] = 'storage/'.$image->store('uploads/visi-misi', 'public');
            }
            DB::table('visi_misi')->where('id', $id)->update($item + ['updated_at' => now()]);
        }

        return back()->with('status', 'Konten visi dan misi berhasil diperbarui.');
    }

    public function struktur(): View
    {
        $this->authorizeAdmin();

        return view('pages.content.struktur', ['items' => DB::table('struktur_organisasi')->orderBy('order_position')->get()]);
    }

    public function updateStruktur(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string', 'max:120'],
            'items.*.jabatan' => ['nullable', 'string', 'max:120'],
            'items.*.nip' => ['nullable', 'string', 'max:40'],
            'items.*.parent_id' => ['nullable', 'integer', 'exists:struktur_organisasi,id'],
            'items.*.order_position' => ['required', 'integer', 'min:1'],
            'items.*.photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        foreach ($data['items'] as $id => $item) {
            unset($item['photo']);
            $photo = $request->file("items.$id.photo");
            if ($photo) {
                $item['photo'] = 'storage/'.$photo->store('uploads/struktur', 'public');
            }
            DB::table('struktur_organisasi')->where('id', $id)->update($item);
        }

        return back()->with('status', 'Struktur organisasi berhasil diperbarui.');
    }

    public function storeStruktur(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'jabatan' => ['nullable', 'string', 'max:120'],
            'nip' => ['nullable', 'string', 'max:40'],
            'parent_id' => ['nullable', 'integer', 'exists:struktur_organisasi,id'],
            'order_position' => ['required', 'integer', 'min:1'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = 'storage/'.$request->file('photo')->store('uploads/struktur', 'public');
        }

        DB::table('struktur_organisasi')->insert($data);

        return back()->with('status', 'Anggota struktur berhasil ditambahkan.');
    }

    public function destroyStruktur(int $id): RedirectResponse
    {
        $this->authorizeAdmin();
        DB::table('struktur_organisasi')->where('id', $id)->delete();

        return back()->with('status', 'Anggota struktur berhasil dihapus.');
    }

    public function faq(): View
    {
        $this->authorizeAdmin();

        return view('pages.content.faq', [
            'items' => DB::table('faq')->orderBy('order_position')->get(),
        ]);
    }

    public function updateFaq(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.question' => ['required', 'string', 'max:500'],
            'items.*.answer' => ['required', 'string', 'max:2000'],
            'items.*.order_position' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($data['items'] as $id => $item) {
            DB::table('faq')->where('id', $id)->update($item + ['updated_at' => now()]);
        }

        return back()->with('status', 'FAQ berhasil diperbarui.');
    }

    public function storeFaq(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string', 'max:2000'],
            'order_position' => ['required', 'integer', 'min:1'],
        ]);
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('faq')->insert($data);

        return back()->with('status', 'FAQ baru berhasil ditambahkan.');
    }

    public function destroyFaq(int $id): RedirectResponse
    {
        $this->authorizeAdmin();
        DB::table('faq')->where('id', $id)->delete();

        return back()->with('status', 'FAQ berhasil dihapus.');
    }

    public function dokumen(): View
    {
        $this->authorizeAdmin();

        return view('pages.content.dokumen', [
            'items' => DB::table('documents')->orderByDesc('published_at')->get(),
            'categories' => DB::table('categories')->where('type', 'document')->orderBy('name')->get(),
        ]);
    }

    public function updateDokumen(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.title' => ['required', 'string', 'max:180'],
            'items.*.category_id' => ['nullable', 'exists:categories,id'],
            'items.*.published_at' => ['nullable', 'date'],
            'items.*.file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'items.*.thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        foreach ($data['items'] as $id => $item) {
            unset($item['file'], $item['thumbnail']);
            $file = $request->file("items.$id.file");
            $thumbnail = $request->file("items.$id.thumbnail");
            if ($file) {
                $item['file_path'] = $file->store('documents', 'public');
                $item['file_type'] = $file->extension();
            }
            if ($thumbnail) {
                $item['thumbnail'] = 'storage/'.$thumbnail->store('uploads/documents', 'public');
            }
            DB::table('documents')->where('id', $id)->update($item + ['updated_at' => now()]);
        }

        return back()->with('status', 'Dokumen berhasil diperbarui.');
    }

    public function storeDokumen(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $file = $request->file('file');
        $data['file_path'] = $file->store('documents', 'public');
        $data['file_type'] = $file->extension();
        $data['thumbnail'] = $request->hasFile('thumbnail')
            ? 'storage/'.$request->file('thumbnail')->store('uploads/documents', 'public')
            : null;
        $data['uploaded_by'] = request()->user()->id;
        $data['published_at'] = $data['published_at'] ?? now();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        unset($data['file']);
        DB::table('documents')->insert($data);

        return back()->with('status', 'Dokumen baru berhasil ditambahkan.');
    }

    public function destroyDokumen(int $id): RedirectResponse
    {
        $this->authorizeAdmin();
        DB::table('documents')->where('id', $id)->delete();

        return back()->with('status', 'Dokumen berhasil dihapus.');
    }

    public function berita(): View
    {
        $this->authorizeEditor();

        return view('pages.content.berita', [
            'posts' => DB::table('posts')->latest()->get(),
            'categories' => DB::table('categories')->where('type', 'post')->get(),
        ]);
    }

    public function editBerita(int $id): View
    {
        $this->authorizeEditor();

        return view('pages.content.berita-edit', [
            'post' => DB::table('posts')->where('id', $id)->firstOrFail(),
            'categories' => DB::table('categories')->where('type', 'post')->get(),
        ]);
    }

    public function updateExistingBerita(Request $request, int $id): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = 'storage/'.$request->file('thumbnail')->store('uploads/berita', 'public');
        }
        $data['slug'] = str()->slug($data['title']).'-'.str()->random(5);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        $data['updated_at'] = now();
        DB::table('posts')->where('id', $id)->update($data);

        return redirect()->route('konten.berita')->with('status', 'Berita berhasil diperbarui.');
    }

    public function updateBerita(Request $request): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = 'storage/'.$request->file('thumbnail')->store('uploads/berita', 'public');
        }
        $data['slug'] = str()->slug($data['title']).'-'.str()->random(5);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('posts')->insert($data);

        return back()->with('status', 'Berita berhasil ditambahkan.');
    }

    public function destroyBerita(int $id): RedirectResponse
    {
        $this->authorizeEditor();
        DB::table('posts')->where('id', $id)->delete();

        return back()->with('status', 'Berita berhasil dihapus.');
    }
}