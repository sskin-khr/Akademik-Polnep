<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_cards', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->string('published_label');
            $table->text('summary');
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('homepage_cards')->insert([
            ['category' => 'REGISTRASI', 'title' => 'Pelaksanaan Daftar Ulang & Pengisian KRS Semester Ganjil TA 2026/2027', 'published_label' => '25 Juli 2026', 'summary' => 'Diberitahukan kepada seluruh mahasiswa Politeknik Negeri Pontianak bahwa her-registrasi dan KRS online dibuka sampai 10 Agustus 2026.', 'image' => 'images/foto.png', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'INFO TERBARU', 'title' => 'POLNEP Luncurkan Gedung Laboratorium Terpadu Vokasi Berbasis Industry 4.0', 'published_label' => '20 Juli 2026', 'summary' => 'Peningkatan fasilitas riset terapan bagi mahasiswa vokasi guna memperkuat kompetensi siap kerja di era transformasi digital.', 'image' => 'images/foto 2.png', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'INFO TERBARU', 'title' => 'Prosedur & Persyaratan Pendaftaran Wisuda Ke-36 Politeknik Negeri Pontianak', 'published_label' => '15 Juli 2026', 'summary' => 'Pengumuman tahapan verifikasi berkas bebas pustaka dan pendaftaran wisudawan diploma III dan sarjana terapan.', 'image' => 'images/foto 3.png', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_cards');
    }
};