<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        $settings = DB::table('site_settings')->pluck('value', 'key');
        $heroTitle = $settings['hero_title'] ?? 'AKADEMIK';
        $heroDescription = $settings['hero_description'] ?? 'Pantau selalu informasi terupdate dari Biro Akademik untuk mendapatkan informasi-informasi penting mengenai akademik seperti tahun ajaran baru, semester antara, layanan akademik, atau informasi akademik lainnya di Politeknik Negeri Pontianak.';
        $heroImage = $settings['hero_image'] ?? 'images/gedung_polnep.png';

        $informasiTerbaru = DB::table('homepage_cards')->orderBy('sort_order')->get()->map(fn ($card) => [
            'id' => $card->id,
            'judul' => $card->title,
            'kategori' => $card->category,
            'tanggal' => $card->published_label,
            'ringkasan' => $card->summary,
            'gambar' => $card->image,
        ])->all();

        return view('pages.beranda', compact('informasiTerbaru', 'heroTitle', 'heroDescription', 'heroImage'));
    }

    public function dashboard()
    {
        abort_unless(in_array(request()->user()->role, ['admin', 'penulis'], true), 403);

        $stats = [
            [
                'label' => 'Total Konten',
                'value' => DB::table('posts')->count(),
                'icon' => 'fa-newspaper',
                'tone' => 'blue',
            ],
            [
                'label' => 'Terbit',
                'value' => DB::table('posts')->where('status', 'published')->count(),
                'icon' => 'fa-circle-check',
                'tone' => 'green',
            ],
            [
                'label' => 'Dokumen',
                'value' => DB::table('documents')->count(),
                'icon' => 'fa-folder-open',
                'tone' => 'amber',
            ],
            [
                'label' => 'Pengguna',
                'value' => DB::table('users')->count(),
                'icon' => 'fa-users',
                'tone' => 'violet',
            ],
        ];

        $postsTerbaru = DB::table('posts')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.title', 'posts.status', 'posts.updated_at', 'categories.name as category_name')
            ->latest('posts.updated_at')
            ->limit(5)
            ->get();

        return view('pages.dashboard', [
            'stats' => $stats,
            'postsTerbaru' => $postsTerbaru,
            'user' => request()->user(),
        ]);
    }
}
