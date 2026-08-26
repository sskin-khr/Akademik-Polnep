<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Akademik',
                'email' => 'admin@akademik.test',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Penulis Akademik',
                'email' => 'penulis@akademik.test',
                'password' => bcrypt('penulis123'),
                'role' => 'penulis',
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@akademik.test',
                'password' => bcrypt('mahasiswa123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $categoryIds = [];
        $categories = [
            ['name' => 'Berita', 'slug' => 'berita', 'type' => 'post'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'type' => 'post'],
            ['name' => 'Dokumen', 'slug' => 'dokumen', 'type' => 'document'],
            ['name' => 'Akademik', 'slug' => 'akademik', 'type' => 'post'],
        ];

        foreach ($categories as $category) {
            $id = DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'type' => $category['type'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $categoryIds[$category['slug']] = DB::table('categories')->where('slug', $category['slug'])->value('id');
        }

        $adminId = DB::table('users')->where('email', 'admin@akademik.test')->value('id');

        $posts = [
            [
                'category_id' => $categoryIds['berita'],
                'title' => 'Pendaftaran Semester Baru Mahasiswa Baru Telah Dibuka',
                'slug' => 'pendaftaran-semester-baru-mahasiswa-baru-telah-dibuka',
                'excerpt' => 'Pendaftaran semester baru mahasiswa baru telah dibuka untuk gelombang penerimaan 2026.',
                'content' => 'Seluruh calon mahasiswa baru dapat melakukan pendaftaran dan melengkapi data administrasi sesuai jadwal yang telah ditetapkan.',
                'thumbnail' => 'images/foto.png',
                'views' => 1200,
                'read_time' => 4,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'category_id' => $categoryIds['pengumuman'],
                'title' => 'Jadwal KRS dan Herregistrasi Semester Ganjil',
                'slug' => 'jadwal-krs-dan-herregistrasi-semester-ganjil',
                'excerpt' => 'Jadwal KRS dan herregistrasi disampaikan untuk mahasiswa semester ganjil.',
                'content' => 'Mahasiswa dimohon menyiapkan data akademik dan mengikuti jadwal yang telah ditentukan agar proses registrasi berjalan lancar.',
                'thumbnail' => 'images/foto 2.png',
                'views' => 987,
                'read_time' => 3,
                'status' => 'published',
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->updateOrInsert(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $documents = [
            [
                'category_id' => $categoryIds['dokumen'],
                'uploaded_by' => $adminId,
                'title' => 'Panduan Registrasi Mahasiswa Baru',
                'file_path' => 'documents/panduan-registrasi.pdf',
                'file_type' => 'pdf',
                'thumbnail' => 'images/foto 3.png',
                'published_at' => now(),
            ],
            [
                'category_id' => $categoryIds['akademik'],
                'uploaded_by' => $adminId,
                'title' => 'Format Surat Keterangan Aktif Kuliah',
                'file_path' => 'documents/surat-keterangan-aktif.pdf',
                'file_type' => 'pdf',
                'thumbnail' => 'images/foto.png',
                'published_at' => now(),
            ],
        ];

        foreach ($documents as $document) {
            DB::table('documents')->insertOrIgnore([
                'category_id' => $document['category_id'],
                'uploaded_by' => $document['uploaded_by'],
                'title' => $document['title'],
                'file_path' => $document['file_path'],
                'file_type' => $document['file_type'],
                'thumbnail' => $document['thumbnail'],
                'published_at' => $document['published_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $structure = [
            ['name' => 'Direktur', 'jabatan' => 'Direktur Politeknik', 'nip' => '196001012000011001', 'photo' => 'images/director.png', 'parent_id' => null, 'order_position' => 1],
            ['name' => 'Wakil Direktur I', 'jabatan' => 'Bidang Akademik', 'nip' => '196001012000011002', 'photo' => 'images/wadir1.png', 'parent_id' => 1, 'order_position' => 2],
            ['name' => 'Wakil Direktur II', 'jabatan' => 'Bidang Administrasi', 'nip' => '196001012000011003', 'photo' => 'images/wadir2.png', 'parent_id' => 1, 'order_position' => 3],
            ['name' => 'Kepala Biro Akademik', 'jabatan' => 'Koordinator Akademik', 'nip' => '196001012000011004', 'photo' => 'images/biro.png', 'parent_id' => 2, 'order_position' => 4],
        ];

        foreach ($structure as $index => $person) {
            DB::table('struktur_organisasi')->updateOrInsert(
                ['nip' => $person['nip']],
                [
                    'name' => $person['name'],
                    'jabatan' => $person['jabatan'],
                    'photo' => $person['photo'],
                    'parent_id' => $person['parent_id'],
                    'order_position' => $person['order_position'],
                ]
            );
        }

        $faqs = [
            ['question' => 'Bagaimana cara melakukan registrasi akademik?', 'answer' => 'Mahasiswa dapat melakukan registrasi melalui sistem akademik dengan login menggunakan akun yang telah diberikan.', 'order_position' => 1],
            ['question' => 'Bagaimana cara mengajukan surat keterangan aktif?', 'answer' => 'Surat keterangan aktif dapat diajukan melalui layanan administrasi akademik pada jam operasional.', 'order_position' => 2],
            ['question' => 'Kapan jadwal KRS dibuka?', 'answer' => 'Jadwal KRS biasanya dibuka sesuai kalender akademik yang telah ditetapkan oleh pihak kampus.', 'order_position' => 3],
        ];

        foreach ($faqs as $faq) {
            DB::table('faq')->updateOrInsert(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'order_position' => $faq['order_position'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $visiMisi = [
            [
                'section_type' => 'visi',
                'title' => 'Visi',
                'description' => 'Menjadi perguruan tinggi vokasi unggul yang menghasilkan lulusan kompeten, inovatif, dan siap bersaing di dunia kerja.',
                'image_url' => 'images/visi.png',
            ],
            [
                'section_type' => 'misi',
                'title' => 'Misi',
                'description' => 'Menyelenggarakan pendidikan vokasi berkualitas, mengembangkan penelitian terapan, serta mendorong pengabdian kepada masyarakat.',
                'image_url' => 'images/misi.png',
            ],
        ];

        foreach ($visiMisi as $item) {
            DB::table('visi_misi')->updateOrInsert(
                ['section_type' => $item['section_type']],
                [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'image_url' => $item['image_url'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
