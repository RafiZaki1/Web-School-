<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ data_get($home, 'school_profile.school_name', data_get($home, 'hero.school_name', config('app.name'))) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    @php
        $hero = data_get($home, 'hero');
        $profile = data_get($home, 'school_profile');
        $statistics = data_get($home, 'statistics', []);
        $galleries = collect(data_get($home, 'galleries', []));
        $schoolName = data_get($profile, 'school_name', data_get($hero, 'school_name', 'Sekolah Kita'));
        $imageUrl = fn ($path) => $path && filter_var($path, FILTER_VALIDATE_URL) ? $path : ($path ? Storage::url($path) : null);

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

        // Statis juga (belum ada model Major/Jurusan di database — lihat catatan di README)
        $jurusanList = [
            [
                'code' => 'APHP',
                'name' => 'Agribisnis Pengolahan Hasil Pertanian',
                'accent' => 'from-lime-400 to-emerald-500',
                'text' => 'Agribisnis Pengolahan Hasil Pertanian (APHP) membekali siswa dengan keterampilan mengolah hasil pertanian menjadi produk berkualitas, dari proses produksi, pengemasan, hingga pemasaran.',
            ],
            [
                'code' => 'LPS',
                'name' => 'Layanan Perbankan Syariah',
                'accent' => 'from-slate-200 to-slate-400',
                'text' => 'Layanan Perbankan Syariah (LPS) membekali siswa dengan keterampilan pelayanan dan administrasi perbankan berdasarkan prinsip syariah sebagai persiapan memasuki dunia kerja.',
            ],
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'accent' => 'from-amber-300 to-orange-400',
                'text' => 'Rekayasa Perangkat Lunak (RPL) membekali siswa dengan keterampilan pengembangan aplikasi dan administrasi sistem berbasis prinsip rekayasa perangkat lunak sebagai persiapan memasuki dunia kerja.',
            ],
        ];

        // Statis juga (belum ada model Extracurricular — lihat catatan di README)
        $ekskulList = [
            ['icon' => 'flag', 'name' => 'Paskibra', 'tagline' => 'Disiplin & kepemimpinan', 'desc' => 'Membentuk karakter disiplin, tanggung jawab, dan jiwa kepemimpinan melalui latihan baris-berbaris serta kegiatan upacara.'],
            ['icon' => 'ball', 'name' => 'Futsal', 'tagline' => 'Kerja sama & sportivitas', 'desc' => 'Melatih kerja sama tim, sportivitas, dan kebugaran fisik lewat latihan dan kompetisi futsal antarsekolah.'],
            ['icon' => 'music', 'name' => 'Tari', 'tagline' => 'Seni & budaya', 'desc' => 'Mengasah ekspresi seni dan kecintaan pada budaya lokal lewat latihan tari tradisional dan modern.'],
            ['icon' => 'mic', 'name' => 'Paduan Suara', 'tagline' => 'Vokal & harmoni', 'desc' => 'Melatih kepekaan vokal, harmoni, dan kekompakan tim lewat latihan paduan suara rutin.'],
        ];
        $activeEkskul = $ekskulList[0];

        $industryPartners = [
            'BIG.CO.ID',
        ];

        $achievementList = [
            ['date' => 'Jun 2026', 'title' => 'Duta Koperasi', 'desc' => 'Juara 1 Putri - Vania Diametta Putri XII LPS 2'],
            ['date' => 'Jun 2026', 'title' => 'Turnamen Futsal Tunas Cup 2026', 'desc' => 'Juara 3 - Tim Futsal SMKN 2 MOJOKERTO'],
            ['date' => 'Mei 2026', 'title' => 'Kejuaraan Provinsi (Kejurprov) Dayung 2026', 'desc' => 'Medali Perunggu - Ayu Pinky Salsabila'],
            ['date' => 'Apr 2026', 'title' => 'Graphic Design Technology', 'desc' => 'Juara 3 - Tim Karya Siswa XII DKV'],
        ];
        $featuredAchievement = [
            'title' => 'Lomba Menulis Surat Untuk Gubernur Memperingati Hari Pendidikan',
            'author' => 'Carla Nur Parawansa - Kelas XII LPS 2',
        ];

        $newsCategories = ['Semua', 'Informasi umum', 'Prestasi', 'Agenda sekolah', 'Pengumuman', 'Karya siswa'];
        $featuredNews = [
            'badge' => 'Prestasi',
            'title' => 'Siswa jurusan pengembangan gim SMKN 2 Kota Mojokerto ciptakan game edukasi AR untuk kenalkan batik Malang kepada anak-anak',
            'date' => '19 Jul 2026',
        ];
        $newsList = [
            ['badge' => 'Agenda sekolah', 'title' => 'Belajar teknologi dengan standar global di SMK Negeri 2 Kota Mojokerto', 'date' => '4 Maret 2026'],
            ['badge' => 'Agenda sekolah', 'title' => 'Belajar teknologi dengan standar global di SMK Negeri 2 Kota Mojokerto', 'date' => '4 Maret 2026'],
        ];
    @endphp

    {{-- ============ NAVBAR ============ --}}
    <header class="fixed inset-x-0 top-0 z-30 bg-slate-950 text-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 lg:px-8">
            <a href="#beranda" class="flex items-center gap-3">
                @if ($logo = $imageUrl(data_get($profile, 'school_logo')))
                    <img src="{{ $logo }}" alt="{{ $schoolName }}" class="h-10 w-10 rounded-full object-cover">
                @else
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-lime-400 text-sm font-bold text-slate-950">
                        {{ strtoupper(substr($schoolName, 0, 1)) }}
                    </span>
                @endif
                <span class="hidden text-sm font-bold uppercase leading-tight tracking-wide sm:block">
                    {{ $schoolName }}
                </span>
            </a>

            <div class="hidden items-center gap-8 text-sm font-medium text-slate-300 md:flex">
                <a href="#beranda" class="transition hover:text-white">Home</a>
                <a href="#profil" class="transition hover:text-white">Profil</a>
                <a href="#jurusan" class="transition hover:text-white">Jurusan</a>
                <a href="#informasi" class="transition hover:text-white">Informasi</a>
            </div>

            <a href="#ppdb" class="group inline-flex items-center gap-2 rounded-full bg-lime-400 py-1.5 pl-4 pr-1.5 text-xs font-bold text-slate-950 transition hover:bg-lime-300">
                Informasi PPDB
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-lime-400 transition group-hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </a>
        </nav>
    </header>

    <main>
        {{-- ============ HERO ============ --}}
        <section id="beranda" class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#0b2e42] to-[#0e3f52] pb-28 pt-32 text-white">
            @if ($background = $imageUrl(data_get($hero, 'background_image')))
                <img src="{{ $background }}" alt="{{ $schoolName }}" class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-luminosity">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-transparent to-[#0e3f52]"></div>

            <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-300">
                    {{ data_get($hero, 'school_name', $schoolName) }}
                </p>
                <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-400">
                    {{ $tagline }}
                </p>

                <h1 class="mt-6 text-3xl font-extrabold leading-tight sm:text-4xl">
                    SELAMAT DATANG DI<br>
                    <span class="text-4xl sm:text-5xl">{{ data_get($hero, 'title', mb_strtoupper($schoolName)) }}</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-sm leading-relaxed text-slate-300 sm:text-base">
                    {{ data_get($hero, 'description', 'Temukan lingkungan belajar yang aktif, kreatif, dan relevan dengan dunia industri. Belajar dari praktik, berkembang lewat karya, dan siap melangkah lebih jauh.') }}
                </p>

                <a href="{{ data_get($hero, 'button_url', '#jurusan') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-lime-400 px-6 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-lime-400/20 transition hover:bg-lime-300">
                    {{ data_get($hero, 'button_text', 'Jelajahi Jurusan') }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            {{-- Filmstrip foto kegiatan (carousel jalan otomatis, infinite loop) --}}
            @if ($galleries->count())
                <div class="group relative mt-14 overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]">
                   
                </div>
            @endif
        </section>

        {{-- ============ QUOTE + STATS (overlap ke atas hero) ============ --}}
        <section class="relative z-10 -mt-16 px-5 lg:px-8">
            <div class="mx-auto max-w-5xl overflow-hidden rounded-3xl bg-white shadow-2xl shadow-slate-900/10">
                <div class="relative grid gap-0 sm:grid-cols-[1fr_320px]">
                    {{-- Kutipan --}}
                    <div class="relative flex flex-col justify-center overflow-hidden p-8 sm:p-10">
                        @if ($quoteBg = $imageUrl(data_get($galleries->first(), 'image')))
                            <img src="{{ $quoteBg }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                            <div class="absolute inset-0 bg-slate-950/55 backdrop-blur-[2px]"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-950"></div>
                        @endif

                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-lime-400/70">
                                <path d="M7.17 6C4.87 6 3 7.87 3 10.17c0 2.3 1.87 4.17 4.17 4.17.34 0 .68-.05 1-.13-.5 1.6-1.9 2.79-3.63 2.79v2c3.5 0 6.3-2.55 6.3-6.66V10.17C10.84 7.87 8.97 6 7.17 6Zm10 0C14.87 6 13 7.87 13 10.17c0 2.3 1.87 4.17 4.17 4.17.34 0 .68-.05 1-.13-.5 1.6-1.9 2.79-3.63 2.79v2c3.5 0 6.3-2.55 6.3-6.66V10.17C20.84 7.87 18.97 6 17.17 6Z"/>
                            </svg>
                            <p class="mt-3 text-lg font-semibold leading-snug text-white sm:text-xl">
                                {{ data_get($profile, 'welcome_message', 'Pendidikan vokasi adalah kunci kemandirian bangsa. Kami mendidik dengan hati, mengasah kompetensi, dan mencetak generasi yang tangguh menghadapi tantangan global.') }}
                            </p>
                            <p class="mt-5 text-sm font-bold text-lime-400">
                                {{ data_get($profile, 'principal_name', 'Kepala Sekolah') }}
                            </p>
                            <p class="text-xs font-medium text-slate-300">
                                {{ data_get($profile, 'principal_position', 'Kepala Sekolah') }}
                            </p>
                        </div>
                    </div>

                    {{-- Foto kepala sekolah --}}
                    <div class="relative hidden min-h-[260px] sm:block">
                        @if ($photo = $imageUrl(data_get($profile, 'principal_photo')))
                            <img src="{{ $photo }}" alt="{{ data_get($profile, 'principal_name', 'Kepala Sekolah') }}" class="absolute inset-0 h-full w-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-slate-200"></div>
                        @endif
                    </div>
                </div>

                {{-- Stats bar --}}
                <div class="grid grid-cols-2 divide-x divide-y divide-slate-100 border-t border-slate-100 sm:grid-cols-5 sm:divide-y-0">
                    @foreach ($statItems as $stat)
                        <div class="flex items-center gap-3 px-4 py-5">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $stat['color'] }} text-white">
                                @switch($stat['icon'])
                                    @case('users')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0-.41 1.412A9.957 9.957 0 0 0 10 18a9.959 9.959 0 0 0 6.945-2.095 1.229 1.229 0 0 0-.41-1.412A9.99 9.99 0 0 0 10 12a9.99 9.99 0 0 0-6.535 2.493Z"/></svg>
                                        @break
                                    @case('user-check')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.5 7.25c0-2.9 3.5-4.75 5.5-4.75 1.05 0 2.42.51 3.55 1.36a4.5 4.5 0 0 0-.05 4.64c-1 .3-2.2.5-3.5.5-2.9 0-5.5-.85-5.5-1.75ZM17.03 12.03a.75.75 0 0 0-1.06-1.06l-2.72 2.72-1.22-1.22a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.06 0l3.25-3.25Z" clip-rule="evenodd"/></svg>
                                        @break
                                    @case('calendar')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd"/></svg>
                                        @break
                                    @case('briefcase')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path fill-rule="evenodd" d="M7.5 5.5A2.5 2.5 0 0 1 10 3h0a2.5 2.5 0 0 1 2.5 2.5V6h3A1.5 1.5 0 0 1 17 7.5v7A1.5 1.5 0 0 1 15.5 16h-11A1.5 1.5 0 0 1 3 14.5v-7A1.5 1.5 0 0 1 4.5 6h3v-.5ZM9 6h2v-.5a1 1 0 0 0-1-1h0a1 1 0 0 0-1 1V6Z" clip-rule="evenodd"/></svg>
                                        @break
                                    @default
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path fill-rule="evenodd" d="M16.704 5.29a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L4.296 9.5a.75.75 0 1 1 1.06-1.06l3.567 3.566 6.72-6.72a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                                @endswitch
                            </span>
                            <div>
                                <p class="text-base font-extrabold leading-none text-slate-950">
                                    {{ data_get($statistics, $stat['key'], '-') }}{{ $stat['suffix'] }}
                                </p>
                                <p class="mt-1 text-[11px] font-medium leading-none text-slate-500">{{ $stat['label'] }}</p>
                            </div>
                        </div>
                    @endforeach
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"/></svg>
                                    @break
                                @case('sprout')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path d="M10 2a6 6 0 0 0-6 6c0 3.5 3 6.5 6 10 3-3.5 6-6.5 6-10a6 6 0 0 0-6-6Zm0 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"/></svg>
                                    @break
                                @default
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path d="M4 2.75A.75.75 0 0 1 4.75 2h1.5a.75.75 0 0 1 0 1.5H5.5v13a.75.75 0 0 1-1.5 0v-13.75ZM6.5 4h8.086a1 1 0 0 1 .707 1.707L13 8l2.293 2.293A1 1 0 0 1 14.586 12H6.5V4Z"/></svg>
                            @endswitch
                        </span>
                        <h3 class="mt-4 font-bold text-slate-950">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ JURUSAN (carousel) ============ --}}
        {{-- Konten statis di atas ($jurusanList) — belum ada model Major/Jurusan.
             Kalau mau dinamis dari admin panel, tinggal bilang, saya bikinin migration + CRUD-nya. --}}
        <section id="jurusan" class="bg-[#eef4f6] px-5 py-16 lg:px-8">
            <div class="mx-auto max-w-5xl text-center">
                <h2 class="text-2xl font-extrabold text-slate-950">JURUSAN</h2>
                <p class="mx-auto mt-2 max-w-xl text-sm text-slate-500">
                    Kisah sukses para alumni yang telah berkiprah di dunia industri dan perguruan tinggi ternama.
                </p>
            </div>

            <div class="relative mx-auto mt-10 max-w-5xl">
                <div id="jurusan-track" class="jurusan-track flex gap-5 overflow-x-auto scroll-smooth px-1 pb-2">
                    @foreach ($jurusanList as $jurusan)
                        <article class="w-72 shrink-0 overflow-hidden rounded-2xl bg-white shadow-md">
                            <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br {{ $jurusan['accent'] }}">
                                <span class="text-4xl font-black tracking-tight text-white/90">{{ $jurusan['code'] }}</span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-950">{{ $jurusan['code'] }}</h3>
                                <p class="mt-0.5 text-xs font-semibold text-lime-600">{{ $jurusan['name'] }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $jurusan['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Dot indicator --}}
                <div class="mt-6 flex justify-center gap-2">
                    @foreach ($jurusanList as $i => $jurusan)
                        <button type="button" data-jurusan-dot="{{ $i }}" class="h-2 w-2 rounded-full bg-slate-300 transition data-[active=true]:w-5 data-[active=true]:bg-slate-950" @if ($i === 0) data-active="true" @endif></button>
                    @endforeach
                </div>
            </div>
        </section>
    {{-- Konten statis ($ekskulList) — belum ada model Extracurricular di database. --}}
    <section id="ekskul" class="bg-slate-50 px-5 py-16 lg:px-8">
        <div class="mx-auto max-w-5xl text-center">
            <h2 class="text-2xl font-extrabold text-slate-950">Ekstrakulikuler</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm text-slate-500">Kurikulum yang disinkronisasi dengan kebutuhan dunia usaha dan dunia industri (DUDI).</p>
        </div>

        <div class="mx-auto mt-8 grid max-w-5xl gap-5 sm:grid-cols-[240px_1fr]" id="ekskul-wrapper" data-active="0">
            <div class="flex flex-col gap-2">
                @foreach ($ekskulList as $i => $ekskul)
                    <button type="button" data-ekskul-btn="{{ $i }}"
                            class="ekskul-btn flex items-center gap-3 rounded-xl border px-4 py-3 text-left transition {{ $i === 0 ? 'border-slate-950 bg-white shadow-sm' : 'border-transparent hover:bg-white' }}">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            @switch($ekskul['icon'])
                                @case('flag')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path d="M4 2.75A.75.75 0 0 1 4.75 2h1.5a.75.75 0 0 1 0 1.5H5.5v13a.75.75 0 0 1-1.5 0v-13.75ZM6.5 4h8.086a1 1 0 0 1 .707 1.707L13 8l2.293 2.293A1 1 0 0 1 14.586 12H6.5V4Z"/></svg>
                                    @break
                                @case('ball')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13.25a.75.75 0 0 0-1.5 0v2.69L6.7 6.01a.75.75 0 1 0-.9 1.2l2.7 2.03v1.52l-2.7 2.03a.75.75 0 1 0 .9 1.2l2.55-1.92v2.69a.75.75 0 0 0 1.5 0v-2.69l2.55 1.92a.75.75 0 1 0 .9-1.2l-2.7-2.03v-1.52l2.7-2.03a.75.75 0 1 0-.9-1.2l-2.55 1.92V4.75Z" clip-rule="evenodd"/></svg>
                                    @break
                                @case('music')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path d="M15.5 2.672a.75.75 0 0 1 .5.707V4.5l.001.041a.75.75 0 0 1-.5.707l-6.482 2.16a1 1 0 0 0-.685.949v8.394a2.75 2.75 0 1 1-1.5-2.452V6.86a1 1 0 0 1 .685-.949l7.198-2.4a.75.75 0 0 1 .783.16Z"/></svg>
                                    @break
                                @default
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4.5 w-4.5"><path d="M7 4a3 3 0 0 1 6 0v6a3 3 0 1 1-6 0V4Z"/><path d="M5.5 9.643a.75.75 0 0 0-1.5 0V10c0 3.06 2.29 5.585 5.25 5.954V17.5h-1.5a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-1.5v-1.546A6.001 6.001 0 0 0 16 10v-.357a.75.75 0 0 0-1.5 0V10a4.5 4.5 0 0 1-9 0v-.357Z"/></svg>
                            @endswitch
                        </span>
                        <span>
                            <span class="block text-sm font-bold text-slate-950">{{ $ekskul['name'] }}</span>
                            <span class="block text-xs text-slate-500">{{ $ekskul['tagline'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="relative min-h-[280px] overflow-hidden rounded-2xl bg-slate-900">
                @foreach ($ekskulList as $i => $ekskul)
                    <div data-ekskul-panel="{{ $i }}" class="absolute inset-0 flex flex-col justify-end p-6 text-white transition-opacity duration-300 {{ $i === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        <span class="relative mb-24 text-2xl font-extrabold">{{ $ekskul['name'] }}</span>
                        <p class="relative max-w-md text-sm leading-6 text-slate-200">{{ $ekskul['desc'] }}</p>
                        <a href="#" class="relative mt-4 inline-flex w-max items-center gap-1.5 rounded-full bg-white px-4 py-2 text-xs font-bold text-slate-950 hover:bg-slate-100">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ MITRA INDUSTRI ============ --}}
    {{-- Konten statis ($industryPartners) — belum ada model IndustryPartner di database. --}}
    <section id="mitra" class="bg-[#eef4f6] px-5 py-14 text-center lg:px-8">
        <h2 class="text-lg font-extrabold text-slate-950">Mitra Industri Kami</h2>
        <div class="mx-auto mt-6 flex max-w-3xl flex-wrap items-center justify-center gap-8">
            @foreach ($industryPartners as $partner)
                <span class="text-3xl font-black tracking-tight text-slate-800">
                    <span class="rounded bg-red-600 px-1.5 py-0.5 text-white">U</span>{{ Str::after($partner, 'U') }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- ============ PRESTASI ============ --}}
    {{-- Konten statis ($achievementList/$featuredAchievement) — belum ada model Achievement di database. --}}
    <section id="prestasi" class="mx-auto max-w-5xl px-5 py-16 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-950">Prestasi yang terus tumbuh</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm text-slate-500">Deretan penghargaan siswa SMKN 2 Kota Mojokerto di ajang lokal, nasional, hingga internasional.</p>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_1fr]">
            <div class="relative overflow-hidden rounded-2xl bg-slate-200">
                @if ($achievementImage = $imageUrl(data_get($galleries->get(1), 'image')))
                    <img src="{{ $achievementImage }}" alt="{{ $featuredAchievement['title'] }}" class="absolute inset-0 h-full w-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/10 to-transparent"></div>
                <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1 text-xs font-bold text-slate-950">🏆 Juara 1</span>
                <div class="relative flex min-h-[280px] flex-col justify-end p-6 text-white">
                    <h3 class="text-lg font-bold leading-snug">{{ $featuredAchievement['title'] }}</h3>
                    <p class="mt-1 text-xs text-slate-200">{{ $featuredAchievement['author'] }}</p>
                </div>
            </div>

            <ol class="relative space-y-6 border-l border-slate-200 pl-6">
                @foreach ($achievementList as $achievement)
                    <li class="relative">
                        <span class="absolute -left-[27px] top-1 h-3 w-3 rounded-full border-2 border-white bg-slate-950"></span>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $achievement['date'] }}</p>
                        <p class="mt-0.5 font-bold text-slate-950">{{ $achievement['title'] }}</p>
                        <p class="text-sm text-slate-500">{{ $achievement['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <div class="mt-8 text-center">
            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 hover:text-blue-700">
                Lihat semua prestasi
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
            </a>
        </div>
    </section>

    {{-- ============ BERITA TERBARU ============ --}}
    {{-- Konten statis ($newsList/$featuredNews) — belum ada model News/Post di database. --}}
    <section id="berita" class="bg-slate-50 px-5 py-16 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-950">Berita terbaru</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm text-slate-500">Ikuti terus informasi dan berita-berita terbaru tentang {{ $schoolName }}.</p>
        </div>

        <div class="mx-auto mt-6 flex max-w-5xl flex-wrap justify-center gap-2">
            @foreach ($newsCategories as $i => $category)
                <button type="button" class="news-tab-btn rounded-full px-4 py-1.5 text-xs font-semibold transition {{ $i === 0 ? 'bg-slate-950 text-white' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <div class="mx-auto mt-8 grid max-w-5xl gap-5 sm:grid-cols-[1fr_1fr]">
            <a href="#" class="flex flex-col justify-end rounded-2xl bg-blue-600 p-6 text-white transition hover:bg-blue-700">
                <span class="mb-3 w-max rounded-full bg-amber-400 px-3 py-1 text-[11px] font-bold text-slate-950">{{ $featuredNews['badge'] }}</span>
                <h3 class="text-lg font-bold leading-snug">{{ $featuredNews['title'] }}</h3>
                <p class="mt-3 flex items-center gap-1.5 text-xs text-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Z" clip-rule="evenodd"/></svg>
                    {{ $featuredNews['date'] }}
                </p>
            </a>

            <div class="flex flex-col gap-5">
                @foreach ($newsList as $news)
                    <a href="#" class="flex-1 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 transition hover:shadow-md">
                        <span class="w-max rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-500">{{ $news['badge'] }}</span>
                        <h3 class="mt-2 text-sm font-bold leading-snug text-slate-950">{{ $news['title'] }}</h3>
                        <p class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Z" clip-rule="evenodd"/></svg>
                            {{ $news['date'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    </main>

    <script>
        // Carousel Jurusan: klik dot buat geser ke card yang sesuai
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('jurusan-track');
            if (!track) return;

            const cards = Array.from(track.children);
            const dots = Array.from(document.querySelectorAll('[data-jurusan-dot]'));

            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    cards[i]?.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
                });
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const index = cards.indexOf(entry.target);
                    dots.forEach((dot, i) => dot.dataset.active = i === index ? 'true' : 'false');
                });
            }, { root: track, threshold: 0.6 });

            cards.forEach((card) => observer.observe(card));
        });

        // Tab Ekstrakulikuler: klik nama di sidebar -> ganti panel gambar kanan
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('[data-ekskul-btn]');
            const panels = document.querySelectorAll('[data-ekskul-panel]');

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const index = btn.dataset.ekskulBtn;

                    buttons.forEach((b) => b.classList.remove('border-slate-950', 'bg-white', 'shadow-sm'));
                    buttons.forEach((b) => b.classList.add('border-transparent'));
                    btn.classList.add('border-slate-950', 'bg-white', 'shadow-sm');
                    btn.classList.remove('border-transparent');

                    panels.forEach((p) => {
                        const active = p.dataset.ekskulPanel === index;
                        p.classList.toggle('opacity-100', active);
                        p.classList.toggle('opacity-0', !active);
                        p.classList.toggle('pointer-events-none', !active);
                    });
                });
            });
        });

        // Tab kategori Berita: cuma toggle tampilan aktif (belum filter data beneran)
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.news-tab-btn');
            tabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    tabs.forEach((t) => {
                        t.classList.remove('bg-slate-950', 'text-white');
                        t.classList.add('bg-slate-200', 'text-slate-600');
                    });
                    tab.classList.remove('bg-slate-200', 'text-slate-600');
                    tab.classList.add('bg-slate-950', 'text-white');
                });
            });
        });
    </script>

    <footer id="kontak" class="bg-gradient-to-b from-slate-900 to-slate-950 px-5 pt-14 text-slate-400 lg:px-8">
        <div class="mx-auto grid max-w-6xl gap-10 pb-10 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-2">
                    @if ($logo = $imageUrl(data_get($profile, 'school_logo')))
                        <img src="{{ $logo }}" alt="{{ $schoolName }}" class="h-9 w-9 rounded-full object-cover">
                    @else
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-lime-400 text-sm font-bold text-slate-950">{{ strtoupper(substr($schoolName, 0, 1)) }}</span>
                    @endif
                    <span class="text-sm font-bold text-white">{{ $schoolName }}</span>
                </div>
                <p class="mt-4 text-xs leading-6">Kami Siap Melayani Masyarakat Pendidikan Dan Pembelajaran Berbasis Budaya Karya, Disiplin Dan Berprestasi.</p>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-slate-300">Menu Utama</p>
                <ul class="mt-3 space-y-2 text-xs">
                    <li><a href="#beranda" class="hover:text-white">Beranda</a></li>
                    <li><a href="#profil" class="hover:text-white">Tentang Kami</a></li>
                    <li><a href="#jurusan" class="hover:text-white">Profil Jurusan</a></li>
                    <li><a href="#ppdb" class="hover:text-white">PPDB</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-slate-300">Sosmed Kami</p>
                <div class="mt-3 flex gap-2">
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 hover:bg-white/20" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878V12.89h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10Z" clip-rule="evenodd"/></svg>
                    </a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 hover:bg-white/20" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M10 2c-2.174 0-2.445.01-3.298.048-.851.04-1.433.174-1.942.372a3.916 3.916 0 0 0-1.417.923c-.445.444-.72.89-.923 1.417-.198.51-.333 1.09-.372 1.942C2.01 7.555 2 7.827 2 10s.01 2.445.048 3.298c.04.851.174 1.433.372 1.942.203.526.478.973.923 1.417.444.445.89.72 1.417.923.51.198 1.09.333 1.942.372C7.555 17.99 7.827 18 10 18s2.445-.01 3.298-.048c.851-.04 1.433-.174 1.942-.372a3.916 3.916 0 0 0 1.417-.923c.445-.444.72-.89.923-1.417.198-.51.333-1.09.372-1.942C17.99 12.445 18 12.173 18 10s-.01-2.445-.048-3.298c-.04-.851-.174-1.433-.372-1.942a3.916 3.916 0 0 0-.923-1.417 3.916 3.916 0 0 0-1.417-.923c-.51-.198-1.09-.333-1.942-.372C12.445 2.01 12.173 2 10 2Zm0 1.802c2.137 0 2.39.008 3.233.046.78.036 1.203.166 1.485.276.373.145.64.318.92.598.28.28.453.546.598.92.11.281.24.704.276 1.485.038.843.046 1.096.046 3.233s-.008 2.39-.046 3.233c-.036.78-.166 1.203-.276 1.485a2.474 2.474 0 0 1-.598.92c-.28.28-.546.453-.92.598-.282.11-.705.24-1.485.276-.843.038-1.096.046-3.233.046s-2.39-.008-3.233-.046c-.78-.036-1.203-.166-1.485-.276a2.474 2.474 0 0 1-.92-.598 2.474 2.474 0 0 1-.598-.92c-.11-.282-.24-.705-.276-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.39.046-3.233c.036-.78.166-1.203.276-1.485.145-.373.318-.64.598-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.843-.038 1.096-.046 3.233-.046Z" clip-rule="evenodd"/><path d="M10 6.541a3.459 3.459 0 1 0 0 6.918 3.459 3.459 0 0 0 0-6.918Zm0 5.708a2.25 2.25 0 1 1 0-4.5 2.25 2.25 0 0 1 0 4.5ZM13.605 6.404a.808.808 0 1 1-1.616 0 .808.808 0 0 1 1.616 0Z"/></svg>
                    </a>
                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 hover:bg-white/20" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M13.5 2h-2.2v10.8a2.2 2.2 0 1 1-1.8-2.16V8.6a4.4 4.4 0 1 0 4 4.38V7.3a5.6 5.6 0 0 0 3 .87V6a3.4 3.4 0 0 1-3-4Z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-slate-300">Alamat</p>
                <div class="mt-3 overflow-hidden rounded-lg">
                    <iframe
                        title="Lokasi {{ $schoolName }}"
                        src="https://www.google.com/maps?q={{ urlencode($schoolName) }}&output=embed"
                        class="h-32 w-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 py-5">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 text-xs sm:flex-row">
                <p>&copy; {{ now()->year }} {{ $schoolName }}. Hak Cipta Dilindungi.</p>
                <p>0331 387356 &nbsp;•&nbsp; {{ Str::slug($schoolName, '') }}@mojokerto.gmail.com</p>
            </div>
        </div>
    </footer>
</body>
</html>
