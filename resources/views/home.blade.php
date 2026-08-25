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

            {{-- Filmstrip foto kegiatan --}}
            @if ($galleries->count())
                <div class="relative mt-14 flex justify-center gap-3 overflow-x-auto px-5 pb-2 [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)] sm:gap-4">
                    @foreach ($galleries->take(9) as $i => $gallery)
                        <div class="shrink-0 overflow-hidden rounded-lg shadow-xl ring-1 ring-white/10 transition hover:z-10 hover:scale-105 hover:rotate-0"
                             style="transform: rotate({{ $i % 2 === 0 ? -4 : 4 }}deg) translateY({{ $i % 3 === 0 ? '6px' : '0px' }});">
                            @if ($image = $imageUrl(data_get($gallery, 'image')))
                                <img src="{{ $image }}" alt="{{ data_get($gallery, 'title', 'Kegiatan sekolah') }}" class="h-24 w-20 object-cover sm:h-28 sm:w-24">
                            @endif
                        </div>
                    @endforeach
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
    </main>

    <footer id="kontak" class="bg-slate-950 px-5 py-10 text-slate-400 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="font-semibold text-white">{{ $schoolName }}</p>
            <p class="mt-2 text-sm">Informasi profil dan fasilitas sekolah.</p>
        </div>
    </footer>
</body>
</html>
