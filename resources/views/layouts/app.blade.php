<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bagian Akademik - Politeknik Negeri Pontianak')</title>

    <!-- Meta Description -->
    <meta name="description"
        content="Website Resmi Bagian Akademik Politeknik Negeri Pontianak (POLNEP). Information, Services, Announcements, and Academic Calendar.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <header class="sticky top-0 z-50 figma-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <a href="{{ route('beranda') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_polnep.webp') }}" alt="Logo POLNEP"
                        class="w-20 h-8 object-contain">
                </a>

                <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold">
                    <a href="{{ route('beranda') }}"
                        class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                        Beranda
                    </a>
                    <a href="/"
                        class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                        Profil
                    </a>
                    <a href="/"
                        class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                        Berita
                    </a>
                    <a href="/"
                        class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                        FAQ
                    </a>
                    <a href="/"
                        class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                        Link
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer id="kontak" class="figma-footer pt-16 pb-10 text-white border-t border-sky-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-20 pb-12 border-b border-sky-400/40">
                <div class="space-y-4">
                    <img src="{{ asset('images/logo_polnep.webp') }}" alt="Logo POLNEP"
                        class="w-20 h-8 object-contain">
                    <p class="text-sm text-sky-100 leading-relaxed">
                        Politeknik Negeri Pontianak merupakan Kampus Merdeka Vokasi (KMV)
                        yang berupaya agar proses pembelajaran pada pendidikan tinggi vokasi
                        dapat lebih "merdeka" untuk dapat menghasilkan lulusan yang sesuai
                        dengan kebutuhan industri.
                    </p>
                </div>

                <div class="px-4 md:px-10 lg:px-16">
                    <h5 class="text-white font-extrabold text-base mb-4 font-outfit uppercase tracking-wider">
                        Kontak Kami
                    </h5>
                    <ul class="space-y-3 text-sm text-sky-100">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-[12px] mt-1"></i>
                            <span>Jl. Ahmad Yani, Pontianak, Kalimantan Barat</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-[12px]"></i>
                            <span>(0561) 736180</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[12px]"></i>
                            <span>info@polnep.ac.id</span>
                        </li>
                        <li class="flex items-center gap-3 pt-2">
                            <a href="#" class="hover:text-white"><i class="fa-brands fa-instagram text-lg"></i></a>
                            <a href="#" class="hover:text-white"><i class="fa-brands fa-facebook text-lg"></i></a>
                            <a href="#" class="hover:text-white"><i class="fa-brands fa-youtube text-lg"></i></a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="text-white font-extrabold text-base mb-4 font-outfit uppercase tracking-wider">
                        Navigasi Utama
                    </h5>
                    <ul class="space-y-2 text-sm text-sky-100">
                        <li><a href="{{ route('beranda') }}"
                                class="hover:text-white hover:underline flex items-center gap-2"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="#profil" class="hover:text-white hover:underline flex items-center gap-2"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i> Profil & Sambutan</a></li>
                        <li><a href="#layanan" class="hover:text-white hover:underline flex items-center gap-2"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i> Layanan Digital</a></li>
                        <li><a href="#informasi" class="hover:text-white hover:underline flex items-center gap-2"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i> Informasi Terbaru</a></li>
                        <li><a href="#prodi" class="hover:text-white hover:underline flex items-center gap-2"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i> Program Studi</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-sky-100 gap-4">
                <p>&copy; {{ date('Y') }} Akademik - Politeknik Negeri Pontianak. All Rights Reserved.</p>
                <div class="flex items-center gap-6 text-white font-semibold">
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Syarat Layanan</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
