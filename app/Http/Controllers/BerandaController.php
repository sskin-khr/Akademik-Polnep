<?php

namespace App\Http\Controllers;

class BerandaController extends Controller
{
    public function index()
    {
        $informasiTerbaru = [
            [
                'id' => 1,
                'judul' => 'Pelaksanaan Daftar Ulang & Pengisian KRS Semester Ganjil TA 2026/2027',
                'kategori' => 'REGISTRASI',
                'tanggal' => '25 Juli 2026',
                'ringkasan' => 'Diberitahukan kepada seluruh mahasiswa Politeknik Negeri Pontianak bahwa her-registrasi dan KRS online dibuka sampai 10 Agustus 2026.',
                'gambar' => 'images/foto.png',
            ],
            [
                'id' => 2,
                'judul' => 'POLNEP Luncurkan Gedung Laboratorium Terpadu Vokasi Berbasis Industry 4.0',
                'kategori' => 'INFO TERBARU',
                'tanggal' => '20 Juli 2026',
                'ringkasan' => 'Peningkatan fasilitas riset terapan bagi mahasiswa vokasi guna memperkuat kompetensi siap kerja di era transformasi digital.',
                'gambar' => 'images/foto 2.png',
            ],
            [
                'id' => 3,
                'judul' => 'Prosedur & Persyaratan Pendaftaran Wisuda Ke-36 Politeknik Negeri Pontianak',
                'kategori' => 'INFO TERBARU',
                'tanggal' => '15 Juli 2026',
                'ringkasan' => 'Pengumuman tahapan verifikasi berkas bebas pustaka dan pendaftaran wisudawan diploma III dan sarjana terapan.',
                'gambar' => 'images/foto 3.png',
            ],
        ];

        return view('pages.beranda', compact('informasiTerbaru'));
    }
}
