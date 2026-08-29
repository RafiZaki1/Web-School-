{{-- ============ DENAH INTERAKTIF SEKOLAH (DINAMIS DENGAN BACKEND ROUTING GRAPH) ============ --}}
<section id="denah" class="relative z-10 py-10 sm:py-14 px-4 sm:px-6 lg:px-8 bg-[#f0f6fc]" x-data="denahInteraktifApp()" x-init="initData()">
    <div class="mx-auto w-full max-w-[1360px] space-y-6">
        
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="h-11 w-11 rounded-2xl bg-[#05529E] text-white flex items-center justify-center text-xl shadow-md shadow-blue-900/20 shrink-0">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-[#102a43] tracking-tight">
                        Denah Interaktif
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal">
                        Jelajahi denah sekolah kami dan temukan berbagai ruang serta fasilitas dengan mudah.
                    </p>
                </div>
            </div>

            {{-- Top Right: Search Bar --}}
            <div class="relative w-full md:w-80" @click.outside="showSearchDropdown = false">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @input.debounce.300ms="handleSearchInput()"
                    @focus="if(searchResults.length > 0) showSearchDropdown = true"
                    placeholder="Cari ruangan atau fasilitas..." 
                    class="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-10 pr-9 text-xs sm:text-[13px] text-slate-800 placeholder-slate-400 focus:border-[#05529E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#05529E]/15 shadow-xs transition"
                />
                <button 
                    x-show="searchQuery.length > 0" 
                    @click="clearSearch()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Autocomplete Dropdown --}}
                <div 
                    x-show="showSearchDropdown && searchResults.length > 0"
                    x-transition
                    class="absolute left-0 right-0 top-full mt-1.5 z-50 max-h-64 overflow-y-auto rounded-2xl bg-white p-2 shadow-2xl border border-slate-200 divide-y divide-slate-100 text-xs">
                    <template x-for="item in searchResults" :key="item.id">
                        <div 
                            @click="selectRoom(item); showSearchDropdown = false;"
                            class="flex items-center justify-between p-2.5 rounded-xl hover:bg-sky-50 cursor-pointer transition">
                            <div>
                                <p class="font-bold text-slate-900" x-text="item.name"></p>
                                <p class="text-[11px] text-slate-500" x-text="item.building_name || (item.category ? item.category.name : '')"></p>
                            </div>
                            <span class="text-[10px] font-semibold text-sky-700 bg-sky-100 px-2 py-0.5 rounded-full" x-text="item.category ? item.category.name : 'Ruangan'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Content Layout: Expanded Map Canvas (Left lg:col-span-8) + Detail & Chatbot (Right lg:col-span-4) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-stretch">

            {{-- 1. Expanded Interactive Map Canvas (lg:col-span-8) --}}
            <div class="lg:col-span-8 flex flex-col h-full space-y-3">
                
                {{-- Map View Container with Base Real Image, Dynamic SVG Path, Markers, & Clickable Hotspots --}}
                <div 
                    id="interactive-map-canvas"
                    class="map-container relative w-full h-[480px] sm:h-[540px] lg:h-full min-h-[460px] rounded-3xl border border-slate-200/80 bg-white overflow-hidden select-none shadow-sm flex-1">
                    
                    {{-- Loading Skeleton Overlay --}}
                    <div x-show="isLoading" class="absolute inset-0 z-40 flex items-center justify-center bg-white/80 backdrop-blur-2xs">
                        <div class="flex items-center gap-2.5 rounded-full bg-white px-5 py-2.5 shadow-lg border border-slate-200 text-xs font-bold text-slate-800">
                            <svg class="animate-spin h-4 w-4 text-[#05529E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Memuat denah dan jalur navigasi...</span>
                        </div>
                    </div>

                    {{-- Map Zoom & View Controls Overlay (Left) --}}
                    <div class="absolute left-3.5 bottom-3.5 z-30 flex flex-col gap-1 bg-white/95 backdrop-blur-xs p-1 rounded-2xl shadow-lg border border-slate-200/80">
                        <button 
                            type="button" 
                            @click="zoomIn()"
                            title="Perbesar Peta"
                            class="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 font-bold text-sm transition">
                            +
                        </button>
                        <button 
                            type="button" 
                            @click="zoomOut()"
                            title="Perkecil Peta"
                            class="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 font-bold text-sm transition">
                            −
                        </button>
                        <button 
                            type="button" 
                            @click="resetZoom()"
                            title="Reset Tampilan"
                            class="h-7 w-7 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-700 text-xs transition">
                            ⊙
                        </button>
                    </div>

                    {{-- Zoom Wrapper Container --}}
                    <div 
                        class="absolute inset-0 transition-transform duration-300 origin-center"
                        :style="`transform: scale(${mapScale});`"
                    >
                        {{-- 1. Base Real Map Image (Strictly Untouched) --}}
                        <img 
                            src="{{ asset('images/denah-map.png') }}" 
                            alt="Denah SMKN 2 Kota Mojokerto" 
                            class="map-image absolute inset-0 w-full h-full object-contain object-center pointer-events-none"
                        />

                        {{-- 2. Route SVG Layer (Dynamic Path Connecting Exact Coordinates) --}}
                        <svg 
                            x-show="showRoute && svgPathD" 
                            viewBox="0 0 100 100" 
                            preserveAspectRatio="none"
                            class="route-layer absolute inset-0 w-full h-full pointer-events-none z-20 transition-all duration-300">
                            
                            {{-- Route Outer Glow / Halo --}}
                            <path 
                                :d="svgPathD" 
                                fill="none" 
                                stroke="#38bdf8" 
                                stroke-width="3" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                opacity="0.6" 
                            />
                            {{-- Route Solid Navigation Line --}}
                            <path 
                                :d="svgPathD" 
                                fill="none" 
                                stroke="#0284c7" 
                                stroke-width="1.4" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                            />
                        </svg>

                        {{-- 3. Dynamic Origin & Destination Markers --}}
                        <div x-show="showRoute" class="marker-layer absolute inset-0 pointer-events-none z-25">
                            {{-- Origin Start Marker --}}
                            <template x-if="originPoint">
                                <div 
                                    :style="`left: ${originPoint.x}%; top: ${originPoint.y}%;`"
                                    class="absolute -translate-x-1/2 -translate-y-1/2 flex items-center justify-center">
                                    <div class="h-6 w-6 rounded-full bg-blue-500/30 animate-ping absolute"></div>
                                    <div class="h-4 w-4 rounded-full bg-white border-2 border-[#05529E] shadow-xl relative z-10 flex items-center justify-center">
                                        <div class="h-1.5 w-1.5 rounded-full bg-[#05529E]"></div>
                                    </div>
                                </div>
                            </template>

                            {{-- Destination Target Marker (Location Pin) --}}
                            <template x-if="destPoint">
                                <div 
                                    :style="`left: ${destPoint.x}%; top: ${destPoint.y}%;`"
                                    class="absolute -translate-x-1/2 -translate-y-full flex flex-col items-center">
                                    <div class="h-8 w-8 rounded-full bg-[#05529E] text-white shadow-2xl flex items-center justify-center border-2 border-white animate-bounce">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="w-2 h-1 bg-slate-900/30 rounded-full blur-2xs mt-0.5"></div>
                                </div>
                            </template>
                        </div>

                        {{-- 4. Interactive Clickable Transparent Hotspots for Each Room (No intrusive icons) --}}
                        <div class="hotspot-layer absolute inset-0 z-15">
                            <template x-for="room in filteredRooms" :key="room.id">
                                <div 
                                    @click="selectRoom(room)"
                                    :style="getHotspotStyle(room)"
                                    :class="getHotspotClass(room)"
                                    class="absolute transition-all duration-150 cursor-pointer group"
                                    :title="room.name"
                                >
                                    {{-- Tooltip on Hover --}}
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 hidden group-hover:flex flex-col items-center whitespace-nowrap rounded-lg bg-slate-900/95 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white shadow-xl z-40 pointer-events-none">
                                        <span x-text="room.name"></span>
                                        <span class="text-[9px] text-slate-300 font-normal" x-text="room.building_name"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

            </div>

            {{-- 2. Right Detail & Chatbot Assistance Column (lg:col-span-4) --}}
            <div class="lg:col-span-4 flex flex-col h-full space-y-3 justify-between">
                
                {{-- Room Detail Card --}}
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 space-y-4 flex flex-col justify-between flex-1 shadow-sm">
                    
                    <template x-if="selectedRoom">
                        <div class="space-y-3.5">
                            {{-- Top Pill Badge: "Tujuan Anda" --}}
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full bg-[#05529E] text-white px-3 py-1 text-[11px] font-bold tracking-wide shadow-xs">
                                    Tujuan Anda
                                </span>
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800" x-text="selectedRoom.category ? selectedRoom.category.name : 'Ruangan'"></span>
                            </div>

                            {{-- Room Title & Subtitle --}}
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight leading-snug" x-text="selectedRoom.name"></h3>
                                <p class="text-xs font-bold text-[#05529E] mt-0.5" x-text="selectedRoom.building_name || 'SMKN 2 Mojokerto'"></p>
                            </div>

                            {{-- Photo / Visual Preview Card --}}
                            <div class="relative w-full h-32 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-inner group">
                                <img 
                                    :src="selectedRoom.image ? ('/storage/' + selectedRoom.image.replace(/^storage\//, '')) : '{{ asset('images/hero-bg.jpg') }}'" 
                                    :alt="selectedRoom.name"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    onerror="this.src='{{ asset('images/hero-bg.jpg') }}'"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-2 left-2.5 right-2.5 flex items-center justify-between text-white text-[10px] font-bold">
                                    <span x-text="selectedRoom.building_name || 'Gedung Sekolah'"></span>
                                    <span class="bg-white/20 backdrop-blur-xs px-2 py-0.5 rounded-full">SKANEDA</span>
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <p class="text-xs text-slate-600 leading-relaxed font-normal" x-text="selectedRoom.description || 'Fasilitas pembelajaran resmi pada lingkungan SMK Negeri 2 Kota Mojokerto.'"></p>

                            {{-- Meta Details --}}
                            <div class="border-t border-slate-100 pt-3 space-y-2 text-xs">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                        <span>❖</span> Lokasi
                                    </span>
                                    <span class="text-slate-800 font-semibold text-right" x-text="selectedRoom.building_name || '-'"></span>
                                </div>
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                        <span>▣</span> Kategori
                                    </span>
                                    <span class="text-slate-800 font-semibold text-right" x-text="selectedRoom.category ? selectedRoom.category.name : 'Ruangan'"></span>
                                </div>
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-slate-500 font-medium shrink-0 flex items-center gap-1.5">
                                        <span>🕒</span> Jam Operasional
                                    </span>
                                    <span class="text-slate-800 font-semibold text-right" x-text="selectedRoom.open_hours || '07.00 - 16.00 WIB'"></span>
                                </div>
                            </div>

                            {{-- Facilities Chips --}}
                            <div x-show="selectedRoom.facilities && selectedRoom.facilities.length > 0" class="pt-1">
                                <p class="text-[11px] font-bold text-slate-700 mb-1.5">Fasilitas:</p>
                                <div class="flex flex-wrap gap-1">
                                    <template x-for="fac in selectedRoom.facilities" :key="fac.id">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-medium border border-slate-200">
                                            <span x-text="fac.name"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Empty State (No Room Selected) --}}
                    <template x-if="!selectedRoom">
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-6 space-y-3">
                            <div class="h-12 w-12 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                                🗺️
                            </div>
                            <p class="font-bold text-slate-800 text-sm">Pilih Ruangan</p>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Silakan klik ruangan pada denah atau gunakan pencarian untuk melihat detail informasi.
                            </p>
                        </div>
                    </template>

                    {{-- Dynamic Routing Action Buttons --}}
                    <div class="pt-2 space-y-2">
                        <button 
                            type="button"
                            x-show="selectedRoom"
                            @click="handleNavigateToSelected()"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-[#05529E] hover:bg-[#0766c6] text-white py-2.5 px-4 text-xs font-bold shadow-md hover:shadow-lg transition-all cursor-pointer">
                            <span>Arahkan Rute ke Sini</span>
                            <span>→</span>
                        </button>

                        <button 
                            type="button"
                            x-show="selectedRoom"
                            @click="setAsOrigin(selectedRoom.slug || selectedRoom.id)"
                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-2xl border border-slate-200 hover:bg-slate-50 text-slate-700 py-1.5 px-3 text-[11px] font-semibold transition cursor-pointer">
                            <span>● Mulai Rute dari Sini</span>
                        </button>
                    </div>

                </div>

                {{-- Chatbot Assistance Promo Card --}}
                <div class="bg-white border border-slate-200/80 rounded-3xl p-4 text-xs text-slate-800 flex items-center justify-between gap-3 shadow-sm">
                    <div class="space-y-1">
                        <div class="flex items-center gap-1.5 font-bold text-slate-900">
                            <span class="text-[#05529E]">💬</span>
                            <span>Butuh bantuan navigasi?</span>
                        </div>
                        <p class="text-[11px] text-slate-600">
                            Tanyakan ruangan atau rute langsung kepada SADA AI.
                        </p>
                    </div>
                    <button 
                        type="button" 
                        onclick="toggleChatbot()"
                        class="shrink-0 text-center py-2 px-3.5 rounded-2xl bg-[#05529E] hover:bg-[#0766c6] text-white font-bold text-xs transition shadow-sm cursor-pointer">
                        Tanya Chatbot
                    </button>
                </div>

            </div>

        </div>

        {{-- Bottom Row 1: Dynamic Route Selector Bar --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-4 sm:p-5 flex flex-col lg:flex-row items-center justify-between gap-4 shadow-sm">
            
            {{-- Title --}}
            <div class="flex items-center gap-2 text-slate-900 font-bold text-sm shrink-0 w-full lg:w-auto">
                <span class="text-[#05529E] text-base">✦</span>
                <span>Cari rute ke ruangan</span>
            </div>

            {{-- Dynamic Dari & Tujuan Dropdowns & Action Button --}}
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-1 max-w-3xl">
                
                {{-- Dari (Origin) --}}
                <div class="w-full sm:w-1/2">
                    <label class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Dari</label>
                    <div class="relative">
                        <select 
                            x-model="routeFrom" 
                            @change="onOriginOrDestChange()"
                            class="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-3 pr-8 text-xs text-slate-800 focus:border-[#05529E] focus:outline-none shadow-xs cursor-pointer">
                            <option value="" disabled>-- Pilih Lokasi Asal --</option>
                            <template x-for="r in allRooms" :key="'from-' + r.id">
                                <option :value="r.slug || r.id" x-text="r.name"></option>
                            </template>
                        </select>
                    </div>
                </div>

                {{-- Tujuan (Destination) --}}
                <div class="w-full sm:w-1/2">
                    <label class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Tujuan</label>
                    <div class="relative">
                        <select 
                            x-model="routeTo" 
                            @change="onOriginOrDestChange()"
                            class="w-full rounded-2xl border border-slate-200 bg-white py-2.5 pl-3 pr-8 text-xs text-slate-800 focus:border-[#05529E] focus:outline-none shadow-xs cursor-pointer">
                            <option value="" disabled>-- Pilih Lokasi Tujuan --</option>
                            <template x-for="r in allRooms" :key="'to-' + r.id">
                                <option :value="r.slug || r.id" x-text="r.name"></option>
                            </template>
                        </select>
                    </div>
                </div>

                {{-- Tampilkan Rute Button --}}
                <div class="w-full sm:w-auto self-end flex gap-2">
                    <button 
                        type="button" 
                        @click="fetchRoute()" 
                        :disabled="isRouteLoading || !routeFrom || !routeTo"
                        class="w-full sm:w-auto whitespace-nowrap rounded-2xl bg-[#05529E] hover:bg-[#0766c6] disabled:opacity-50 text-white px-5 py-2.5 text-xs font-bold shadow-md hover:shadow-lg transition cursor-pointer flex items-center justify-center gap-1.5">
                        <span x-show="isRouteLoading" class="animate-spin text-xs">⏳</span>
                        <span x-text="isRouteLoading ? 'Menghitung...' : '➔ Tampilkan Rute'"></span>
                    </button>

                    <button 
                        type="button"
                        x-show="showRoute"
                        @click="cancelRoute()"
                        class="whitespace-nowrap rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-4 py-2.5 text-xs font-bold transition cursor-pointer">
                        Batalkan Rute
                    </button>
                </div>

            </div>

            {{-- Route Stats Info --}}
            <div x-show="showRoute && routeInfo" class="text-xs text-slate-700 bg-sky-50 px-4 py-2.5 rounded-2xl border border-sky-200 shadow-2xs shrink-0 flex items-center gap-2.5">
                <span class="text-lg">🚶</span>
                <div>
                    <p class="font-bold text-[#05529E]" x-text="`Jarak: ± ${routeInfo.distance} meter`"></p>
                    <p class="text-[11px] text-slate-500" x-text="`Estimasi waktu: ± ${routeInfo.estimated_minutes} menit`"></p>
                </div>
            </div>

        </div>

        {{-- Bottom Row 2: Popular Facilities Quick Access Bar --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <template x-for="r in popularRooms" :key="'chip-' + r.id">
                <button 
                    type="button"
                    @click="selectRoom(r)"
                    :class="selectedRoom && selectedRoom.id === r.id 
                        ? 'bg-[#ebf4fd] border-[#b9d9f9] text-[#05529E] font-bold ring-1 ring-sky-300' 
                        : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold'"
                    class="inline-flex items-center px-4 py-2 rounded-2xl border text-xs shadow-2xs transition whitespace-nowrap cursor-pointer">
                    <span x-text="r.name"></span>
                </button>
            </template>
            <button 
                type="button"
                @click="setCategory('Semua')"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-bold text-[#05529E] hover:text-[#0766c6] transition whitespace-nowrap cursor-pointer">
                <span>Lainnya</span>
                <span>→</span>
            </button>
        </div>

    </div>
</section>

{{-- Alpine.js Dynamic Live Routing Engine --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('denahInteraktifApp', () => ({
            allRooms: [],
            categories: [],
            activeCategory: 'Semua',
            selectedRoom: null,
            searchQuery: '',
            searchResults: [],
            showSearchDropdown: false,

            // Dynamic Route State
            routeFrom: '',
            routeTo: '',
            showRoute: false,
            routeInfo: null,
            svgPathD: '',
            originPoint: null,
            destPoint: null,

            // Zoom State
            mapScale: 1.0,

            isLoading: true,
            isRouteLoading: false,

            async initData() {
                this.isLoading = true;
                try {
                    // 1. Fetch Categories from API
                    const catRes = await fetch('/api/v1/public/map/categories');
                    const catData = await catRes.json();
                    if (catData.success) {
                        this.categories = catData.data || [];
                    }

                    // 2. Fetch Rooms from API
                    const roomRes = await fetch('/api/v1/public/rooms');
                    const roomData = await roomRes.json();
                    if (roomData.success) {
                        this.allRooms = roomData.data || [];
                        
                        // Default selection: Lapangan Olahraga / Lab RPL
                        const defaultDest = this.allRooms.find(r => r.slug.includes('lapangan') || r.slug.includes('rpl')) || this.allRooms[0];
                        if (defaultDest) {
                            this.selectedRoom = defaultDest;
                            this.routeTo = defaultDest.slug || defaultDest.id;
                        }

                        // Default origin: Gerbang Utama
                        const defaultOrigin = this.allRooms.find(r => r.slug.includes('gerbang')) || this.allRooms[0];
                        if (defaultOrigin) {
                            this.routeFrom = defaultOrigin.slug || defaultOrigin.id;
                        }

                        // Initial demonstration route
                        if (this.routeFrom && this.routeTo && this.routeFrom !== this.routeTo) {
                            this.fetchRoute();
                        }
                    }
                } catch (err) {
                    console.error('Error loading denah data:', err);
                } finally {
                    this.isLoading = false;
                }

                // Global event listeners for Chatbot integration
                window.addEventListener('sada:select-room', (e) => {
                    if (e.detail && e.detail.slug) {
                        this.selectRoomBySlug(e.detail.slug);
                    }
                });

                window.addEventListener('sada:show-route', (e) => {
                    if (e.detail && e.detail.from && e.detail.to) {
                        this.routeFrom = e.detail.from;
                        this.routeTo = e.detail.to;
                        this.fetchRoute();
                    }
                });
            },

            get filteredRooms() {
                return this.allRooms.filter(r => {
                    if (this.activeCategory === 'Semua') return true;
                    return r.category && r.category.name.toLowerCase() === this.activeCategory.toLowerCase();
                });
            },

            get popularRooms() {
                return this.allRooms.slice(0, 6);
            },

            setCategory(name) {
                this.activeCategory = name;
            },

            async selectRoom(room) {
                this.selectedRoom = room;
                this.routeTo = room.slug || room.id;

                try {
                    const res = await fetch(`/api/v1/public/rooms/${encodeURIComponent(room.slug || room.id)}`);
                    const data = await res.json();
                    if (data.success && data.data) {
                        this.selectedRoom = data.data;
                    }
                } catch (e) {
                    console.error('Error fetching room detail:', e);
                }
            },

            selectRoomBySlug(slug) {
                const found = this.allRooms.find(r => r.slug === slug || r.id == slug);
                if (found) {
                    this.selectRoom(found);
                    const el = document.getElementById('denah');
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            },

            setAsOrigin(slugOrId) {
                this.routeFrom = slugOrId;
                if (this.routeFrom && this.routeTo && this.routeFrom !== this.routeTo) {
                    this.fetchRoute();
                }
            },

            handleNavigateToSelected() {
                if (!this.selectedRoom) return;
                this.routeTo = this.selectedRoom.slug || this.selectedRoom.id;

                // If origin is not yet set, prompt or fallback to Gerbang
                if (!this.routeFrom) {
                    const gate = this.allRooms.find(r => r.slug.includes('gerbang')) || this.allRooms[0];
                    this.routeFrom = gate ? (gate.slug || gate.id) : '';
                }

                this.fetchRoute();
            },

            onOriginOrDestChange() {
                // Clear active route visually until user hits "Tampilkan Rute"
                this.showRoute = false;
                this.svgPathD = '';
                this.originPoint = null;
                this.destPoint = null;
                this.routeInfo = null;
            },

            async handleSearchInput() {
                const q = this.searchQuery.trim();
                if (q.length === 0) {
                    this.searchResults = [];
                    this.showSearchDropdown = false;
                    return;
                }

                try {
                    const res = await fetch(`/api/v1/public/rooms/search?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    if (data.success && Array.isArray(data.data)) {
                        this.searchResults = data.data;
                        this.showSearchDropdown = true;
                    }
                } catch (e) {
                    console.error('Search error:', e);
                }
            },

            clearSearch() {
                this.searchQuery = '';
                this.searchResults = [];
                this.showSearchDropdown = false;
            },

            async fetchRoute() {
                if (!this.routeFrom || !this.routeTo) return;
                if (this.routeFrom === this.routeTo) {
                    alert('Lokasi asal dan tujuan tidak boleh sama.');
                    return;
                }

                this.isRouteLoading = true;
                try {
                    const res = await fetch(`/api/v1/public/map/route?from=${encodeURIComponent(this.routeFrom)}&to=${encodeURIComponent(this.routeTo)}`);
                    const data = await res.json();

                    if (data.success && data.data) {
                        const route = data.data;
                        this.routeInfo = {
                            distance: route.distance,
                            estimated_minutes: route.estimated_minutes,
                        };

                        // Build dynamic path from waypoints
                        if (route.path && route.path.length > 0) {
                            this.svgPathD = this.buildCurvedSvgPath(route.path);
                            this.originPoint = route.path[0];
                            this.destPoint = route.path[route.path.length - 1];
                            this.showRoute = true;
                        }
                    } else {
                        alert(data.message || 'Rute tidak dapat ditemukan.');
                        this.showRoute = false;
                    }
                } catch (e) {
                    console.error('Route calculation error:', e);
                } finally {
                    this.isRouteLoading = false;
                }
            },

            buildCurvedSvgPath(points) {
                if (!points || points.length === 0) return '';
                if (points.length === 1) return `M ${points[0].x} ${points[0].y}`;

                let d = `M ${points[0].x} ${points[0].y}`;
                for (let i = 1; i < points.length; i++) {
                    const p0 = points[i - 1];
                    const p1 = points[i];
                    
                    // Smooth Quadratic Bezier curve between waypoints
                    const midX = (p0.x + p1.x) / 2;
                    const midY = (p0.y + p1.y) / 2;
                    d += ` Q ${p0.x} ${p0.y} ${midX} ${midY} T ${p1.x} ${p1.y}`;
                }
                return d;
            },

            cancelRoute() {
                this.showRoute = false;
                this.svgPathD = '';
                this.routeInfo = null;
                this.originPoint = null;
                this.destPoint = null;
            },

            zoomIn() {
                if (this.mapScale < 2.0) this.mapScale += 0.2;
            },

            zoomOut() {
                if (this.mapScale > 0.8) this.mapScale -= 0.2;
            },

            resetZoom() {
                this.mapScale = 1.0;
            },

            getHotspotStyle(room) {
                if (!room.hotspot) return 'display: none;';
                return `left: ${room.hotspot.x}%; top: ${room.hotspot.y}%; width: ${room.hotspot.width}%; height: ${room.hotspot.height}%;`;
            },

            getHotspotClass(room) {
                const isSelected = this.selectedRoom && (this.selectedRoom.id === room.id || this.selectedRoom.slug === room.slug);
                if (isSelected) {
                    return 'ring-2 ring-blue-600 bg-blue-600/30 rounded-md shadow-sm z-30';
                }
                return 'hover:bg-blue-400/25 hover:ring-2 hover:ring-blue-400/70 rounded-md transition-all z-10';
            },

            getCategoryIcon(slug) {
                switch(slug) {
                    case 'lab-bengkel': return '💻';
                    case 'ruang-kelas': return '🏫';
                    case 'fasilitas': return '🏛️';
                    case 'kantor': return '🏢';
                    case 'area-terbuka': return '⚽';
                    default: return '📍';
                }
            },

            getRoomBadge(room) {
                if (room.category) {
                    return this.getCategoryIcon(room.category.slug);
                }
                return '📍';
            }
        }));
    });
</script>
