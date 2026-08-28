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

    public function beranda(): View
    {
        $this->authorizeEditor();

        return view('pages.content.beranda', [
            'settings' => DB::table('site_settings')->pluck('value', 'key'),
            'cards' => DB::table('homepage_cards')->orderBy('sort_order')->get(),
        ]);
    }

    public function updateBeranda(Request $request): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'hero_title' => ['nullable', 'string', 'max:120'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cards' => ['nullable', 'array'],
            'cards.*.category' => ['nullable', 'string', 'max:50'],
            'cards.*.title' => ['nullable', 'string', 'max:180'],
            'cards.*.published_label' => ['nullable', 'string', 'max:50'],
            'cards.*.summary' => ['nullable', 'string', 'max:1000'],
            'cards.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = 'storage/'.$request->file('hero_image')->store('uploads/beranda', 'public');
        }

        foreach (array_diff_key($data, ['cards' => true]) as $key => $value) {
            if ($value !== null) {
                DB::table('site_settings')->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now(), 'created_at' => now()]);
            }
        }

        foreach ($data['cards'] ?? [] as $id => $card) {
            $cardData = array_filter($card, fn ($value, $key) => $key !== 'image' && $value !== null, ARRAY_FILTER_USE_BOTH);
            $image = $request->file("cards.$id.image");
            if ($image) {
                $cardData['image'] = 'storage/'.$image->store('uploads/beranda-cards', 'public');
            }
            DB::table('homepage_cards')->where('id', $id)->update($cardData + ['updated_at' => now()]);
        }

        return back()->with('status', 'Konten beranda berhasil diperbarui.');
    }

    public function storeBerandaCard(Request $request): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'category' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:180'],
            'published_label' => ['required', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        $data['image'] = 'storage/'.$request->file('image')->store('uploads/beranda-cards', 'public');
        $data['sort_order'] = ((int) DB::table('homepage_cards')->max('sort_order')) + 1;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('homepage_cards')->insert($data);

        return back()->with('status', 'Konten baru berhasil ditambahkan ke beranda.');
    }

    public function visiMisi(): View
    {
        $this->authorizeEditor();

        return view('pages.content.visi-misi', ['items' => DB::table('visi_misi')->orderBy('id')->get()]);
    }

    public function updateVisiMisi(Request $request): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.title' => ['required', 'string', 'max:120'],
            'items.*.description' => ['required', 'string', 'max:1000'],
            'items.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

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
        $this->authorizeEditor();

        return view('pages.content.struktur', ['items' => DB::table('struktur_organisasi')->orderBy('order_position')->get()]);
    }

    public function updateStruktur(Request $request): RedirectResponse
    {
        $this->authorizeEditor();
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string', 'max:120'],
            'items.*.jabatan' => ['nullable', 'string', 'max:120'],
            'items.*.nip' => ['nullable', 'string', 'max:40'],
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

    public function berita(): View
    {
        $this->authorizeEditor();

        return view('pages.content.berita', [
            'posts' => DB::table('posts')->latest()->get(),
            'categories' => DB::table('categories')->where('type', 'post')->get(),
        ]);
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
}