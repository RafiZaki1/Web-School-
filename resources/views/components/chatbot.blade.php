@props([
    'schoolName' => 'SMKN 2 Kota Mojokerto',
])

<div id="sada-chatbot" class="fixed bottom-5 right-5 z-50 font-sans text-slate-800 antialiased">
    {{-- Floating Toggle Launcher with "Butuh Bantuan?" Tooltip --}}
    <div id="chatbot-launcher-container" class="flex items-center">
        {{-- "Butuh Bantuan?" Speech Bubble Tooltip --}}
        <div
            id="chatbot-tooltip-bubble"
            onclick="toggleChatbot(true)"
            class="hidden sm:flex relative items-center mr-3 cursor-pointer select-none rounded-full bg-white px-4 py-2 text-xs font-bold text-slate-900 shadow-xl border border-slate-100 transition-all duration-300 hover:scale-105 hover:shadow-2xl"
        >
            <span>Butuh Bantuan?</span>
            {{-- Bubble Tail pointing right --}}
            <span class="absolute -right-2 top-1/2 -translate-y-1/2 h-0 w-0 border-y-[6px] border-y-transparent border-l-[8px] border-l-white drop-shadow-xs"></span>
        </div>

        {{-- 3D Robot Head Floating Button --}}
        <button
            id="chatbot-toggle-btn"
            type="button"
            onclick="toggleChatbot()"
            class="group relative flex h-16 w-16 items-center justify-center rounded-full bg-white p-1 shadow-2xl shadow-blue-600/30 transition-all duration-300 hover:scale-110 focus:outline-none ring-4 ring-white"
            aria-label="Buka SADA Roomchat"
        >
            {{-- Online Pulse Dot --}}
            <span class="absolute top-0 right-0 z-10 flex h-4 w-4">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-4 w-4 rounded-full border-2 border-white bg-emerald-500"></span>
            </span>

            {{-- SADA Robot Logo Avatar --}}
            <div id="chatbot-icon-open" class="relative flex h-full w-full items-center justify-center">
                <img src="{{ asset('images/sada-avatar.svg') }}" alt="SADA" class="h-full w-full object-contain drop-shadow-sm transition-transform group-hover:scale-105">
            </div>

            {{-- Close Icon (When open) --}}
            <div id="chatbot-icon-close" class="hidden flex h-full w-full items-center justify-center rounded-full text-white shadow-lg" style="background-color: #05529E !important;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7 transition-transform group-hover:rotate-90" style="color: #ffffff !important; fill: currentColor !important;">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </div>

    {{-- Chatbot Window Container (SADA Roomchat) --}}
    <div
        id="chatbot-window"
        class="hidden fixed bottom-24 right-3 sm:right-6 z-50 flex h-[585px] max-h-[85vh] w-[94vw] sm:w-[385px] flex-col overflow-hidden rounded-3xl border border-slate-200 bg-[#f0f4f9] shadow-2xl transition-all duration-300 ring-1 ring-slate-300"
    >
        {{-- Header / Navbar: SADA Roomchat (Solid Brand Blue #05529E - High Contrast & Sangat Jelas) --}}
        <div class="flex items-center justify-between px-4 py-3.5 shadow-md" style="background-color: #05529E !important; color: #ffffff !important;">
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    onclick="toggleChatbot(false)"
                    class="rounded-full p-1.5 transition hover:bg-white/20"
                    style="color: #ffffff !important;"
                    title="Tutup"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" style="color: #ffffff !important;">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div>
                    <h3 class="text-sm font-black tracking-tight leading-none" style="color: #ffffff !important;">SADA Roomchat</h3>
                    <p class="mt-1 flex items-center gap-1.5 text-[11px] font-bold" style="color: #6ee7b7 !important;">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Online
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2" style="color: #ffffff !important;">
                <button type="button" onclick="resetChatHistory()" title="Reset Percakapan" class="rounded-full p-1.5 hover:bg-white/20 transition" style="color: #ffffff !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" style="color: #ffffff !important;">
                        <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.451a.75.75 0 0 0 0-1.5H4.5a.75.75 0 0 0-.75.75v3.75a.75.75 0 0 0 1.5 0v-2.146l.513.513a7 7 0 1 0 1.637-8.23.75.75 0 1 0 1.06 1.06 5.5 5.5 0 0 1 6.852 3.608Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button" onclick="toggleChatbot(false)" title="Tutup" class="rounded-full p-1.5 hover:bg-white/20 transition" style="color: #ffffff !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" style="color: #ffffff !important;">
                        <path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Top Sub-Banner Pill --}}
        <div class="px-3 pt-3">
            <div class="flex items-center gap-2.5 rounded-full bg-white px-3.5 py-2 text-xs font-medium text-slate-700 shadow-xs border border-slate-200/80">
                <img src="{{ asset('images/sada-avatar.svg') }}" alt="SADA" class="h-7 w-7 object-contain shrink-0">
                <p class="text-[11px] leading-tight text-slate-700">
                    SADA siap membantu menjawab pertanyaan seputar <strong>SMKN 2 Mojokerto</strong> ✨
                </p>
            </div>
        </div>

        {{-- Chat Messages Scroll Area --}}
        <div id="chatbot-messages" class="flex-1 space-y-3.5 overflow-y-auto p-3.5 text-xs">
            {{-- Bot Initial Welcome Message --}}
            <div class="space-y-1">
                <span class="text-[11px] font-bold pl-9" style="color: #05529E !important;">SADA</span>
                <div class="flex items-start gap-2">
                    <img src="{{ asset('images/sada-avatar.svg') }}" alt="SADA" class="h-7 w-7 object-contain shrink-0 mt-0.5">

                    <div class="max-w-[85%] rounded-2xl rounded-tl-none bg-white p-3.5 shadow-xs border border-slate-200 text-slate-900 leading-relaxed">
                        <p class="font-bold text-slate-900">Halo! ✋</p>
                        <p class="mt-1">Selamat datang di Roomchat SADA.</p>
                        <p class="mt-1">Ada yang bisa saya bantu hari ini?</p>
                    </div>
                </div>
                <div class="pl-9 text-[10px] text-slate-400" id="bot-init-time">05:58 PM</div>
            </div>

            {{-- Quick Chips (Pertanyaan Template Resmi yang Disediakan) --}}
            <div id="chatbot-chips" class="pt-1 pl-8 flex flex-wrap gap-1.5">
                <button type="button" onclick="sendQuickPrompt('Apa saja jurusan di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    🎓 Jurusan SMKN 2
                </button>
                <button type="button" onclick="sendQuickPrompt('Bagaimana informasi PPDB SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    📋 Info PPDB
                </button>
                <button type="button" onclick="sendQuickPrompt('Fasilitas apa saja di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    🏫 Fasilitas & Lab
                </button>
                <button type="button" onclick="sendQuickPrompt('Bagaimana cara melihat denah interaktif sekolah di web ini?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    🗺️ Denah Interaktif
                </button>
                <button type="button" onclick="sendQuickPrompt('Apa saja ekstrakurikuler dan prestasi di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    🏆 Ekskul & Prestasi
                </button>
                <button type="button" onclick="sendQuickPrompt('Apa visi dan misi SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    🎯 Visi & Misi
                </button>
                <button type="button" onclick="sendQuickPrompt('Di mana lokasi dan kontak resmi SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                    📍 Lokasi & Kontak
                </button>
            </div>
        </div>

        {{-- Typing Indicator Capsule --}}
        <div id="chatbot-typing" class="hidden px-3.5 py-1.5">
            <div class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-600 shadow-xs border border-slate-200/80">
                <div class="flex h-4 w-4 items-center justify-center rounded-full bg-slate-950">
                    <span class="flex gap-0.5">
                        <span class="h-0.5 w-0.5 rounded-full bg-white"></span>
                        <span class="h-0.5 w-0.5 rounded-full bg-white"></span>
                    </span>
                </div>
                <span>SADA is typing...</span>
                <span class="flex gap-0.5">
                    <span class="h-1 w-1 rounded-full bg-blue-600 animate-bounce"></span>
                    <span class="h-1 w-1 rounded-full bg-blue-600 animate-bounce [animation-delay:0.2s]"></span>
                    <span class="h-1 w-1 rounded-full bg-blue-600 animate-bounce [animation-delay:0.4s]"></span>
                </span>
            </div>
        </div>

        {{-- Anti-Spam Warning Pill / Alert Bar --}}
        <div id="chatbot-spam-alert" class="hidden mx-3 mb-1.5 flex items-center justify-between gap-2 rounded-xl bg-amber-50 border border-amber-200/80 px-3 py-2 text-[11px] font-semibold text-amber-900 shadow-xs transition-all duration-300">
            <div class="flex items-center gap-2">
                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-500 text-white text-xs font-black">!</span>
                <span id="chatbot-spam-text">Harap tunggu sejenak sebelum mengirim pesan lagi.</span>
            </div>
            <button type="button" onclick="hideSpamAlert()" class="text-amber-600 hover:text-amber-800 text-sm font-bold leading-none p-0.5">×</button>
        </div>

        {{-- Input Capsule Bar --}}
        <form id="chatbot-form" onsubmit="handleChatSubmit(event)" class="border-t border-slate-200 bg-white p-2.5">
            @csrf
            
            {{-- Honeypot Bot Trap (Invisible to real humans, traps automated spam bots) --}}
            <input
                type="text"
                id="sada_security_code"
                name="sada_security_code"
                tabindex="-1"
                autocomplete="off"
                class="hidden"
                style="display:none !important; position:absolute; left:-9999px;"
            />

            <div class="flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 border border-slate-200 focus-within:border-blue-600 focus-within:bg-white transition">
                <button type="button" onclick="document.getElementById('chatbot-chips').style.display='flex'" title="Opsi Pertanyaan" class="flex h-7 w-7 items-center justify-center rounded-full text-slate-500 hover:text-blue-600 hover:bg-slate-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                </button>
                <input
                    id="chatbot-input"
                    type="text"
                    placeholder="Ketik pesan..."
                    class="w-full bg-transparent text-xs text-slate-900 placeholder-slate-400 focus:outline-none px-1"
                    autocomplete="off"
                    maxlength="500"
                />
                <button
                    id="chatbot-submit-btn"
                    type="submit"
                    style="background-color: #05529E !important; color: #ffffff !important;"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full shadow-md transition hover:opacity-90 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg id="chatbot-send-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 -rotate-45 translate-x-0.5" style="color: #ffffff !important; fill: currentColor !important;">
                        <path d="M3.105 2.288a.75.75 0 0 0-.826.95l1.414 4.926A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.897 28.897 0 0 0 15.293-7.155.75.75 0 0 0 0-1.114A28.897 28.897 0 0 0 3.105 2.288Z" />
                    </svg>
                    <span id="chatbot-cooldown-text" class="hidden text-[10px] font-bold" style="color: #ffffff !important;">3s</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        let isChatOpen = false;
        let chatHistory = [];
        let isProcessing = false;
        const CHAT_ENDPOINT = '{{ route('chatbot.send') }}';

        // ==========================================
        // CONFIG ANTI-SPAM JAVASCRIPT KETAT (STRICT SUITE)
        // ==========================================
        const ANTI_SPAM = {
            COOLDOWN_SECONDS: 4,         // Jeda waktu wajib antar pesan (4 detik)
            MAX_MESSAGES_PER_MINUTE: 4,  // Maksimal 4 pesan per menit
            MAX_MESSAGES_PER_SESSION: 25,// Maksimal 25 pesan per sesi 15 menit
            MIN_LENGTH: 2,               // Minimal panjang pesan
            MAX_LENGTH: 350,             // Maksimal panjang pesan
            DUPLICATE_TIME_WINDOW: 45000 // Blokir pesan sama selama 45 detik
        };

        let isCooldownActive = false;
        let cooldownTimer = null;
        let lastSentMessage = '';
        let lastSentTime = 0;
        let alertTimeout = null;

        // Daftar kata toksik untuk dicegah instan di browser
        const CLIENT_TOXIC_WORDS = [
            'anjing', 'babi', 'bangsat', 'kontol', 'memek', 'jembut', 'tolol', 'goblok',
            'bajingan', 'pantek', 'kampret', 'asu', 'bgst', 'idiot', 'lonte', 'ngentot'
        ];

        function showSpamAlert(message) {
            const alertBox = document.getElementById('chatbot-spam-alert');
            const alertText = document.getElementById('chatbot-spam-text');
            if (alertBox && alertText) {
                alertText.innerText = message;
                alertBox.classList.remove('hidden');
                
                // Efek visual getar halus jika spam berulang
                alertBox.classList.add('animate-pulse');
                setTimeout(() => alertBox.classList.remove('animate-pulse'), 500);

                if (alertTimeout) clearTimeout(alertTimeout);
                alertTimeout = setTimeout(() => {
                    alertBox.classList.add('hidden');
                }, 5000);
            }
        }

        window.hideSpamAlert = function () {
            const alertBox = document.getElementById('chatbot-spam-alert');
            if (alertBox) alertBox.classList.add('hidden');
        };

        // Rolling Window Rate Limiter (SessionStorage)
        function checkClientRateLimit() {
            const now = Date.now();
            let timestamps = [];
            try {
                const stored = sessionStorage.getItem('sada_msg_timestamps');
                timestamps = stored ? JSON.parse(stored) : [];
            } catch (e) {
                timestamps = [];
            }

            // 1. Cek batas per 60 detik (Max 4 pesan/menit)
            const recent1Min = timestamps.filter(t => now - t < 60000);
            if (recent1Min.length >= ANTI_SPAM.MAX_MESSAGES_PER_MINUTE) {
                const oldest = recent1Min[0];
                const waitSeconds = Math.ceil((60000 - (now - oldest)) / 1000);
                return {
                    allowed: false,
                    reason: `Batas pesan tercapai (${ANTI_SPAM.MAX_MESSAGES_PER_MINUTE}/menit). Harap tunggu ${waitSeconds} detik.`
                };
            }

            // 2. Cek batas per sesi 15 menit (Max 25 pesan)
            const recent15Min = timestamps.filter(t => now - t < 900000);
            if (recent15Min.length >= ANTI_SPAM.MAX_MESSAGES_PER_SESSION) {
                return {
                    allowed: false,
                    reason: `Batas interaksi sesi tercapai (${ANTI_SPAM.MAX_MESSAGES_PER_SESSION} pesan). Mohon tunggu beberapa saat lagi.`
                };
            }

            recent15Min.push(now);
            try {
                sessionStorage.setItem('sada_msg_timestamps', JSON.stringify(recent15Min));
            } catch (e) {}

            return { allowed: true };
        }

        // Deteksi Spam Huruf/Karakter Berulang, Kata Toksik, atau Keyboard Smashing
        function validateAntiSpamInput(text) {
            const trimmed = text.trim();

            if (trimmed.length < ANTI_SPAM.MIN_LENGTH) {
                return { valid: false, reason: 'Pesan terlalu pendek. Mohon tuliskan pertanyaan yang jelas.' };
            }

            if (trimmed.length > ANTI_SPAM.MAX_LENGTH) {
                return { valid: false, reason: `Pesan melebihi batas maksimal (${ANTI_SPAM.MAX_LENGTH} karakter).` };
            }

            // 1. Deteksi Kata Toksik / Kasar di Client-Side
            const lowerText = trimmed.toLowerCase();
            for (let i = 0; i < CLIENT_TOXIC_WORDS.length; i++) {
                if (lowerText.includes(CLIENT_TOXIC_WORDS[i])) {
                    return { valid: false, reason: 'Mohon gunakan bahasa yang santun dan positif seputar SMKN 2 Mojokerto.' };
                }
            }

            // 2. Deteksi Huruf/Simbol Berulang Ekstrem (contoh: aaaaaaa, wooooooy, 1111111, ???????)
            const floodPattern = /(.)\1{5,}/i;
            if (floodPattern.test(trimmed)) {
                return { valid: false, reason: 'Pesan mengandung karakter berulang yang tidak wajar.' };
            }

            // 3. Deteksi Pengulangan Kata Beruntun (contoh: tes tes tes tes, halo halo halo halo)
            const wordRepeatPattern = /\b(\w+)\b(?:\s+\1\b){3,}/i;
            if (wordRepeatPattern.test(trimmed)) {
                return { valid: false, reason: 'Pesan mengandung kata berulang yang tidak wajar.' };
            }

            // 4. Deteksi Spam Duplikat Pesan Persis Sama dalam 45 Detik
            const now = Date.now();
            if (trimmed.toLowerCase() === lastSentMessage.toLowerCase() && (now - lastSentTime) < ANTI_SPAM.DUPLICATE_TIME_WINDOW) {
                const remainingSecs = Math.ceil((ANTI_SPAM.DUPLICATE_TIME_WINDOW - (now - lastSentTime)) / 1000);
                return { valid: false, reason: `Pertanyaan yang sama baru saja diajukan. Mohon tunggu ${remainingSecs} detik atau ajukan pertanyaan lain.` };
            }

            // 5. Deteksi Script Injection / XSS di Frontend
            if (/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi.test(trimmed) || /javascript:/i.test(trimmed) || /<iframe/i.test(trimmed)) {
                return { valid: false, reason: 'Format karakter input tidak diizinkan.' };
            }

            return { valid: true };
        }

        // Mulai Cooldown Visual Countdown pada Tombol Kirim & Kunci Input
        function startCooldown(seconds) {
            isCooldownActive = true;
            let remaining = seconds;

            const submitBtn = document.getElementById('chatbot-submit-btn');
            const sendIcon = document.getElementById('chatbot-send-icon');
            const cdText = document.getElementById('chatbot-cooldown-text');
            const inputField = document.getElementById('chatbot-input');

            if (submitBtn) submitBtn.disabled = true;
            if (sendIcon) sendIcon.classList.add('hidden');
            if (cdText) {
                cdText.classList.remove('hidden');
                cdText.innerText = `${remaining}s`;
            }
            if (inputField) {
                inputField.disabled = true;
                inputField.placeholder = `Tunggu jeda (${remaining}s)...`;
            }

            if (cooldownTimer) clearInterval(cooldownTimer);

            cooldownTimer = setInterval(() => {
                remaining -= 1;
                if (remaining <= 0) {
                    clearInterval(cooldownTimer);
                    isCooldownActive = false;
                    if (submitBtn) submitBtn.disabled = false;
                    if (sendIcon) sendIcon.classList.remove('hidden');
                    if (cdText) cdText.classList.add('hidden');
                    if (inputField) {
                        inputField.disabled = false;
                        inputField.placeholder = 'Ketik pesan...';
                        inputField.focus();
                    }
                } else {
                    if (cdText) cdText.innerText = `${remaining}s`;
                    if (inputField) inputField.placeholder = `Tunggu jeda (${remaining}s)...`;
                }
            }, 1000);
        }

        function getCurrentTimeString() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours.toString().padStart(2, '0')}:${minutes} ${ampm}`;
        }

        const initTimeEl = document.getElementById('bot-init-time');
        if (initTimeEl) initTimeEl.innerText = getCurrentTimeString();

        // Prevent Enter spam keydown
        document.addEventListener('DOMContentLoaded', function () {
            const inputField = document.getElementById('chatbot-input');
            if (inputField) {
                inputField.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        if (isCooldownActive) {
                            e.preventDefault();
                            showSpamAlert('Mohon tunggu jeda waktu selesai.');
                        } else if (isProcessing) {
                            e.preventDefault();
                            showSpamAlert('Sedang memproses jawaban, mohon tunggu sebentar.');
                        }
                    }
                });
            }
        });

        window.toggleChatbot = function (forcedState) {
            const chatWindow = document.getElementById('chatbot-window');
            const iconOpen = document.getElementById('chatbot-icon-open');
            const iconClose = document.getElementById('chatbot-icon-close');
            const inputField = document.getElementById('chatbot-input');
            const tooltipBubble = document.getElementById('chatbot-tooltip-bubble');

            isChatOpen = typeof forcedState === 'boolean' ? forcedState : !isChatOpen;

            if (isChatOpen) {
                chatWindow.classList.remove('hidden');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
                if (tooltipBubble) tooltipBubble.classList.add('hidden');
                setTimeout(() => inputField && !isCooldownActive && inputField.focus(), 150);
                scrollChatToBottom();
            } else {
                chatWindow.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                if (tooltipBubble) tooltipBubble.classList.remove('hidden');
            }
        };

        window.sendQuickPrompt = function (text) {
            if (isCooldownActive || isProcessing) {
                showSpamAlert('Mohon tunggu jeda sebelum memilih pertanyaan lain.');
                return;
            }
            const input = document.getElementById('chatbot-input');
            if (input) {
                input.value = text;
                submitMessage(text);
            }
        };

        const SADA_AVATAR_URL = '{{ asset('images/sada-avatar.svg') }}';

        window.resetChatHistory = function () {
            if (isProcessing) return;
            chatHistory = [];
            lastSentMessage = '';
            lastSentTime = 0;
            hideSpamAlert();

            const container = document.getElementById('chatbot-messages');
            if (!container) return;

            container.innerHTML = `
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-[#05529E] pl-9">SADA</span>
                    <div class="flex items-start gap-2">
                        <img src="${SADA_AVATAR_URL}" alt="SADA" class="h-7 w-7 object-contain shrink-0 mt-0.5">
                        <div class="max-w-[85%] rounded-2xl rounded-tl-none bg-white p-3.5 shadow-xs border border-slate-200/60 text-slate-800 leading-relaxed">
                            <p class="font-semibold text-slate-900">Riwayat dibersihkan ✨</p>
                            <p class="mt-1">Silakan ajukan pertanyaan baru seputar <strong>SMKN 2 Kota Mojokerto (SKANEDA)</strong>.</p>
                        </div>
                    </div>
                    <div class="pl-9 text-[10px] text-slate-400">${getCurrentTimeString()}</div>
                </div>
                <div id="chatbot-chips" class="pt-1 pl-8 flex flex-wrap gap-1.5">
                    <button type="button" onclick="sendQuickPrompt('Apa saja jurusan di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        🎓 Jurusan SKANEDA
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Bagaimana informasi PPDB SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        📋 Info PPDB
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Fasilitas apa saja di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        🏫 Fasilitas & Lab
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Bagaimana cara melihat denah interaktif sekolah di web ini?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        🗺️ Denah Interaktif
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Apa saja ekstrakurikuler dan prestasi di SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        🏆 Ekskul & Prestasi
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Apa visi dan misi SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        🎯 Visi & Misi
                    </button>
                    <button type="button" onclick="sendQuickPrompt('Di mana lokasi dan kontak resmi SMKN 2 Mojokerto?')" class="rounded-full border border-sky-200 bg-white px-3 py-1 text-[11px] font-semibold text-slate-800 shadow-2xs hover:bg-sky-50 hover:border-sky-400 transition cursor-pointer">
                        📍 Lokasi & Kontak
                    </button>
                </div>
            `;
        };

        window.handleChatSubmit = function (e) {
            e.preventDefault();
            const input = document.getElementById('chatbot-input');
            const message = input ? input.value.trim() : '';
            if (!message) return;

            submitMessage(message);
        };

        async function submitMessage(message) {
            // 1. Cek Status Pemrosesan Aktif (In-Flight Lock)
            if (isProcessing) {
                showSpamAlert('Sedang memproses pesan sebelumnya, harap tunggu...');
                return;
            }

            // 2. Cek Cooldown Wajib
            if (isCooldownActive) {
                showSpamAlert('Mohon tunggu jeda countdown selesai sebelum mengirim pesan lagi.');
                return;
            }

            // 3. Cek Honeypot Trap (Automated Spam Bots)
            const honeypot = document.getElementById('sada_security_code');
            if (honeypot && honeypot.value.trim() !== '') {
                showSpamAlert('Permintaan tidak valid.');
                return;
            }

            // 4. Validasi Karakter, Spam Pola, dan Duplikat
            const validation = validateAntiSpamInput(message);
            if (!validation.valid) {
                showSpamAlert(validation.reason);
                return;
            }

            // 5. Cek Batas Frekuensi Browser (Rolling Rate Limit)
            const rateLimit = checkClientRateLimit();
            if (!rateLimit.allowed) {
                showSpamAlert(rateLimit.reason);
                return;
            }

            hideSpamAlert();
            isProcessing = true;

            const input = document.getElementById('chatbot-input');
            const typingIndicator = document.getElementById('chatbot-typing');
            const chips = document.getElementById('chatbot-chips');

            if (input) input.value = '';
            if (chips) chips.style.display = 'none';

            // Catat pesan terakhir & timestamp
            lastSentMessage = message;
            lastSentTime = Date.now();

            // Tampilkan Pesan Pengguna
            appendUserMessage(message);

            // Tambahkan ke riwayat lokal
            chatHistory.push({ role: 'user', content: message });

            // Kunci & Mulai Countdown Cooldown JS
            startCooldown(ANTI_SPAM.COOLDOWN_SECONDS);

            if (typingIndicator) typingIndicator.classList.remove('hidden');
            scrollChatToBottom();

            try {
                const token = document.querySelector('input[name="_token"]')?.value || '';
                const response = await fetch(CHAT_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        message: message,
                        history: chatHistory.slice(-6),
                        sada_security_code: honeypot ? honeypot.value : ''
                    }),
                });

                const data = await response.json();

                if (response.ok && data.success && data.data?.reply) {
                    const botReply = data.data.reply;
                    appendBotMessage(botReply);
                    chatHistory.push({ role: 'model', content: botReply });
                } else {
                    const fallbackMsg = data.message || 'Maaf, terjadi kendala saat memproses jawaban.';
                    appendBotMessage(`⚠️ ${fallbackMsg}`);
                    if (response.status === 429) {
                        showSpamAlert('Aktivitas Anda terlalu cepat. Silakan tunggu beberapa detik.');
                    }
                }
            } catch (err) {
                console.error('Chatbot error:', err);
                appendBotMessage('⚠️ Maaf, koneksi ke server sedang terganggu. Silakan coba lagi.');
            } finally {
                isProcessing = false;
                if (typingIndicator) typingIndicator.classList.add('hidden');
                scrollChatToBottom();
            }
        }

        function appendUserMessage(text) {
            const container = document.getElementById('chatbot-messages');
            if (!container) return;

            const timeStr = getCurrentTimeString();
            const bubble = document.createElement('div');
            bubble.className = 'space-y-1';
            bubble.innerHTML = `
                <div class="text-right text-[11px] font-semibold text-slate-600 pr-2">Anda</div>
                <div class="flex justify-end">
                    <div class="max-w-[85%] rounded-2xl rounded-tr-none bg-[#05529E] text-white p-3.5 shadow-md text-xs leading-relaxed break-words font-medium">
                        ${escapeHtml(text)}
                    </div>
                </div>
                <div class="text-right text-[10px] text-slate-400 pr-2">${timeStr} ✓</div>
            `;
            container.appendChild(bubble);
            scrollChatToBottom();
        }

        function appendBotMessage(rawText) {
            const container = document.getElementById('chatbot-messages');
            if (!container) return;

            const timeStr = getCurrentTimeString();
            const formatted = formatSadaResponse(rawText);
            const bubble = document.createElement('div');
            bubble.className = 'space-y-1';
            bubble.innerHTML = `
                <span class="text-[11px] font-extrabold text-[#05529E] pl-9">SADA</span>
                <div class="flex items-start gap-2">
                    <img src="${SADA_AVATAR_URL}" alt="SADA" class="h-7 w-7 object-contain shrink-0 mt-0.5">
                    <div class="max-w-[85%] rounded-2xl rounded-tl-none bg-white p-3.5 shadow-sm border border-slate-200 text-slate-900 leading-relaxed text-xs break-words">
                        ${formatted}
                    </div>
                </div>
                <div class="pl-9 text-[10px] text-slate-400">${timeStr}</div>
            `;
            container.appendChild(bubble);
            scrollChatToBottom();
        }

        function formatSadaResponse(raw) {
            if (!raw) return '';
            
            // Check if response contains list of jurusan to render nice cards like in the mockup
            if ((raw.includes('Rekayasa Perangkat Lunak') || raw.includes('RPL')) && (raw.includes('DKV') || raw.includes('APHP') || raw.includes('Boga')) && raw.includes('Berikut jurusan')) {
                return `
                    <p class="font-bold text-slate-900 mb-2.5">Berikut jurusan yang tersedia di SMKN 2 Mojokerto:</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between rounded-xl bg-slate-50 p-2.5 border border-slate-200 hover:bg-sky-50 transition cursor-pointer" onclick="sendQuickPrompt('Jelaskan jurusan RPL di SMKN 2 Mojokerto')">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#05529E] text-white font-bold text-[11px] shadow-xs">RPL</span>
                                <span class="text-[11px] font-bold text-slate-900">Rekayasa Perangkat Lunak (RPL)</span>
                            </div>
                            <span class="text-blue-600 text-sm font-bold">›</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-slate-50 p-2.5 border border-slate-200 hover:bg-emerald-50 transition cursor-pointer" onclick="sendQuickPrompt('Jelaskan jurusan DKV di SMKN 2 Mojokerto')">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-600 text-white font-bold text-[11px] shadow-xs">DKV</span>
                                <span class="text-[11px] font-bold text-slate-900">Desain Komunikasi Visual (DKV)</span>
                            </div>
                            <span class="text-emerald-600 text-sm font-bold">›</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-slate-50 p-2.5 border border-slate-200 hover:bg-amber-50 transition cursor-pointer" onclick="sendQuickPrompt('Jelaskan jurusan APHP di SMKN 2 Mojokerto')">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-600 text-white font-bold text-[11px] shadow-xs">APHP</span>
                                <span class="text-[11px] font-bold text-slate-900">Agribisnis Pengolahan Hasil Pertanian (APHP)</span>
                            </div>
                            <span class="text-amber-600 text-sm font-bold">›</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-slate-50 p-2.5 border border-slate-200 hover:bg-orange-50 transition cursor-pointer" onclick="sendQuickPrompt('Jelaskan jurusan Tata Boga di SMKN 2 Mojokerto')">
                            <div class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-orange-600 text-white font-bold text-[11px] shadow-xs">Boga</span>
                                <span class="text-[11px] font-bold text-slate-900">Tata Boga (Kuliner)</span>
                            </div>
                            <span class="text-orange-600 text-sm font-bold">›</span>
                        </div>
                    </div>
                    <p class="mt-3 text-slate-700 font-medium">Klik salah satu jurusan untuk membaca penjelasan singkat & langsung melihat detailnya di website! 😊</p>
                `;
            }

            let html = escapeHtml(raw);

            // 1. Format Markdown first
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            html = html.replace(/(?:^|\n)[-*]\s+(.+)/g, '<br>• $1');
            html = html.replace(/\n/g, '<br>');

            // 2. Replace [LIHAT_JURUSAN:anchor_id:Jurusan Name] with clean button
            html = html.replace(/\[LIHAT_JURUSAN:([a-zA-Z0-9_-]+):(.*?)\]/g, function (match, anchorId, majorName) {
                return '<div class="mt-3 pt-2.5 border-t border-slate-100">' +
                    '<button type="button" onclick="scrollToMajorSection(\'' + anchorId + '\')" class="inline-flex items-center gap-2 rounded-xl bg-[#05529E] hover:bg-[#0885D1] px-3.5 py-2 text-xs font-bold text-white shadow-md transition cursor-pointer w-full justify-center">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-white shrink-0"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v4.59L7.3 9.74a.75.75 0 0 0-1.1 1.02l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 1 0-1.1-1.02l-1.95 2.1V6.75Z" clip-rule="evenodd" /></svg>' +
                    '<span>Lihat Profil Lengkap ' + majorName + '</span>' +
                    '</button>' +
                    '</div>';
            });

            // 3. Replace [LIHAT_DENAH:room_slug:Room Name] with Denah button
            html = html.replace(/\[LIHAT_DENAH:([a-zA-Z0-9_-]+):(.*?)\]/g, function (match, slug, roomName) {
                return '<div class="mt-2.5 pt-2 border-t border-slate-100">' +
                    '<button type="button" onclick="openDenahRoom(\'' + slug + '\')" class="inline-flex items-center gap-2 rounded-xl bg-sky-600 hover:bg-sky-700 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition cursor-pointer w-full justify-center">' +
                    '<span>🗺️ Lihat ' + roomName + ' di Denah</span>' +
                    '</button>' +
                    '</div>';
            });

            return html;
        }

        window.openDenahRoom = function (slug) {
            const denahEl = document.getElementById('denah');
            if (denahEl) {
                denahEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                window.dispatchEvent(new CustomEvent('sada:select-room', { detail: { slug: slug } }));
            } else {
                window.location.href = '/denah?room=' + encodeURIComponent(slug);
            }
        };

        window.scrollToMajorSection = function (anchorId) {
            const el = document.getElementById(anchorId);
            if (el) {
                // Scroll page smoothly to section
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Highlight card with stylish glow ring
                el.classList.add('ring-4', 'ring-blue-500', 'bg-blue-50/70', 'shadow-2xl');
                setTimeout(() => {
                    el.classList.remove('ring-4', 'ring-blue-500', 'bg-blue-50/70', 'shadow-2xl');
                }, 3000);
            }
        };

        function escapeHtml(string) {
            const div = document.createElement('div');
            div.innerText = string;
            return div.innerHTML;
        }

        function scrollChatToBottom() {
            const container = document.getElementById('chatbot-messages');
            if (container) {
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 50);
            }
        }
    })();
</script>
