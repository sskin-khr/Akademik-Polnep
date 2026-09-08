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

        $selectedPostIds = json_decode($settings['featured_post_ids'] ?? '[]', true) ?: [];
        $postsQuery = DB::table('posts')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 'published')
            ->whereNotNull('posts.published_at')
            ->where('posts.published_at', '<=', now());

        if ($selectedPostIds) {
            $postsQuery->whereIn('posts.id', $selectedPostIds);
        }

        $informasiTerbaru = $postsQuery
            ->orderByDesc('posts.published_at')
            ->limit(3)
            ->get();

        return view('pages.beranda', compact('informasiTerbaru', 'heroTitle', 'heroDescription', 'heroImage'));
    }

    public function berita()
    {
        $posts = DB::table('posts')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.status', 'published')
            ->whereNotNull('posts.published_at')
            ->where('posts.published_at', '<=', now())
            ->orderByDesc('posts.published_at')
            ->get();

        return view('pages.berita', compact('posts'));
    }

    public function detailBerita(string $slug)
    {
        $post = DB::table('posts')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'published')
            ->whereNotNull('posts.published_at')
            ->where('posts.published_at', '<=', now())
            ->first();

        abort_unless($post, 404);

        return view('pages.berita-detail', compact('post'));
    }

    public function visiMisi()
    {
        $items = DB::table('visi_misi')->get()->keyBy('section_type');
        $settings = DB::table('site_settings')->pluck('value', 'key');
        $misiCards = json_decode($settings['visi_misi_cards'] ?? '[]', true) ?: [
            ['title' => 'Pendidikan Vokasi Berkualitas', 'text' => 'Menyelenggarakan pendidikan tinggi vokasi yang relevan dengan kebutuhan industri dan masyarakat.'],
            ['title' => 'Penelitian & Inovasi Terapan', 'text' => 'Mengembangkan penelitian terapan dan teknologi guna memberi solusi nyata bagi masyarakat.'],
            ['title' => 'Pengabdian Masyarakat', 'text' => 'Mewujudkan pengabdian melalui pengetahuan dan hasil teknologi yang meningkatkan kesejahteraan.'],
        ];

        return view('pages.visi-misi', [
            'visi' => $items->get('visi'),
            'misi' => $items->get('misi'),
            'settings' => $settings,
            'misiCards' => $misiCards,
        ]);
    }

    public function strukturOrganisasi()
    {
        $items = DB::table('struktur_organisasi')->orderBy('order_position')->get();

        return view('pages.struktur-organisasi', [
            'leaders' => $items->take(2),
            'members' => $items->skip(2),
        ]);
    }

    public function faq()
    {
        $faqs = DB::table('faq')->orderBy('order_position')->get();

        return view('pages.faq', compact('faqs'));
    }

    public function dokumen()
    {
        $documents = DB::table('documents')
            ->leftJoin('categories', 'categories.id', '=', 'documents.category_id')
            ->select('documents.*', 'categories.name as category_name')
            ->whereNotNull('documents.published_at')
            ->where('documents.published_at', '<=', now())
            ->orderByDesc('documents.published_at')
            ->get();

        return view('pages.dokumen', compact('documents'));
    }

    public function dashboard()
    {
        abort_unless(in_array(request()->user()->role, ['admin', 'penulis'], true), 403);

        if (request()->user()->role === 'penulis') {
            return redirect()->route('konten.berita');
        }

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
