<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ data_get($home, 'school_profile.school_name', data_get($home, 'hero.school_name', config('app.name'))) }}</title>
    
    {{-- Favicon Logo Resmi SMKN 2 Kota Mojokerto --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn2.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-smkn2.png') }}">
    
    {{-- Alpine.js for Dynamic Interactive Floorplan Map & Components --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    @php
    $hero = data_get($home, 'hero');
    $profile = data_get($home, 'school_profile');
    $statistics = data_get($home, 'statistics', []);
    $galleries = collect(data_get($home, 'galleries', []));
    $schoolName = data_get($profile, 'school_name', data_get($hero, 'school_name', 'SMK NEGERI 2 KOTA MOJOKERTO'));
    $imageUrl = fn ($path) => $path && filter_var($path, FILTER_VALIDATE_URL) ? $path : ($path ? Storage::url($path) : null);
    $logoUrl = asset('smk2.png');

    // Statis (belum ada kolom-nya di database, ganti manual atau tambahkan field baru kalau mau dinamis)
    $tagline = 'DISIPLIN • BERAKHLAK • BERPRESTASI';
    $visiMisiTujuan = [
    [
    'icon' => 'eye',
    'title' => 'Visi',
    'text' => 'Menjadi lembaga pendidikan dan pelatihan vokasi yang unggul, berkarakter, berwawasan lingkungan, dan berstandar internasional.',
    ],
    [
    'icon' => 'sprout',
    'title' => 'Misi',
    'text' => 'Menyelenggarakan pembelajaran berbasis proyek industri, membekal peserta didik dengan kompetensi abad 21, dan membangun kemitraan strategis.',
    ],
    [
    'icon' => 'flag',
    'title' => 'Tujuan',
    'text' => 'Menghasilkan lulusan yang kompeten, kompetitif, adaptif, dan siap kerja atau berwirausaha sesuai kebutuhan Dunia Usaha dan Industri (DUDI).',
    ],
    ];

    $statItems = [
    ['key' => 'total_students', 'label' => 'Siswa Aktif', 'suffix' => '+', 'color' => 'bg-blue-500', 'icon' => 'users'],
    ['key' => 'total_teachers', 'label' => 'Tenaga Pendidik', 'suffix' => '+', 'color' => 'bg-emerald-500', 'icon' => 'user-check'],
    ['key' => 'established_year', 'label' => 'Tahun Berdiri', 'suffix' => '', 'color' => 'bg-slate-800', 'icon' => 'calendar'],
    ['key' => 'total_majors', 'label' => 'Program Keahlian', 'suffix' => '', 'color' => 'bg-amber-500', 'icon' => 'briefcase'],
    ['key' => 'total_alumni', 'label' => 'Alumni Kerja', 'suffix' => '+', 'color' => 'bg-teal-500', 'icon' => 'badge-check'],
    ];
    @endphp

    {{-- ============ NAVBAR ============ --}}
    <header id="main-header" class="fixed inset-x-0 top-0 z-30 bg-transparent text-white transition-all duration-300">
        <nav class="mx-auto flex w-full max-w-[1280px] items-center justify-between px-6 lg:px-8 py-4">
            {{-- Left: School Brand Logo --}}
            <a href="#beranda" class="flex items-center transition hover:opacity-90">
                <img src="{{ asset('smk2.png') }}" alt="{{ $schoolName }}" class="h-9 sm:h-11 w-auto max-w-[220px] sm:max-w-[280px] object-contain drop-shadow-md">
            </a>

                {{-- Center: Menu Navigation Links --}}
            <div class="hidden items-center gap-6 lg:gap-10 text-xs sm:text-[13px] font-bold tracking-widest text-white md:flex">
                <a href="#beranda" class="transition hover:text-cyan-300 uppercase">HOME</a>
                <a href="#profil" class="transition hover:text-cyan-300 uppercase">PROFIL</a>
                <a href="#jurusan" class="transition hover:text-cyan-300 uppercase">JURUSAN</a>
                <div class="group relative flex items-center gap-1.5 py-3 cursor-pointer hover:text-cyan-300 transition">
                    <span class="uppercase">INFORMASI</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition duration-200 group-hover:rotate-180 pointer-events-none">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>

                    {{-- Dropdown Menu Container with Hover Bridge (No gap) --}}
                    <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 absolute left-1/2 -translate-x-1/2 top-full pt-1.5 min-w-[210px] transition-all duration-150 z-50 before:absolute before:-top-3 before:inset-x-0 before:h-4 before:content-['']">
                        <div class="rounded-2xl bg-white/95 backdrop-blur-md p-2 shadow-2xl ring-1 ring-black/5 text-slate-800 tracking-normal normal-case font-medium">
                            <a href="#informasi" class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold hover:bg-sky-50 hover:text-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Berita & Informasi</span>
                            </a>
                            <a href="{{ route('denah') }}" class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold hover:bg-sky-50 hover:text-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>Denah Interaktif</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="group relative flex items-center gap-1.5 cursor-pointer hover:text-cyan-300 transition">
                    <a href="#kesiswaan" class="uppercase">KESISWAAN</a>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition duration-200 group-hover:rotate-180">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            {{-- Right: Informasi PPDB Button --}}
            <a href="#ppdb" class="group inline-flex items-center gap-2.5 rounded-full bg-[#a3e635] hover:bg-[#bef264] py-1.5 pl-4 pr-1.5 text-xs font-black text-slate-950 shadow-lg shadow-lime-400/25 transition-all hover:scale-105">
                <span>Informasi PPDB</span>
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-white transition group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                        <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </a>
        </nav>
    </header>

    {{-- ============ HERO ============ --}}
    @php
    $heroBg = file_exists(public_path('hero-bg.jpg')) ? asset('hero-bg.jpg') : (file_exists(public_path('hero-bg.png')) ? asset('hero-bg.png') : ($imageUrl(data_get($hero, 'background_image')) ?? asset('images/hero-bg.jpg')));
    @endphp
    <section id="beranda" class="relative overflow-hidden min-h-[780px] lg:h-[840px] flex flex-col justify-between pt-24 pb-8 text-white bg-[#05529E]">
        {{-- Foto Background Sekolah --}}
        <img src="{{ $heroBg }}" alt="{{ $schoolName }}" class="absolute inset-0 h-full w-full object-cover object-center opacity-100">
        
        {{-- Gradient Overlay 3-Stop Vertikal Transparan Lebih Gelap & Berkontras Tinggi --}}
        <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(2, 33, 64, 0.82) 0%, rgba(5, 82, 158, 0.72) 45%, rgba(8, 110, 180, 0.60) 100%);"></div>

        {{-- Center Hero Content --}}
        <div class="relative mx-auto mt-4 mb-2 max-w-[1280px] w-full px-6 text-center">
            <p class="text-xs sm:text-sm font-black uppercase tracking-[0.25em] text-white">
                SMKN 2 KOTA MOJOKERTO
            </p>
            <p class="mt-1 text-[10px] sm:text-xs font-bold uppercase tracking-[0.2em] text-sky-100">
                DISIPLIN • BERAKHLAK • BERPRESTASI
            </p>

            <h1 class="mt-2 text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-tight text-white leading-tight drop-shadow-sm">
                SELAMAT DATANG DI<br>
                <span>SMK NEGERI 2 MOJOKERTO</span>
            </h1>

            <p class="mx-auto mt-2 max-w-2xl text-xs sm:text-sm leading-relaxed text-sky-100 font-medium">
                Temukan lingkungan belajar yang aktif, kreatif, dan relevan dengan dunia industri. Belajar dari praktik, berkembang lewat karya, dan siap melangkah lebih jauh.
            </p>

            <a href="#aspirasi" class="mt-4 inline-flex items-center gap-3 rounded-full bg-[#a3e635] hover:bg-[#bef264] px-6 py-2 text-xs sm:text-sm font-extrabold text-slate-950 shadow-xl shadow-lime-400/25 transition-all hover:scale-105">
                <span>KOTAK ASPIRASI</span>
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-white transition group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                        <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </a>
        </div>

        {{-- Arc Carousel: Jarak 4-5 spasi (~40px - 48px) dari tombol Kotak Aspirasi --}}
        <div id="arc-carousel-section" class="relative w-full mt-8 sm:mt-11 pb-12 sm:pb-16" style="min-height:340px;">
            <div id="arc-carousel" class="relative w-full overflow-visible" style="height:290px;">
                {{-- Foto dirender via JS --}}
            </div>
        </div>
    </section>

    <style>
        .arc-slide {
            position: absolute;
            top: 0;
            border-radius: 14.22px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            background: #0a2540;
            cursor: pointer;
            will-change: transform, left, opacity;
            user-select: none;
            backface-visibility: hidden;
        }

        .arc-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            pointer-events: none;
            user-select: none;
            border-radius: 14.22px;
        }
        
        .arc-slide:hover {
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.55), 0 0 0 2px rgba(255, 255, 255, 0.4);
        }
    </style>

    <script>
        (function() {
            const photos = [
                'foto 1.png', 'foto 2.png', 'foto 3.png', 'foto 4.png', 'foto 5.png',
                'foto 6.png', 'foto 7.png', 'foto 8.png', 'foto 9.png'
            ];
            const N = photos.length;
            
            // Variabel Animasi Aliran Kontinu (Tanpa Jeda / Non-Stop Smooth Flow)
            let continuousOffset = 4.0; // Puncak awal pada foto tengah
            const flowSpeed = 0.005;   // Kecepatan aliran halus per frame (~60fps)
            let isPaused = false;
            let slideElements = [];

            // Perhitungan Posisi Titik Kurva Kontinu (Setiap Nilai Pecahan p)
            function getContinuousTrackPoint(p, containerWidth) {
                const isMobile = containerWidth < 640;
                const isTablet = containerWidth < 1024;
                const absP = Math.abs(p);

                // Ukuran kartu dasar
                const baseW = isMobile ? 125 : (isTablet ? 152 : 177.78);
                const baseH = isMobile ? 131 : (isTablet ? 160 : 186.67);
                
                // Jarak spasi dikurangi 1 spasi (~17px)
                const gap = isMobile ? 8 : (isTablet ? 13 : 17);
                const slotDistance = baseW + gap;

                // 1. Posisi X Horizontal
                const containerCenterX = containerWidth / 2;
                const left = containerCenterX + p * slotDistance - baseW / 2;

                // 2. Posisi Y Vertikal: PURE SMOOTH DOME ARC (Tanpa sudut runcing, melengkung halus seperti pelangi)
                const arcDrop = isMobile ? 65 : (isTablet ? 85 : 105);
                const normP = p / 4.0; // Normalisasi rentang posisi [-1.0 .. +1.0]
                const dropY = arcDrop * (normP * normP); // Kurva parabola murni sangat mulus di puncak

                // 3. Skala Proporsional & Rotasi 3D Tangensial Busur Murni
                const scale = Math.max(0.74, 1.0 - (normP * normP) * 0.20);
                const rotateZ = normP * (isMobile ? 3.0 : 4.8); // Kemiringan harmonis mengikuti busur
                const rotateY = normP * (isMobile ? 6.0 : 9.5); // Sudut 3D menghadap tengah

                // 4. Opacity & Fade Mulus di Ujung Tepi
                let opacity = 1.0;
                if (absP <= 3.8) {
                    opacity = Math.max(0.65, 1.0 - (absP / 4.0) * 0.28);
                } else if (absP <= 4.6) {
                    opacity = Math.max(0, 0.72 * (4.6 - absP) / 0.8);
                } else {
                    opacity = 0;
                }

                // 5. Z-Index Berdasarkan Kedalaman (Puncak selalu paling atas)
                const zIndex = Math.max(1, Math.round(50 - (normP * normP) * 40));

                return {
                    left,
                    width: baseW,
                    height: baseH,
                    dropY,
                    scale,
                    rotateZ,
                    rotateY,
                    opacity,
                    zIndex
                };
            }

            // Render Frame Posisi Aliran
            function renderFlow() {
                const container = document.getElementById('arc-carousel');
                if (!container || !slideElements.length) return;

                const containerWidth = container.offsetWidth || window.innerWidth;

                slideElements.forEach((el, photoIndex) => {
                    let p = (photoIndex - continuousOffset) % N;
                    if (p > N / 2) p -= N;
                    if (p < -N / 2) p += N;

                    const pt = getContinuousTrackPoint(p, containerWidth);

                    el.style.left = `${pt.left}px`;
                    el.style.width = `${pt.width}px`;
                    el.style.height = `${pt.height}px`;
                    el.style.transform = `translateY(${pt.dropY}px) scale(${pt.scale}) rotateZ(${pt.rotateZ}deg) rotateY(${pt.rotateY}deg)`;
                    el.style.opacity = pt.opacity;
                    el.style.zIndex = pt.zIndex;
                    el.dataset.p = p.toFixed(3);
                });
            }

            // Loop Animasi Aliran Murni Kontinu (requestAnimationFrame 60fps/120fps)
            function flowLoop() {
                if (!isPaused) {
                    continuousOffset = (continuousOffset + flowSpeed) % N;
                    renderFlow();
                }
                requestAnimationFrame(flowLoop);
            }

            function createSlides(container) {
                container.innerHTML = '';
                slideElements = [];

                photos.forEach((src, photoIndex) => {
                    const el = document.createElement('div');
                    el.className = 'arc-slide';
                    el.dataset.photoIndex = photoIndex;

                    const img = document.createElement('img');
                    img.src = '/' + src.replace(/ /g, '%20');
                    img.alt = `Foto Kegiatan ${photoIndex + 1} SMKN 2 Mojokerto`;
                    img.loading = 'lazy';
                    el.appendChild(img);

                    // Klik foto untuk membawanya mulus ke puncak tengah
                    el.addEventListener('click', () => {
                        const p = parseFloat(el.dataset.p || '0');
                        continuousOffset = ((continuousOffset + p) % N + N) % N;
                        renderFlow();
                    });

                    container.appendChild(el);
                    slideElements.push(el);
                });
            }

            function init() {
                const container = document.getElementById('arc-carousel');
                if (!container) return;

                createSlides(container);
                renderFlow();
                requestAnimationFrame(flowLoop);

                // Pause saat hover/touch agar user bisa melihat foto dengan nyaman
                container.addEventListener('mouseenter', () => {
                    isPaused = true;
                });
                container.addEventListener('mouseleave', () => {
                    isPaused = false;
                });
                container.addEventListener('touchstart', () => {
                    isPaused = true;
                }, { passive: true });
                container.addEventListener('touchend', () => {
                    isPaused = false;
                });

                // Resize responsif
                window.addEventListener('resize', () => {
                    renderFlow();
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

    {{-- ============ SAMBUTAN KEPALA SEKOLAH (SESUAI UKURAN FIGMA: 1200 x 675) ============ --}}
    <section class="relative z-10 px-4 sm:px-6 lg:px-8" style="margin-top: 130px !important; margin-bottom: 90px !important;">
        <div class="mx-auto w-full max-w-[1200px] min-h-[675px] lg:h-[675px] overflow-hidden rounded-3xl sm:rounded-[36px] border border-white/20 bg-slate-900 shadow-2xl shadow-slate-950/40 relative flex flex-col justify-between">
            
            {{-- Background Photo: Lapangan Upacara SMKN 2 Mojokerto --}}
            <img
                src="{{ asset('images/sambutan-bg.jpg') }}"
                alt="Kegiatan SMKN 2 Mojokerto"
                class="absolute inset-0 h-full w-full object-cover object-center"
            />
            {{-- Soft Gradient Vignette Overlay for Crisp Contrast --}}
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-950/45 to-transparent"></div>

            {{-- Main Content Layer (Upper & Middle) --}}
            <div class="relative z-10 flex-1 flex flex-col justify-between p-6 sm:p-10 lg:p-12">
                
                {{-- Top Badge: Terakreditasi "A" --}}
                <div class="flex items-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-400 text-amber-950 px-4 py-1.5 text-xs sm:text-sm font-black shadow-md tracking-wider">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-amber-950">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        TERAKREDITASI &quot;A&quot;
                    </span>
                </div>

                {{-- Center Content: Glassmorphic Quote Card + Headmaster Standout --}}
                <div class="my-auto py-6 grid grid-cols-1 lg:grid-cols-[1fr_auto] items-center">
                    
                    {{-- Glass Quote Card --}}
                    <div class="max-w-[560px] rounded-2xl sm:rounded-3xl bg-slate-950/45 backdrop-blur-md border border-white/20 p-6 sm:p-8 text-white shadow-2xl">
                        <p class="text-base sm:text-lg lg:text-[19px] font-semibold leading-relaxed text-white drop-shadow-sm">
                            &ldquo;Pendidikan vokasi adalah kunci kemandirian bangsa. Kami mendidik dengan hati, mengasah kompetensi, dan mencetak generasi yang tangguh menghadapi tantangan global.&rdquo;
                        </p>
                        <div class="mt-5">
                            <p class="text-base sm:text-lg font-bold text-lime-400 tracking-wide">
                                Bapak Iswahyudi, S.ST.
                            </p>
                            <p class="text-xs sm:text-sm font-medium text-slate-200/90 mt-0.5">
                                Kepala SMKN 2 Mojokerto
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Empty placeholder spacer --}}
                <div></div>
            </div>

            {{-- Cutout Foto Kepala Sekolah (Positioned Bottom Right, W: 466px x H: 604px) --}}
            <img
                src="{{ asset('images/kepala-sekolah.png') }}"
                alt="Bapak Iswahyudi, S.ST."
                class="absolute bottom-0 right-2 sm:right-6 lg:right-10 w-[300px] sm:w-[380px] lg:w-[466px] max-h-[604px] object-contain object-bottom pointer-events-none drop-shadow-2xl z-20"
            />

            {{-- Bottom Stats Bar (Dark Navy Glass Capsule) --}}
            <div class="relative z-30 bg-[#0c2f4a]/95 backdrop-blur-md border-t border-white/10 px-6 sm:px-10 lg:px-12 py-4 sm:py-5">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 divide-y sm:divide-y-0 divide-white/5">
                    
                    {{-- 1. Siswa Aktif --}}
                    <div class="flex items-center gap-3 py-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-500/20 text-sky-400 border border-sky-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0-.41 1.412A9.957 9.957 0 0 0 10 18a9.959 9.959 0 0 0 6.945-2.095 1.229 1.229 0 0 0-.41-1.412A9.99 9.99 0 0 0 10 12a9.99 9.99 0 0 0-6.535 2.493Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-base sm:text-lg font-extrabold text-white leading-none">1.850+</p>
                            <p class="mt-1 text-xs font-medium text-slate-300 leading-none">Siswa Aktif</p>
                        </div>
                    </div>

                    {{-- 2. Tenaga Pendidik --}}
                    <div class="flex items-center gap-3 py-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.5 7.25c0-2.9 3.5-4.75 5.5-4.75 1.05 0 2.42.51 3.55 1.36a4.5 4.5 0 0 0-.05 4.64c-1 .3-2.2.5-3.5.5-2.9 0-5.5-.85-5.5-1.75ZM17.03 12.03a.75.75 0 0 0-1.06-1.06l-2.72 2.72-1.22-1.22a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.06 0l3.25-3.25Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-base sm:text-lg font-extrabold text-white leading-none">120+</p>
                            <p class="mt-1 text-xs font-medium text-slate-300 leading-none">Tenaga Pendidik</p>
                        </div>
                    </div>

                    {{-- 3. Tahun Berdiri --}}
                    <div class="flex items-center gap-3 py-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-600/20 text-sky-300 border border-sky-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-base sm:text-lg font-extrabold text-white leading-none">2014</p>
                            <p class="mt-1 text-xs font-medium text-slate-300 leading-none">Tahun Berdiri</p>
                        </div>
                    </div>

                    {{-- 4. Program Keahlian --}}
                    <div class="flex items-center gap-3 py-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-500/20 text-amber-400 border border-amber-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M7.5 5.5A2.5 2.5 0 0 1 10 3h0a2.5 2.5 0 0 1 2.5 2.5V6h3A1.5 1.5 0 0 1 17 7.5v7A1.5 1.5 0 0 1 15.5 16h-11A1.5 1.5 0 0 1 3 14.5v-7A1.5 1.5 0 0 1 4.5 6h3v-.5ZM9 6h2v-.5a1 1 0 0 0-1-1h0a1 1 0 0 0-1 1V6Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-base sm:text-lg font-extrabold text-white leading-none">5</p>
                            <p class="mt-1 text-xs font-medium text-slate-300 leading-none">Program Keahlian</p>
                        </div>
                    </div>

                    {{-- 5. Alumni Kerja --}}
                    <div class="flex items-center gap-3 py-1">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-base sm:text-lg font-extrabold text-white leading-none">1.000+</p>
                            <p class="mt-1 text-xs font-medium text-slate-300 leading-none">Alumni Kerja</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ============ VISI, MISI, TUJUAN ============ --}}
    <section id="profil" class="mx-auto max-w-5xl px-5 py-16 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-3">
            @foreach ($visiMisiTujuan as $item)
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-lime-50 text-lime-600">
                    @switch($item['icon'])
                    @case('eye')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                    </svg>
                    @break
                    @case('sprout')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M10 2a6 6 0 0 0-6 6c0 3.5 3 6.5 6 10 3-3.5 6-6.5 6-10a6 6 0 0 0-6-6Zm0 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z" />
                    </svg>
                    @break
                    @default
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M4 2.75A.75.75 0 0 1 4.75 2h1.5a.75.75 0 0 1 0 1.5H5.5v13a.75.75 0 0 1-1.5 0v-13.75ZM6.5 4h8.086a1 1 0 0 1 .707 1.707L13 8l2.293 2.293A1 1 0 0 1 14.586 12H6.5V4Z" />
                    </svg>
                    @endswitch
                </span>
                <h3 class="mt-4 font-bold text-slate-950">{{ $item['title'] }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $item['text'] }}</p>
            </div>
            @endforeach
        </div>
        {{-- ============ PROGRAM KEAHLIAN / JURUSAN ============ --}}
        <section id="jurusan" class="border-t border-slate-200/80 bg-[#f8fafc] py-16 px-5 lg:px-8"
            x-data="{
                currentIndex: 0,
                total: 7,
                get visibleCount() {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                },
                get maxIndex() {
                    return Math.max(0, this.total - this.visibleCount);
                },
                next() {
                    if (this.currentIndex < this.maxIndex) {
                        this.currentIndex++;
                    } else {
                        this.currentIndex = 0;
                    }
                },
                prev() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    } else {
                        this.currentIndex = this.maxIndex;
                    }
                }
            }">
            <div class="mx-auto max-w-6xl">
                {{-- Header matching mockup --}}
                <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-black text-[#05529E] tracking-wide uppercase">
                        JURUSAN
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kisah sukses para alumni yang telah berkiprah di dunia industri dan perguruan tinggi ternama.
                    </p>
                </div>

                {{-- Carousel Slider Container --}}
                <div class="relative overflow-hidden pb-4">
                    <div 
                        class="flex transition-transform duration-500 ease-out gap-6"
                        :style="`transform: translateX(calc(-${currentIndex} * (100% + 1.5rem) / ${visibleCount}));`"
                    >
                        {{-- 1. APHP --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div id="jurusan-aphp" class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('aphp.jpeg') }}" alt="Jurusan APHP SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">APHP</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Agribisnis Pengolahan Hasil Pertanian</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Agribisnis Pengolahan Hasil Pertanian (APHP) membekali siswa dengan keterampilan mengolah hasil pertanian menjadi produk berkualitas, dari proses produksi, pengemasan, hingga pemasaran.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 2. LPS --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div id="jurusan-lps" class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('lps.jpeg') }}" alt="Jurusan LPS SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">LPS</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Layanan Perbankan Syariah</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Layanan Perbankan Syariah (LPS) membekali siswa dengan keterampilan pelayanan dan administrasi perbankan berdasarkan prinsip syariah sebagai persiapan memasuki dunia kerja.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 3. RPL --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div id="jurusan-rpl" class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('rpl.jpeg') }}" alt="Jurusan RPL SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">RPL</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Rekayasa Perangkat Lunak</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Rekayasa Perangkat Lunak (RPL) membekali siswa dengan keahlian komputasi, pemrograman aplikasi web dan mobile, perancangan database, dan rekayasa software modern.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 4. DKV --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div id="jurusan-dkv" class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('dkv.jpeg') }}" alt="Jurusan DKV SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">DKV</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Desain Komunikasi Visual</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Desain Komunikasi Visual (DKV) mengembangkan kreativitas siswa dalam desain grafis, ilustrasi digital, videografi, fotografi studio, animasi, dan perancangan identitas visual kreatif.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 5. Tata Boga (Kuliner) --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div id="jurusan-boga" class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('kuliner.jpeg') }}" alt="Jurusan Kuliner SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">Tata Boga</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Kuliner & Tata Hidang</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Tata Boga (Kuliner) membekali siswa dengan keahlian seni memasak masakan nusantara dan kontinental, pastry & bakery, table setup, hingga manajemen operasional restoran dan kuliner.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 6. APHP (Loop Slot 1) --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('aphp.jpeg') }}" alt="Jurusan APHP SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">APHP</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Agribisnis Pengolahan Hasil Pertanian</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Agribisnis Pengolahan Hasil Pertanian (APHP) membekali siswa dengan keterampilan mengolah hasil pertanian menjadi produk berkualitas, dari proses produksi, pengemasan, hingga pemasaran.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- 7. LPS (Loop Slot 2) --}}
                        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex">
                            <div class="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 text-center">
                                <div>
                                    <div class="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner">
                                        <img src="{{ asset('lps.jpeg') }}" alt="Jurusan LPS SMKN 2 Mojokerto" class="w-full h-full object-cover" />
                                    </div>
                                    <h3 class="text-xl font-extrabold text-slate-900">LPS</h3>
                                    <p class="text-xs font-bold text-sky-600 mt-1">Layanan Perbankan Syariah</p>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic">
                                        Layanan Perbankan Syariah (LPS) membekali siswa dengan keterampilan pelayanan dan administrasi perbankan berdasarkan prinsip syariah sebagai persiapan memasuki dunia kerja.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Navigation Arrows matching mockup --}}
                <div class="mt-8 flex items-center justify-center gap-3">
                    <button 
                        type="button"
                        @click="prev()"
                        aria-label="Jurusan Sebelumnya"
                        class="h-10 w-10 rounded-full border border-slate-200 bg-white text-slate-700 flex items-center justify-center hover:bg-slate-100 transition shadow-2xs cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        type="button"
                        @click="next()"
                        aria-label="Jurusan Berikutnya"
                        class="h-10 w-10 rounded-full bg-[#05529E] text-white flex items-center justify-center hover:bg-[#0766c6] transition shadow-sm cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        </section>
        {{-- ^ menutup section id=profil yang sebelumnya tidak tertutup --}}

        {{-- ============ DENAH INTERAKTIF ============ --}}
        <x-denah-interaktif />

        {{-- ============ MITRA INDUSTRI KAMI ============ --}}
        {{-- NOTE: belum ada aset logo mitra, jadi masih placeholder kosong.
             Ganti isi <div id="mitra-logos"> dengan <img> logo asli. --}}
        <section id="mitra" class="border-t border-slate-200/80 bg-white py-16 px-5 lg:px-8">
            <div class="mx-auto max-w-5xl text-center">
                <span class="inline-block rounded-full bg-blue-50 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-700">
                    Kemitraan
                </span>
                <h2 class="mt-3 text-2xl font-extrabold text-slate-900 sm:text-3xl">
                    Mitra Industri Kami
                </h2>

                <div id="mitra-logos" class="mt-8 flex h-32 items-center justify-center rounded-2xl border-2 border-dashed border-blue-200 bg-blue-50/40 text-xs font-bold uppercase tracking-wide text-blue-300">
                    Logo Mitra Industri (DUDI)
                </div>
            </div>
        </section>

        {{-- ============ EKSTRAKURIKULER ============ --}}
        {{-- NOTE: foto/video ekskul masih placeholder, ganti sesuai aset asli.
             Klik nama ekskul di kiri untuk ganti foto/label di kanan (Alpine.js). --}}
        <section id="ekstrakurikuler" class="border-t border-slate-200/80 bg-[#eef6ff] py-16 px-5 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="inline-block rounded-full bg-blue-50 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-700">
                        Kesiswaan
                    </span>
                    <h2 class="mt-3 text-2xl font-extrabold text-slate-900 sm:text-3xl">
                        Ekstrakurikuler
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Wadah pengembangan minat dan bakat siswa di luar kegiatan akademik.
                    </p>
                </div>

                @php
                $ekstrakurikuler = ['Paskibra', 'Futsal', 'Tari', 'Basket', 'Pramuka', 'PMR', 'Pencak Silat', 'English Club'];
                @endphp
                <div class="mt-10 grid gap-5 lg:grid-cols-3">
                    {{-- List / tab kiri --}}
                    <div id="ekskul-tabs" class="rounded-2xl bg-white p-3 shadow-sm lg:col-span-1">
                        @foreach ($ekstrakurikuler as $index => $nama)
                        <button
                            type="button"
                            onclick="pilihEkskul(this, '{{ $nama }}')"
                            class="ekskul-tab flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-bold transition {{ $index === 0 ? 'bg-blue-600 text-white shadow-md is-active' : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="h-2 w-2 shrink-0 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-blue-300' }}"></span>
                            <span>{{ $nama }}</span>
                        </button>
                        @endforeach
                    </div>

                    {{-- Preview foto/video kanan --}}
                    <div class="relative overflow-hidden rounded-2xl shadow-lg lg:col-span-2">
                        <div class="flex h-64 items-center justify-center bg-slate-800 sm:h-80">
                            <span class="text-xs font-bold uppercase tracking-wide text-white/40">Foto / Video Kegiatan</span>
                        </div>
                        <span id="ekskul-label" class="absolute left-4 top-4 rounded-lg bg-black/40 px-3 py-1.5 text-sm font-extrabold text-white backdrop-blur-sm">{{ $ekstrakurikuler[0] }}</span>
                        <button type="button" class="absolute inset-0 flex items-center justify-center" aria-label="Putar video">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/25 text-white backdrop-blur-sm transition hover:scale-110 hover:bg-white/40">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-7 w-7 translate-x-0.5">
                                    <path fill-rule="evenodd" d="M4.5 3.5A1.5 1.5 0 0 1 6.837 2.19l9.5 5.5a1.5 1.5 0 0 1 0 2.62l-9.5 5.5A1.5 1.5 0 0 1 4.5 14.5v-11Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                {{-- Banner foto kegiatan (belum ada asetnya, placeholder) --}}
                <div class="mt-8 flex h-40 items-center justify-center rounded-2xl bg-blue-600 text-xs font-bold uppercase tracking-wide text-white/60 sm:h-56">
                    Foto Banner Kegiatan Sekolah
                </div>
            </div>
        </section>

        {{-- ============ PRESTASI & KEJUARAAN ============ --}}
        {{-- NOTE: foto & tanggal masih placeholder, sesuaikan dengan data prestasi asli. --}}
        <section id="prestasi" class="border-t border-slate-200/80 bg-white py-16 px-5 lg:px-8">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-8 lg:grid-cols-2 lg:items-start">
                    {{-- Foto utama --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex h-56 items-center justify-center bg-slate-200 text-xs font-bold uppercase tracking-wide text-slate-400 sm:h-72">
                            Foto Prestasi
                        </div>
                        <div class="bg-white p-4">
                            <span class="inline-block rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                Prestasi
                            </span>
                            <h3 class="mt-2 text-sm font-bold leading-snug text-slate-900">
                                Lomba Menulis Surat untuk Gubernur Memperingati Hari Pendidikan
                            </h3>
                        </div>
                    </div>

                    {{-- Daftar prestasi lain --}}
                    <div class="space-y-1">
                        <span class="inline-block rounded-full bg-amber-50 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-amber-700">
                            Kejuaraan
                        </span>
                        <h2 class="mt-2 text-2xl font-extrabold text-slate-900 sm:text-3xl">
                            Prestasi &amp; Kejuaraan
                        </h2>

                        @php
                        $daftarPrestasi = [
                        ['title' => 'Duta Koperasi', 'meta' => 'Tingkat Kota Mojokerto'],
                        ['title' => 'Turnamen Futsal Tumen Cup 2026', 'meta' => 'Tingkat Kota Mojokerto'],
                        ['title' => 'Kejuaraan Provinsi (Kejurprov) Dayung 2026', 'meta' => 'Tingkat Provinsi Jawa Timur'],
                        ['title' => 'Graphic Design Tournament', 'meta' => 'Tingkat Nasional'],
                        ];
                        @endphp
                        <div class="mt-6 divide-y divide-slate-100">
                            @foreach ($daftarPrestasi as $prestasi)
                            <div class="flex items-start gap-4 py-4">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5">
                                        <path fill-rule="evenodd" d="M10 1c-1.828 0-3.623.149-5.371.435a.75.75 0 0 0-.629.74v.387c-.827.157-1.642.345-2.445.564a.75.75 0 0 0-.552.698 5.048 5.048 0 0 0 4.44 5.147A6.484 6.484 0 0 0 8.5 10.607V12.5H6a.75.75 0 0 0 0 1.5h1.5v1.5H6.75a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5H12.5V14H14a.75.75 0 0 0 0-1.5h-2.5v-1.893a6.484 6.484 0 0 0 3.057-1.636 5.048 5.048 0 0 0 4.44-5.147.75.75 0 0 0-.552-.698A31.66 31.66 0 0 0 16 2.562v-.387a.75.75 0 0 0-.629-.74A33.169 33.169 0 0 0 10 1Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold leading-snug text-slate-900">{{ $prestasi['title'] }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $prestasi['meta'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ BERITA TERBARU ============ --}}
        {{-- NOTE: foto & tanggal artikel masih placeholder, sesuaikan dengan berita asli. --}}
        <section id="informasi" class="border-t border-slate-200/80 bg-slate-50/60 py-16 px-5 lg:px-8">
            <div class="mx-auto max-w-5xl">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="inline-block rounded-full bg-blue-50 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-700">
                        Informasi
                    </span>
                    <h2 class="mt-3 text-2xl font-extrabold text-slate-900 sm:text-3xl">
                        Berita Terbaru
                    </h2>
                </div>

                {{-- Filter tag (statis, belum ada logika filter) --}}
                <div class="mt-8 flex flex-wrap items-center justify-center gap-2">
                    @foreach (['Semua', 'Informasi', 'Agenda', 'Pengumuman', 'Kejuaraan'] as $index => $tag)
                    <span class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition {{ $index === 0 ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-200 border border-slate-200' }}">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>

                @php
                $beritaTerbaru = [
                [
                'tag' => 'Kejuaraan',
                'title' => 'Siswa Jurusan Pengembangan Gim SMKN 2 Kota Mojokerto Ciptakan Game Edukasi AR untuk Kenalkan Batik Malang kepada Anak-Anak',
                ],
                [
                'tag' => 'Informasi',
                'title' => 'Belajar Tanpa Batas dengan Hadirnya WiFi Gratis di SMK Negeri 2 Kota Mojokerto',
                ],
                ];
                @endphp
                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    @foreach ($beritaTerbaru as $berita)
                    <div class="group overflow-hidden rounded-2xl bg-blue-600 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex h-40 items-center justify-center bg-blue-700/60 text-xs font-bold uppercase tracking-wide text-white/50">
                            Foto Berita
                        </div>
                        <div class="p-5">
                            <span class="inline-block rounded-full bg-white/15 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-white">
                                {{ $berita['tag'] }}
                            </span>
                            <h3 class="mt-3 text-sm font-bold leading-snug text-white">
                                {{ $berita['title'] }}
                            </h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ FOOTER (FULL WIDTH SEPERTI NAVBAR & TEKS WARNA PUTIH) ============ --}}
        <footer id="kontak" class="bg-gradient-to-b from-[#05529E] via-[#03315F] to-[#021D37] text-white">
            <div class="mx-auto w-full max-w-[1280px] px-6 lg:px-8 pt-14 pb-8 flex flex-col justify-between">
                
                {{-- Top/Main Footer Columns (Stretched Full Width Across Grid) --}}
                <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-12 lg:gap-8 items-start w-full">

                    {{-- Column 1: School Card & Motto --}}
                    <div class="lg:col-span-4 space-y-4">
                        <div class="inline-flex rounded-2xl bg-white px-5 py-3 shadow-xl">
                            <img src="{{ asset('smk2-footer.png') }}" alt="Logo SMK Negeri 2 Kota Mojokerto" class="h-10 sm:h-11 w-auto object-contain">
                        </div>
                        <p class="text-xs sm:text-[13px] text-white/90 leading-relaxed max-w-sm font-medium">
                            Kami Siap Melayani Masyarakat Pendidikan Dan Pembelajaran Berbasis Budaya Kerja, Disiplin Dan Berprestasi.
                        </p>
                    </div>

                    {{-- Column 2: MENU UTAMA --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-white">MENU UTAMA</h4>
                            <div class="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
                        </div>
                        <ul class="space-y-2.5 text-xs sm:text-[13px] text-white font-medium">
                            <li>
                                <a href="#beranda" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Beranda</span>
                                </a>
                            </li>
                            <li>
                                <a href="#profil" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Tentang Kami</span>
                                </a>
                            </li>
                            <li>
                                <a href="#jurusan" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Profil Jurusan</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mitra" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Mitra Industri</span>
                                </a>
                            </li>
                            <li>
                                <a href="#ekstrakurikuler" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Ekstrakurikuler</span>
                                </a>
                            </li>
                            <li>
                                <a href="#prestasi" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Prestasi</span>
                                </a>
                            </li>
                            <li>
                                <a href="#informasi" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>Berita</span>
                                </a>
                            </li>
                            <li>
                                <a href="#ppdb" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition group">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                                    <span>PPDB</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Column 3: SOSMED KAMI --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-white">SOSMED KAMI</h4>
                            <div class="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-3 text-white">
                            {{-- Facebook --}}
                            <a href="https://facebook.com/smkn2kotamojokerto" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm" title="Facebook SMKN 2 Kota Mojokerto">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.7 5H18V0h-3.808C10.597 0 9 1.583 9 4.615V8z" />
                                </svg>
                            </a>
                            {{-- Instagram --}}
                            <a href="https://www.instagram.com/smkn2kotamojokerto" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm" title="Instagram @smkn2kotamojokerto">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            {{-- TikTok --}}
                            <a href="https://tiktok.com/@smkn2kotamojokerto" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm" title="TikTok SMKN 2 Kota Mojokerto">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Column 4: ALAMAT (Map Card Resmi SMKN 2 Mojokerto di Pulorejo) --}}
                    <div class="lg:col-span-4 space-y-4">
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest text-white">LOKASI &amp; ALAMAT</h4>
                            <div class="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
                        </div>
                        <div class="overflow-hidden rounded-2xl border border-white/15 bg-[#03315F] shadow-xl">
                            {{-- Map Embed / View --}}
                            <div class="relative h-28 w-full bg-slate-200">
                                <iframe
                                    src="https://maps.google.com/maps?q=SMK+Negeri+2+Kota+Mojokerto,+Jl.+Raya+Pulorejo,+Kota+Mojokerto&t=&z=16&ie=UTF8&iwloc=&output=embed"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="h-full w-full object-cover"></iframe>
                            </div>
                            {{-- Map Bottom Bar --}}
                            <div class="flex items-start gap-2.5 p-3 bg-[#021D37]">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20 text-white shadow-md mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.77 11.77 0 0 0 1.039.573l.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[11px] leading-snug text-white font-medium">
                                        Jl. Raya Pulorejo, Mergelo, Pulorejo, Kec. Prajurit Kulon, Kota Mojokerto, Jawa Timur 61325
                                    </p>
                                    <p class="text-[10px] text-white/80 font-bold mt-0.5">Plus Code: GCPF+6HJ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Bottom Sub-Footer Bar (Full Width Sesuai Navbar) --}}
                <div class="mt-10 pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/90">
                    <p class="text-white/90 text-center sm:text-left">
                        &copy; {{ date('Y') }} SMK Negeri 2 Mojokerto. Hak Cipta Dilindungi.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-6 font-medium text-white">
                        <a href="tel:0321387356" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-white">
                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                            </svg>
                            <span>0321 387356</span>
                        </a>
                        <a href="mailto:smkn2mr@gmail.com" class="inline-flex items-center gap-2 text-white hover:text-white/80 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-white">
                                <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                            </svg>
                            <span>smkn2mr@gmail.com</span>
                        </a>
                    </div>
                </div>

            </div>
        </footer>

        {{-- Chatbot AI Widget --}}
        <x-chatbot :school-name="$schoolName" />

        <script>
            // Tab Ekstrakurikuler: ganti label preview foto/video saat tab diklik
            function pilihEkskul(btn, nama) {
                document.querySelectorAll('#ekskul-tabs .ekskul-tab').forEach(function (tab) {
                    tab.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'is-active');
                    tab.classList.add('text-slate-700', 'hover:bg-slate-100');
                    const dot = tab.querySelector('span');
                    if (dot) {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-blue-300');
                    }
                });
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'is-active');
                btn.classList.remove('text-slate-700', 'hover:bg-slate-100');
                const dot = btn.querySelector('span');
                if (dot) {
                    dot.classList.add('bg-white');
                    dot.classList.remove('bg-blue-300');
                }
                const label = document.getElementById('ekskul-label');
                if (label) {
                    label.textContent = nama;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const header = document.getElementById('main-header');
                if (header) {
                    window.addEventListener('scroll', function() {
                        if (window.scrollY > 30) {
                            header.classList.add('bg-slate-950/80', 'backdrop-blur-md', 'border-b', 'border-white/10', 'shadow-lg');
                            header.classList.remove('bg-transparent');
                        } else {
                            header.classList.remove('bg-slate-950/80', 'backdrop-blur-md', 'border-b', 'border-white/10', 'shadow-lg');
                            header.classList.add('bg-transparent');
                        }
                    });
                }
            });
        </script>
</body>

</html>