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
        $galleries = data_get($home, 'galleries', []);
        $schoolName = data_get($profile, 'school_name', data_get($hero, 'school_name', 'Sekolah'));
        $imageUrl = fn ($path) => $path && filter_var($path, FILTER_VALIDATE_URL) ? $path : ($path ? Storage::url($path) : null);
    @endphp

    <header class="fixed inset-x-0 top-0 z-20 border-b border-white/10 bg-slate-950/90 text-white backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
            <a href="#beranda" class="text-lg font-bold tracking-tight">{{ $schoolName }}</a>
            <div class="hidden gap-6 text-sm text-slate-300 md:flex"><a href="#profil" class="hover:text-white">Profil</a><a href="#jurusan" class="hover:text-white">Program</a><a href="#statistik" class="hover:text-white">Statistik</a><a href="#galeri" class="hover:text-white">Galeri</a><a href="#kontak" class="hover:text-white">Kontak</a></div>
        </nav>
    </header>

    <main>
        <section id="beranda" class="relative flex min-h-[78vh] items-center overflow-hidden bg-slate-950 px-5 py-32 text-white lg:px-8">
            @if ($background = $imageUrl(data_get($hero, 'background_image')))<img src="{{ $background }}" alt="{{ $schoolName }}" class="absolute inset-0 h-full w-full object-cover opacity-35">@endif
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-slate-900/40"></div>
            <div class="relative mx-auto w-full max-w-7xl"><p class="mb-5 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-300">{{ $schoolName }}</p><h1 class="max-w-3xl text-4xl font-bold leading-tight sm:text-6xl">{{ data_get($hero, 'title', 'Membangun Generasi Unggul dan Berakhlak Mulia') }}</h1><p class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-300">{{ data_get($hero, 'description', 'Pendidikan vokasi yang menghubungkan kompetensi, karakter, dan kebutuhan industri.') }}</p><a href="#profil" class="mt-8 inline-block bg-cyan-400 px-6 py-3 font-semibold text-slate-950 hover:bg-cyan-300">Kenali Sekolah Kami</a></div>
        </section>

        <section id="profil" class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-2 lg:px-8"><div>@if ($photo = $imageUrl(data_get($profile, 'principal_photo')))<img src="{{ $photo }}" alt="{{ data_get($profile, 'principal_name', 'Kepala Sekolah') }}" class="aspect-[4/3] w-full object-cover">@endif</div><div class="self-center"><p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Sambutan Kepala Sekolah</p><h2 class="mt-3 text-3xl font-bold text-slate-950">Pendidikan vokasi untuk masa depan yang nyata.</h2><p class="mt-5 leading-8 text-slate-600">{{ data_get($profile, 'welcome_message', 'Selamat datang di website resmi sekolah kami.') }}</p><p class="mt-6 font-semibold text-slate-950">{{ data_get($profile, 'principal_name', 'Kepala Sekolah') }}</p><p class="text-sm text-cyan-700">{{ data_get($profile, 'principal_position', 'Kepala Sekolah') }}</p></div></section>

        <section id="statistik" class="bg-slate-900 px-5 py-16 text-white lg:px-8"><div class="mx-auto grid max-w-7xl grid-cols-2 gap-8 md:grid-cols-4">@foreach ([['total_students', 'Siswa Aktif'], ['total_teachers', 'Guru dan Staf'], ['established_year', 'Tahun Berdiri'], ['total_alumni', 'Alumni']] as [$key, $label])<div><p class="text-3xl font-bold text-cyan-300">{{ data_get($statistics, $key, '-') }}</p><p class="mt-2 text-sm text-slate-400">{{ $label }}</p></div>@endforeach</div></section>

        <section id="jurusan" class="mx-auto max-w-7xl px-5 py-20 lg:px-8"><p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Program Keahlian</p><h2 class="mt-3 text-3xl font-bold text-slate-950">Kompetensi yang relevan dengan industri</h2><div class="mt-10 grid gap-5 md:grid-cols-3">@foreach (['Rekayasa Perangkat Lunak', 'Teknik Komputer dan Jaringan', 'Desain Komunikasi Visual'] as $major)<article class="border border-slate-200 bg-white p-6 shadow-sm"><h3 class="font-bold text-slate-950">{{ $major }}</h3><p class="mt-3 text-sm leading-6 text-slate-600">Pembelajaran terapan dengan proyek dan keterampilan yang siap digunakan.</p></article>@endforeach</div></section>

        @if (count($galleries))<section id="galeri" class="bg-slate-100 px-5 py-20 lg:px-8"><div class="mx-auto max-w-7xl"><p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Dokumentasi</p><h2 class="mt-3 text-3xl font-bold text-slate-950">Kegiatan sekolah</h2><div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">@foreach ($galleries as $gallery)<figure class="overflow-hidden bg-white">@if ($image = $imageUrl(data_get($gallery, 'image')))<img src="{{ $image }}" alt="{{ data_get($gallery, 'title', 'Galeri sekolah') }}" class="aspect-square w-full object-cover">@endif<figcaption class="p-4 text-sm font-semibold">{{ data_get($gallery, 'title') }}</figcaption></figure>@endforeach</div></div></section>@endif
    </main>
    <footer id="kontak" class="bg-slate-950 px-5 py-10 text-slate-400 lg:px-8"><div class="mx-auto max-w-7xl"><p class="font-semibold text-white">{{ $schoolName }}</p><p class="mt-2 text-sm">Informasi profil dan fasilitas sekolah.</p></div></footer>
</body>
</html>