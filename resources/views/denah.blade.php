<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denah Interaktif - {{ data_get($home, 'school_profile.school_name', data_get($home, 'hero.school_name', 'SMK Negeri 2 Kota Mojokerto')) }}</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn2.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-smkn2.png') }}">
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f0f6fc] text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    @php
    $hero = data_get($home, 'hero');
    $profile = data_get($home, 'school_profile');
    $schoolName = data_get($profile, 'school_name', data_get($hero, 'school_name', 'SMK NEGERI 2 KOTA MOJOKERTO'));
    @endphp

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-40 bg-[#05529E] text-white shadow-md">
        <nav class="mx-auto flex w-full max-w-[1280px] items-center justify-between px-6 lg:px-8 py-3.5">
            {{-- Left: School Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center transition hover:opacity-90">
                <img src="{{ asset('smk2.png') }}" alt="{{ $schoolName }}" class="h-9 sm:h-10 w-auto max-w-[200px] sm:max-w-[260px] object-contain drop-shadow-md">
            </a>

            {{-- Center: Menu Navigation Links --}}
            <div class="hidden items-center gap-6 lg:gap-8 text-xs sm:text-[13px] font-bold tracking-widest text-white md:flex">
                <a href="{{ route('home') }}#beranda" class="transition hover:text-cyan-300 uppercase">HOME</a>
                <a href="{{ route('home') }}#profil" class="transition hover:text-cyan-300 uppercase">PROFIL</a>
                <a href="{{ route('home') }}#jurusan" class="transition hover:text-cyan-300 uppercase">JURUSAN</a>
                <a href="{{ route('denah') }}" class="text-cyan-300 uppercase font-black underline underline-offset-8 decoration-2">DENAH</a>
                <a href="{{ route('home') }}#informasi" class="transition hover:text-cyan-300 uppercase">INFORMASI</a>
                <a href="{{ route('home') }}#kesiswaan" class="transition hover:text-cyan-300 uppercase">KESISWAAN</a>
            </div>

            {{-- Right: Informasi PPDB Button --}}
            <a href="{{ route('home') }}#ppdb" class="group inline-flex items-center gap-2 rounded-full bg-[#a3e635] hover:bg-[#bef264] py-1.5 pl-4 pr-1.5 text-xs font-black text-slate-950 shadow-md transition-all hover:scale-105">
                <span>PPDB</span>
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-950 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                        <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </a>
        </nav>
    </header>

    {{-- ============ MAIN DENAH CONTENT ============ --}}
    <main class="flex-1">
        <x-denah-interaktif />
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-[#05529E] text-white pt-8 pb-6 border-t border-white/10 mt-12">
        <div class="mx-auto max-w-[1280px] px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <p class="text-white/90 text-center sm:text-left">
                &copy; {{ date('Y') }} SMK Negeri 2 Mojokerto. Hak Cipta Dilindungi.
            </p>
            <div class="flex items-center gap-6 text-white font-medium">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <a href="{{ route('denah') }}" class="hover:underline">Peta Denah</a>
                <a href="tel:0321387356" class="hover:underline">0321 387356</a>
            </div>
        </div>
    </footer>

    {{-- Chatbot SADA AI Widget --}}
    <x-chatbot :school-name="$schoolName" />
</body>

</html>
