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
                <div x-data="{ open: false, timer: null }" 
                     @mouseenter="clearTimeout(timer); open = true" 
                     @mouseleave="timer = setTimeout(() => { open = false }, 200)" 
                     class="relative flex items-center py-3 select-none">
                    <button type="button" 
                            @click="open = !open" 
                            class="flex items-center gap-1.5 uppercase font-bold tracking-widest text-cyan-300 hover:text-white transition cursor-pointer focus:outline-none">
                        <span>INFORMASI</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition duration-200 pointer-events-none" :class="{ 'rotate-180': open }">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Dropdown Menu Container --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         @click.outside="open = false"
                         x-cloak
                         class="absolute left-1/2 -translate-x-1/2 top-full pt-1.5 min-w-[210px] z-50">
                        <div class="rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-slate-900/10 text-slate-800 tracking-normal normal-case font-medium">
                            <a href="{{ route('home') }}#informasi" @click="open = false" class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Berita & Informasi</span>
                            </a>
                            <a href="{{ route('denah') }}" @click="open = false" class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold bg-sky-50 text-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>Denah Interaktif</span>
                            </a>
                        </div>
                    </div>
                </div>
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
