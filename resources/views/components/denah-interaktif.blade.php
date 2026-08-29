{{-- ============ DENAH INTERAKTIF SEKOLAH (MENGGUNAKAN GAMBAR ASLI & BISA DIKLIK PER RUANG/KELAS) ============ --}}
<section id="denah" class="relative z-10 py-16 px-4 sm:px-6 lg:px-8 bg-[#f2f7fc]" x-data="denahInteraktif()">
    <div class="mx-auto w-full max-w-[1280px]">
        
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-black text-[#102a43] tracking-tight">
                Denah Interaktif
            </h2>
            <p class="mt-3 text-sm sm:text-base text-slate-500 font-normal leading-relaxed">
                Jelajahi denah sekolah kami dan temukan berbagai ruang serta fasilitas dengan mudah.
            </p>
        </div>

        {{-- Main Outer Card Container (White Card with Large Rounded Corners & Soft Shadow) --}}
        <div class="bg-white rounded-3xl sm:rounded-[32px] border border-slate-100 shadow-xl shadow-slate-200/50 p-5 sm:p-7 lg:p-9 space-y-6">
            
            {{-- Top Section: Left Sidebar, Center Map & Search, Right Info Panel --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                {{-- 1. Left Sidebar: Filter Categories (lg:col-span-2) --}}
                <div class="lg:col-span-2 flex lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0 scrollbar-none">
                    <template x-for="cat in categories" :key="cat.name">
                        <button 
                            type="button"
                            @click="setCategory(cat.name)"
                            :class="activeCategory === cat.name 
                                ? 'bg-[#152e4d] text-white shadow-md shadow-slate-900/10 font-bold' 
                                : 'bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-semibold border border-slate-100'"
                            class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs sm:text-[13px] whitespace-nowrap transition-all duration-200 text-left w-full">
                            <span class="text-sm opacity-90" x-html="cat.icon"></span>
                            <span x-text="cat.name"></span>
                        </button>
                    </template>
                </div>

                {{-- 2. Center: Search Bar + Interactive Photo Map (lg:col-span-6) --}}
                <div class="lg:col-span-6 flex flex-col space-y-3.5">
                    
                    {{-- Search Input --}}
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            placeholder="Cari ruangan atau fasilitas..." 
                            class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-xs sm:text-[13px] text-slate-800 placeholder-slate-400 focus:border-[#152e4d] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#152e4d]/10 transition"
                        />
                        <button 
                            x-show="searchQuery.length > 0" 
                            @click="searchQuery = ''"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Map View Container with Exact Map Graphic & Clickable Room Hotspots --}}
                    <div class="relative w-full aspect-[16/10] sm:aspect-[16/9.5] rounded-2xl border border-slate-200/90 bg-[#ebf3f9] overflow-hidden select-none shadow-sm">
                        
                        {{-- Exact High Resolution Map Background --}}
                        <img 
                            src="{{ asset('images/denah-map.png') }}" 
                            alt="Denah SMKN 2 Kota Mojokerto" 
                            class="absolute inset-0 w-full h-full object-cover object-center pointer-events-none"
                        />

                        {{-- Active Dynamic Route Overlay Path (When Route Search is Active) --}}
                        <svg x-show="showRoute && currentRoutePath" class="absolute inset-0 w-full h-full pointer-events-none z-20">
                            {{-- Route Shadow / Glow --}}
                            <path :d="currentRoutePath" fill="none" stroke="#60a5fa" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" opacity="0.6" />
                            {{-- Route Solid Line --}}
                            <path :d="currentRoutePath" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            {{-- Start Circle --}}
                            <circle cx="39%" cy="98%" r="6" fill="#ffffff" stroke="#2563eb" stroke-width="3" />
                            {{-- Target Pin Circle --}}
                            <circle cx="53%" cy="34%" r="9" fill="#ffffff" stroke="#2563eb" stroke-width="4" />
                            <circle cx="53%" cy="34%" r="3.5" fill="#2563eb" />
                        </svg>

                        {{-- Interactive Clickable Hotspots & Pins for EVERY Class & Room --}}
                        <template x-for="item in filteredFacilities" :key="item.id">
                            <button
                                type="button"
                                @click="selectFacility(item)"
                                :style="`left: ${item.coords.x}%; top: ${item.coords.y}%;`"
                                :class="selectedFacility && selectedFacility.id === item.id 
                                    ? 'scale-125 z-30 ring-4 ring-sky-400 bg-[#152e4d] text-white shadow-xl' 
                                    : 'scale-90 z-10 bg-white/95 text-[#152e4d] hover:scale-110 hover:bg-[#152e4d] hover:text-white shadow-md border border-slate-300'"
                                class="absolute -translate-x-1/2 -translate-y-1/2 flex items-center justify-center h-5 w-5 sm:h-6 sm:w-6 rounded-full transition-all duration-200 group cursor-pointer"
                                :title="item.nama"
                            >
                                <span class="text-[9px] sm:text-[10px] font-black" x-text="item.icon || '📍'"></span>
                                
                                {{-- Tooltip on Hover --}}
                                <span class="absolute bottom-full mb-1.5 hidden group-hover:block whitespace-nowrap rounded-md bg-slate-900 px-2 py-1 text-[10px] font-semibold text-white shadow-lg z-40 pointer-events-none">
                                    <span x-text="item.nama"></span>
                                </span>
                            </button>
                        </template>

                    </div>

                </div>

                {{-- 3. Right Detail Panel: "Tujuan Anda" (lg:col-span-4) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-100 p-5 space-y-4 flex flex-col justify-between min-h-[420px]">
                    
                    <div class="space-y-3.5">
                        {{-- Top Pill Badge: "Tujuan Anda" --}}
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-[#103b60] text-white px-3.5 py-1 text-xs font-bold tracking-wide shadow-sm">
                                Tujuan Anda
                            </span>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800" x-text="selectedFacility.kategori"></span>
                        </div>

                        {{-- Facility Title & Subtitle --}}
                        <div>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight" x-text="selectedFacility.nama"></h3>
                            <p class="text-sm font-bold text-[#1d5fb3] mt-0.5" x-text="selectedFacility.lokasi"></p>
                        </div>

                        {{-- Room Visual Graphic Container (Persis Desain Kotak di Mockup) --}}
                        <div class="rounded-2xl border border-slate-100 bg-[#edf5fc] p-3.5 shadow-inner space-y-2.5">
                            {{-- Top Header Placeholder --}}
                            <div class="h-4 rounded-md bg-white/70 w-full"></div>
                            
                            {{-- 4 Dark Navy Blocks --}}
                            <div class="grid grid-cols-4 gap-2">
                                <div class="h-9 rounded-lg bg-[#193a5e] shadow-sm flex items-center justify-center text-white text-[10px] font-bold">
                                    <span x-text="selectedFacility.kategori.substring(0, 3).toUpperCase()"></span>
                                </div>
                                <div class="h-9 rounded-lg bg-[#193a5e] shadow-sm flex items-center justify-center text-white text-[10px] font-bold">
                                    <span>SMK2</span>
                                </div>
                                <div class="h-9 rounded-lg bg-[#193a5e] shadow-sm flex items-center justify-center text-white text-[10px] font-bold">
                                    <span>2.0</span>
                                </div>
                                <div class="h-9 rounded-lg bg-[#193a5e] shadow-sm flex items-center justify-center text-white text-[10px] font-bold">
                                    <span>✦</span>
                                </div>
                            </div>
                            
                            {{-- 4 Light Blue Pill Bars --}}
                            <div class="grid grid-cols-4 gap-2">
                                <div class="h-3 rounded-full bg-[#9bc3ea]"></div>
                                <div class="h-3 rounded-full bg-[#9bc3ea]"></div>
                                <div class="h-3 rounded-full bg-[#9bc3ea]"></div>
                                <div class="h-3 rounded-full bg-[#9bc3ea]"></div>
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal" x-text="selectedFacility.deskripsi"></p>

                        {{-- Info Details Table --}}
                        <div class="border-t border-slate-100 pt-3 space-y-2 text-xs">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                    <span>✦</span> Lokasi
                                </span>
                                <span class="text-slate-800 font-semibold text-right" x-text="selectedFacility.lokasi"></span>
                            </div>
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                    <span>▣</span> Fungsi
                                </span>
                                <span class="text-slate-800 font-semibold text-right" x-text="selectedFacility.fungsi"></span>
                            </div>
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                    <span>🕒</span> Jam Operasional
                                </span>
                                <span class="text-slate-800 font-semibold text-right" x-text="selectedFacility.jam_operasional"></span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <a href="#jurusan" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#103b60] hover:bg-[#1a56db] text-white py-2.5 px-4 text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all mt-2">
                        <span>Lihat Fasilitas Lengkap</span>
                        <span>→</span>
                    </a>

                </div>

            </div>

            {{-- Bottom Row 1: "Cari rute ke ruangan" --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 flex flex-col lg:flex-row items-center justify-between gap-4 shadow-sm">
                
                {{-- Title --}}
                <div class="flex items-center gap-2 text-slate-900 font-bold text-sm shrink-0 w-full lg:w-auto">
                    <span class="text-[#103b60]">✦</span>
                    <span>Cari rute ke ruangan</span>
                </div>

                {{-- Dropdowns & Button --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-1 max-w-2xl">
                    
                    {{-- Dari --}}
                    <div class="w-full sm:w-1/2">
                        <label class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Dari</label>
                        <select x-model="routeFrom" class="w-full rounded-xl border border-slate-200 bg-white py-2 px-3 text-xs text-slate-800 focus:border-[#103b60] focus:outline-none shadow-sm">
                            <template x-for="item in allFacilities" :key="item.id">
                                <option :value="item.id" x-text="item.nama"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Tujuan --}}
                    <div class="w-full sm:w-1/2">
                        <label class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Tujuan</label>
                        <select x-model="routeTo" class="w-full rounded-xl border border-slate-200 bg-white py-2 px-3 text-xs text-slate-800 focus:border-[#103b60] focus:outline-none shadow-sm">
                            <template x-for="item in allFacilities" :key="item.id">
                                <option :value="item.id" x-text="item.nama"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Tampilkan Rute Button --}}
                    <div class="w-full sm:w-auto self-end">
                        <button 
                            type="button" 
                            @click="calculateRoute()" 
                            class="w-full sm:w-auto whitespace-nowrap rounded-xl bg-[#103b60] hover:bg-[#1a56db] text-white px-5 py-2 text-xs font-bold shadow-md hover:shadow-lg transition">
                            Tampilkan Rute
                        </button>
                    </div>

                </div>

                {{-- Route Stats Info --}}
                <div x-show="showRoute" class="text-xs text-slate-600 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-100 shadow-sm shrink-0">
                    <p class="font-bold text-[#103b60]" x-text="routeStatsTitle"></p>
                    <p class="text-[11px] text-slate-500" x-text="routeStatsTime"></p>
                </div>

            </div>

            {{-- Bottom Row 2: Baris Chip Cepat Fasilitas Populer (Persis Mockup) --}}
            <div class="flex items-center gap-2.5 overflow-x-auto pb-2 scrollbar-none">
                <template x-for="chip in quickChips" :key="chip.id">
                    <button 
                        type="button"
                        @click="selectFacilityById(chip.id)"
                        :class="selectedFacility && selectedFacility.id === chip.id 
                            ? 'bg-[#ebf4fd] border-[#b9d9f9] text-[#103b60] font-bold' 
                            : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold'"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs shadow-sm transition whitespace-nowrap">
                        <span x-text="chip.icon"></span>
                        <span x-text="chip.name"></span>
                    </button>
                </template>
                <button 
                    type="button"
                    @click="setCategory('Semua')"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-[#103b60] hover:text-[#1a56db] transition whitespace-nowrap">
                    <span>⋯ Lainnya</span>
                    <span>→</span>
                </button>
            </div>

            {{-- Bottom Row 3: Help Note Footer --}}
            <div class="pt-2 text-center text-xs text-slate-500 font-medium">
                Butuh bantuan menemukan lokasi? Kami siap membantumu menemukan ruang atau fasilitas yang kamu cari.
            </div>

        </div>

    </div>
</section>

{{-- Alpine.js State Logic for Interactive Map --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('denahInteraktif', () => ({
            activeCategory: 'Semua',
            searchQuery: '',
            routeFrom: 'gerbang_utama',
            routeTo: 'lab_rpl_1',
            showRoute: true,
            routeStatsTitle: '✦ Jarak: ± 45 meter',
            routeStatsTime: 'Estimasi waktu: 1 menit',
            currentRoutePath: 'M 390 530 Q 380 430 460 410 T 530 240',

            categories: [
                { name: 'Semua', icon: '⊞' },
                { name: 'Kelas', icon: '🏠' },
                { name: 'Lab', icon: '💻' },
                { name: 'Fasilitas', icon: '🏛️' },
                { name: 'Kantor', icon: '🏢' },
                { name: 'Lapangan', icon: '⚽' },
                { name: 'Lainnya', icon: '⋯' }
            ],

            quickChips: [
                { id: 'lab_rpl_1', name: 'Lab Komputer (RPL)', icon: '▣' },
                { id: 'perpustakaan', name: 'Perpustakaan', icon: '📚' },
                { id: 'kantin', name: 'Kantin', icon: '🔵' },
                { id: 'lapangan', name: 'Lapangan', icon: '🔵' },
                { id: 'musholla', name: 'Mushola', icon: '🏠' },
                { id: 'uks', name: 'UKS', icon: '➕' }
            ],

            allFacilities: [
                // 1. LABS & SPECIAL ROOMS
                {
                    id: 'lab_rpl_1',
                    nama: 'Laboratorium RPL 1',
                    kategori: 'Lab',
                    icon: '💻',
                    coords: { x: 50.5, y: 34 },
                    deskripsi: 'Laboratorium praktik untuk siswa jurusan RPL. Digunakan untuk pembelajaran pemrograman, pengembangan web, dan jaringan.',
                    lokasi: 'Gedung B (RPL)',
                    fungsi: 'Laboratorium Komputer',
                    jam_operasional: '07.00 - 16.00 WIB'
                },
                {
                    id: 'lab_rpl_2',
                    nama: 'Laboratorium RPL 2',
                    kategori: 'Lab',
                    icon: '💻',
                    coords: { x: 59.5, y: 34 },
                    deskripsi: 'Laboratorium komputer lanjutan untuk pengembangan aplikasi mobile, database, dan project-based learning.',
                    lokasi: 'Lantai 2 - Gedung B',
                    fungsi: 'Laboratorium Komputer & RPL',
                    jam_operasional: '07.00 - 16.00 WIB'
                },
                {
                    id: 'aula',
                    nama: 'Aula Serbaguna',
                    kategori: 'Fasilitas',
                    icon: '🏛️',
                    coords: { x: 55, y: 40 },
                    deskripsi: 'Ruang pertemuan akbar untuk seminar, workshop industri, dan kegiatan pertemuan guru serta wali murid.',
                    lokasi: 'Lantai 1 - Gedung B',
                    fungsi: 'Pertemuan & Seminar',
                    jam_operasional: '07.00 - 17.00 WIB'
                },
                {
                    id: 'lab_kuliner',
                    nama: 'Lab Food & Kuliner (Tata Boga)',
                    kategori: 'Lab',
                    icon: '🍳',
                    coords: { x: 67.5, y: 53 },
                    deskripsi: 'Kitchen lab berstandar hotel berbintang untuk praktik memasak masakan nusantara, continental, bakery, dan pastry.',
                    lokasi: 'Gedung Kuliner Timur',
                    fungsi: 'Praktik Memasak & Tata Boga',
                    jam_operasional: '07.00 - 16.00 WIB'
                },
                {
                    id: 'lab_dkv',
                    nama: 'Studio Multimedia & Lab DKV',
                    kategori: 'Lab',
                    icon: '🎨',
                    coords: { x: 71.5, y: 53 },
                    deskripsi: 'Studio fotografi, podcast, editing video, dan animasi digital dengan perangkat PC spesifikasi tinggi.',
                    lokasi: 'Gedung DKV Timur',
                    fungsi: 'Desain Grafis & Multimedia',
                    jam_operasional: '07.00 - 16.00 WIB'
                },
                {
                    id: 'perpustakaan',
                    nama: 'Perpustakaan Sekolah',
                    kategori: 'Fasilitas',
                    icon: '📚',
                    coords: { x: 63.5, y: 53 },
                    deskripsi: 'Pusat literasi sekolah dengan ribuan koleksi buku referensi kejuruan, fiksi, dan ruang baca ber-AC.',
                    lokasi: 'Gedung Sayap Timur',
                    fungsi: 'Literasi & Peminjaman Buku',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'uks',
                    nama: 'Ruang UKS',
                    kategori: 'Fasilitas',
                    icon: '➕',
                    coords: { x: 67, y: 69 },
                    deskripsi: 'Unit Kesehatan Sekolah untuk penanganan medis awal, konsultasi gizi, dan istirahat siswa.',
                    lokasi: 'Gedung Layanan Siswa',
                    fungsi: 'Layanan Kesehatan',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'bk',
                    nama: 'Ruang Bimbingan Konseling (BK)',
                    kategori: 'Kantor',
                    icon: '👥',
                    coords: { x: 75, y: 64 },
                    deskripsi: 'Ruang bimbingan konseling karir, pengembangan potensi, dan konsultasi kepribadian peserta didik.',
                    lokasi: 'Gedung Sayap Timur',
                    fungsi: 'Konseling & Bimbingan',
                    jam_operasional: '07.00 - 15.30 WIB'
                },

                // 2. KELAS SAYAP UTARA (ATAS)
                {
                    id: 'kelas_xi_kul_3',
                    nama: 'Kelas XI Kuliner 3',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 48, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa kompetensi keahlian Kuliner tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_kul_2',
                    nama: 'Kelas XI Kuliner 2',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 51.5, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa kompetensi keahlian Kuliner tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_kul_1',
                    nama: 'Kelas XI Kuliner 1',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 55, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa kompetensi keahlian Kuliner tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_rpl_3',
                    nama: 'Kelas XI RPL 3',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 58.5, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa jurusan Rekayasa Perangkat Lunak tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_rpl_2',
                    nama: 'Kelas XI RPL 2',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 62, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa jurusan Rekayasa Perangkat Lunak tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_rpl_1',
                    nama: 'Kelas XI RPL 1',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 65.5, y: 15 },
                    deskripsi: 'Ruang kelas teori untuk siswa jurusan Rekayasa Perangkat Lunak tingkat XI.',
                    lokasi: 'Lantai 2 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xii_kul_3',
                    nama: 'Kelas XII Kuliner 3',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 48, y: 24 },
                    deskripsi: 'Ruang kelas teori untuk siswa tingkat akhir Kuliner.',
                    lokasi: 'Lantai 1 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xii_kul_12',
                    nama: 'Kelas XII Kuliner 1 & 2',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 52.5, y: 24 },
                    deskripsi: 'Ruang kelas teori siswa tingkat XII Kuliner.',
                    lokasi: 'Lantai 1 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xi_lps_1',
                    nama: 'Kelas XI Layanan Perbankan 1',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 56.5, y: 24 },
                    deskripsi: 'Ruang kelas teori program keahlian Layanan Perbankan Syariah.',
                    lokasi: 'Lantai 1 - Gedung Utara',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },

                // 3. KELAS KORIDOR TENGAH & BARAT
                {
                    id: 'kelas_xii_lps_2',
                    nama: 'Kelas XII Layanan Perbankan 2',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 26.5, y: 56 },
                    deskripsi: 'Ruang kelas teori siswa tingkat XII Layanan Perbankan Syariah.',
                    lokasi: 'Lantai 2 - Gedung Sayap Barat',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_xii_lps_1_barat',
                    nama: 'Kelas XII Layanan Perbankan 1',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 26.5, y: 69 },
                    deskripsi: 'Ruang kelas teori siswa tingkat XII Layanan Perbankan Syariah.',
                    lokasi: 'Lantai 1 - Gedung Sayap Barat',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_x_rpl_1',
                    nama: 'Kelas X RPL 1',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 44, y: 57 },
                    deskripsi: 'Ruang kelas dasar pemrograman dan fondasi informatika untuk siswa baru jurusan RPL.',
                    lokasi: 'Koridor Tengah',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_x_rpl_2',
                    nama: 'Kelas X RPL 2',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 44, y: 68 },
                    deskripsi: 'Ruang kelas pembelajaran teori dan komputasi dasar tingkat X RPL.',
                    lokasi: 'Koridor Tengah',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'kelas_x_rpl_3',
                    nama: 'Kelas X RPL 3',
                    kategori: 'Kelas',
                    icon: '🏫',
                    coords: { x: 44, y: 78 },
                    deskripsi: 'Ruang kelas pembelajaran teori dan komputasi dasar tingkat X RPL.',
                    lokasi: 'Koridor Tengah',
                    fungsi: 'Ruang Belajar Teori',
                    jam_operasional: '07.00 - 15.30 WIB'
                },

                // 4. KANTOR, IBADAH, LAPANGAN, PARKIRAN, GERBANG
                {
                    id: 'kantor_utama',
                    nama: 'Kantor Kepala Sekolah & Tata Usaha',
                    kategori: 'Kantor',
                    icon: '🏢',
                    coords: { x: 37, y: 84 },
                    deskripsi: 'Pusat administrasi sekolah, ruang kerja kepala sekolah, staf tata usaha, dan ruang penerimaan tamu.',
                    lokasi: 'Lantai 1 - Gedung Utama',
                    fungsi: 'Administrasi & Manajemen',
                    jam_operasional: '07.00 - 15.30 WIB'
                },
                {
                    id: 'bkk',
                    nama: 'BKK / Koperasi / Mini Bank',
                    kategori: 'Kantor',
                    icon: '💼',
                    coords: { x: 27, y: 88 },
                    deskripsi: 'Bursa Kerja Khusus (BKK) untuk penyaluran lulusan ke dunia kerja serta laboratorium Mini Bank.',
                    lokasi: 'Depan Sayap Kiri',
                    fungsi: 'Layanan Kerja & Perbankan',
                    jam_operasional: '07.30 - 15.00 WIB'
                },
                {
                    id: 'musholla',
                    nama: 'Musholla Al-Ikhlas',
                    kategori: 'Fasilitas',
                    icon: '🕌',
                    coords: { x: 55, y: 82 },
                    deskripsi: 'Sarana ibadah sholat berjamaah lima waktu, sholat dhuha bersama, dan kegiatan keagamaan.',
                    lokasi: 'Area Tengah Kampus',
                    fungsi: 'Sarana Ibadah',
                    jam_operasional: '06.00 - 17.30 WIB'
                },
                {
                    id: 'lapangan',
                    nama: 'Lapangan Olahraga & Upacara',
                    kategori: 'Lapangan',
                    icon: '⚽',
                    coords: { x: 80, y: 34 },
                    deskripsi: 'Lapangan olahraga serbaguna untuk upacara bendera, senam, bola basket, futsal, dan voli.',
                    lokasi: 'Sisi Timur Kampus',
                    fungsi: 'Olahraga & Kegiatan Luar',
                    jam_operasional: '06.30 - 17.30 WIB'
                },
                {
                    id: 'parkiran',
                    nama: 'Area Parkiran',
                    kategori: 'Fasilitas',
                    icon: '🅿️',
                    coords: { x: 13, y: 50 },
                    deskripsi: 'Area parkir kendaraan roda dua dan roda empat yang aman dan tertata rapi.',
                    lokasi: 'Sisi Barat Kampus',
                    fungsi: 'Parkir Kendaraan',
                    jam_operasional: '06.00 - 18.00 WIB'
                },
                {
                    id: 'gerbang_utama',
                    nama: 'Gerbang Utama & Pos Satpam',
                    kategori: 'Fasilitas',
                    icon: '🚪',
                    coords: { x: 39, y: 96 },
                    deskripsi: 'Akses gerbang utama keluar masuk warga sekolah dan tamu dengan penjagaan satpam 24 jam.',
                    lokasi: 'Pintu Depan - Jl. Raya Pulorejo',
                    fungsi: 'Keamanan & Pintu Masuk',
                    jam_operasional: '24 Jam'
                },
                {
                    id: 'kantin',
                    nama: 'Kantin Sehat Sekolah',
                    kategori: 'Fasilitas',
                    icon: '🍽️',
                    coords: { x: 74, y: 86 },
                    deskripsi: 'Kantin sekolah yang menyediakan aneka makanan dan minuman bersih, sehat, dan bergizi.',
                    lokasi: 'Sisi Tenggara Kampus',
                    fungsi: 'Kantin & Makanan',
                    jam_operasional: '06.30 - 16.00 WIB'
                }
            ],

            selectedFacility: null,

            init() {
                this.selectedFacility = this.allFacilities[0];
            },

            setCategory(cat) {
                this.activeCategory = cat;
            },

            selectFacility(facility) {
                this.selectedFacility = facility;
                this.routeTo = facility.id;
                this.updateRoute();
            },

            selectFacilityById(id) {
                const found = this.allFacilities.find(f => f.id === id);
                if (found) {
                    this.selectFacility(found);
                }
            },

            get filteredFacilities() {
                return this.allFacilities.filter(f => {
                    const matchCategory = this.activeCategory === 'Semua' || f.kategori === this.activeCategory;
                    const matchSearch = this.searchQuery === '' || f.nama.toLowerCase().includes(this.searchQuery.toLowerCase()) || f.lokasi.toLowerCase().includes(this.searchQuery.toLowerCase());
                    return matchCategory && matchSearch;
                });
            },

            calculateRoute() {
                const found = this.allFacilities.find(f => f.id === this.routeTo);
                if (found) {
                    this.selectedFacility = found;
                }
                this.updateRoute();
            },

            updateRoute() {
                this.showRoute = true;
                const from = this.allFacilities.find(f => f.id === this.routeFrom) || this.allFacilities[this.allFacilities.length - 2];
                const to = this.selectedFacility || this.allFacilities[0];

                const fx = from.coords.x * 9;
                const fy = from.coords.y * 6.2;
                const tx = to.coords.x * 9;
                const ty = to.coords.y * 6.2;

                const midX = (fx + tx) / 2 + (tx > fx ? 30 : -30);
                const midY = (fy + ty) / 2;
                this.currentRoutePath = `M ${fx} ${fy} Q ${midX} ${midY} ${tx} ${ty}`;

                const distPx = Math.sqrt((tx - fx) * (tx - fx) + (ty - fy) * (ty - fy));
                const distMeters = Math.max(15, Math.round(distPx * 0.12));
                const mins = Math.max(1, Math.round(distMeters / 40));

                this.routeStatsTitle = `✦ Jarak: ± ${distMeters} meter`;
                this.routeStatsTime = `Estimasi waktu: ${mins} menit`;
            }
        }));
    });
</script>
