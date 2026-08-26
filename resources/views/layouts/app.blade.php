<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bagian Akademik - Politeknik Negeri Pontianak')</title>

    <meta name="description"
        content="Website Resmi Bagian Akademik Politeknik Negeri Pontianak (POLNEP). Information, Services, Announcements, and Academic Calendar.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between" style="background-color: #ffffff !important;">
    <header class="sticky top-0 z-50 figma-navbar" style="background-color: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18 md:h-20 py-3">
                <a href="{{ route('beranda') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_polnep.webp') }}" alt="Logo POLNEP"
                        class="w-16 h-7 sm:w-20 sm:h-8 object-contain">
                </a>

                <div class="flex items-center gap-2">
                    <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold">
                        <a href="{{ route('beranda') }}"
                            class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                            Beranda
                        </a>
                        <div class="relative profile-dropdown">
                            <button class="flex items-center gap-1 px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors"
                                type="button" id="profile-dropdown-toggle" aria-expanded="false" aria-controls="profile-dropdown-menu">
                                <span>Profil</span>
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </button>
                            <ul id="profile-dropdown-menu"
                                class="absolute left-0 top-full mt-2 hidden min-w-[220px] rounded-xl border border-slate-200 bg-white p-2 shadow-xl z-50">
                                <li>
                                    <a href="#visimisi" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                                        Visi dan Misi
                                    </a>
                                </li>
                                <li>
                                    <a href="#struktur" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                                        Struktur Organisasi
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="/berita"
                            class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                            Berita
                        </a>
                        <a href="/faq"
                            class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                            FAQ
                        </a>
                        <a href="/link"
                            class="px-4 py-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-colors">
                            Link
                        </a>
                    </nav>

                    @auth
                        <div class="relative account-dropdown hidden lg:block">
                            <button id="account-dropdown-toggle" type="button"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 text-left text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors"
                                aria-expanded="false" aria-controls="account-dropdown-menu">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-100 text-sm font-bold text-sky-700">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="max-w-[120px] truncate text-sm font-semibold">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="account-dropdown-menu"
                                class="absolute right-0 top-full mt-2 hidden min-w-[220px] rounded-xl border border-slate-200 bg-white p-2 shadow-xl z-50">
                                <div class="border-b border-slate-100 px-3 py-2">
                                    <p class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                    class="mt-1 block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-700">
                                    <i class="fa-regular fa-user mr-2 w-4"></i> Profil Saya
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-red-600 hover:bg-red-50">
                                        <i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <button id="mobile-menu-btn" type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 lg:hidden"
                        aria-label="Buka menu navigasi">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu"
                class="hidden lg:hidden mb-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-lg">
                <div class="flex flex-col gap-2 text-sm font-semibold">
                    <a href="{{ route('beranda') }}"
                        class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                        Beranda
                    </a>

                    <div class="profile-mobile-menu">
                        <button type="button" class="profile-mobile-toggle flex w-full items-center justify-between rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors"
                            aria-expanded="false">
                            <span>Profil</span>
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div class="profile-mobile-panel hidden mt-2 space-y-1 rounded-xl border border-slate-200 bg-slate-50 p-2">
                            <a href="#visimisi" class="block rounded-lg px-3 py-2 text-slate-700 hover:bg-white hover:text-sky-700 transition-colors">
                                Visi dan Misi
                            </a>
                            <a href="#struktur" class="block rounded-lg px-3 py-2 text-slate-700 hover:bg-white hover:text-sky-700 transition-colors">
                                Struktur Organisasi
                            </a>
                        </div>
                    </div>

                    <a href="/berita"
                        class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                        Berita
                    </a>
                    <a href="/faq"
                        class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                        FAQ
                    </a>
                    <a href="/link"
                        class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition-colors">
                        Link
                    </a>

                    @auth
                        <div class="mt-2 border-t border-slate-200 pt-3">
                            <div class="px-3 pb-2">
                                <p class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-700">
                                <i class="fa-regular fa-user mr-2 w-4"></i> Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow" style="background-color: #ffffff;">
        @yield('content')
    </main>

    <footer id="kontak" class="figma-footer pt-10 sm:pt-16 pb-10 text-white border-t border-sky-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-20 pb-10 sm:pb-12 border-b border-sky-400/40">
                <div class="space-y-4">
                    <img src="{{ asset('images/logo_polnep.webp') }}" alt="Logo POLNEP" class="w-20 h-8 object-contain">
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
                        <li><a href="{{ route('beranda') }}" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="#visimisi" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Visi dan Misi</a></li>
                        <li><a href="#struktur" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Struktur Organisasi</a></li>
                        <li><a href="#berita" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Berita</a></li>
                        <li><a href="#faq" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> FAQs</a></li>
                        <li><a href="#link" class="hover:text-white hover:underline flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Link Dokumen</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-sky-100 gap-4 text-center md:text-left">
                <p>&copy; {{ date('Y') }} Akademik - Politeknik Negeri Pontianak. All Rights Reserved.</p>
                <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-white font-semibold">
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Syarat Layanan</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
