<?php

namespace App\Services\LandingPage;

use App\Contracts\Interfaces\ChatbotServiceInterface;
use App\Contracts\Interfaces\HomeServiceInterface;
use App\Contracts\Interfaces\RoomServiceInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatbotService implements ChatbotServiceInterface
{
    public function __construct(
        protected HomeServiceInterface $homeService,
        protected RoomServiceInterface $roomService,
    ) {}

    /**
     * Send user message to AI provider or fallback.
     */
    public function sendMessage(string $message, array $history = []): array
    {
        $provider = config('chatbot.provider', 'gemini');
        $systemPrompt = $this->buildSystemPrompt();

        if ($provider === 'gemini') {
            $apiKey = config('chatbot.gemini.api_key');
            if (empty($apiKey)) {
                return $this->handleFallbackResponse($message, 'API Key Gemini belum disetel di file .env (GEMINI_API_KEY).');
            }

            return $this->callGeminiApi($message, $history, $systemPrompt, $apiKey);
        }

        if (in_array($provider, ['openai', 'groq', 'openrouter'])) {
            $apiKey = config('chatbot.openai.api_key');
            if (empty($apiKey)) {
                return $this->handleFallbackResponse($message, 'API Key OpenAI belum disetel di file .env (OPENAI_API_KEY).');
            }

            return $this->callOpenAiApi($message, $history, $systemPrompt, $apiKey);
        }

        return $this->handleFallbackResponse($message, "Provider '{$provider}' tidak dikenali.");
    }

    /**
     * Build knowledge context & strict boundaries regarding SMKN 2 Kota Mojokerto and this website.
     */
    protected function buildSystemPrompt(): string
    {
        $mdPath = base_path('knowledge_smkn2_mojokerto.md');
        $knowledgeContent = '';

        if (File::exists($mdPath)) {
            $knowledgeContent = File::get($mdPath);
        }

        return <<<PROMPT
Kamu adalah SADA (Sahabat & Asisten Digital Anda), asisten virtual cerdas, santun, dan ramah resmi dari SMK Negeri 2 Kota Mojokerto (dikenal sebagai SKANEDA / SMKN 2 Mojokerto).

==================================================
KNOWLEDGE BASE & INFORMASI RESMI SEKOLAH:
==================================================
{$knowledgeContent}

==================================================
ATURAN & BATASAN MUTLAK (STRICT SCOPE & GENTLE REFUSAL):
==================================================
1. HANYA JAWAB PERTANYAAN yang berkaitan dengan:
   - SMK Negeri 2 Kota Mojokerto / SKANEDA:
     * Topik Utama: 4 Jurusan resmi (RPL/PPLG, DKV, APHP, Tata Boga/Kuliner), Informasi PPDB & Syarat Masuk, Fasilitas & Lab, Visi & Misi, Ekstrakurikuler, Prestasi, Guru/Tendik, Mitra Industri (DUDI), Kontak & Alamat.
     * Pertanyaan Terbuka Seputar Sekolah: Pengguna bebas menanyakan hal apa pun mengenai kehidupan sekolah di SKANEDA, tips memilih jurusan, kegiatan positif siswa, tata tertib, dan lingkungan sekolah.
   - Fitur-Fitur Website Resmi Ini: Peta Denah Interaktif lantai 1 & 2, Navigasi Halaman, Sambutan Kepala Sekolah, Kontak, Galeri, dan Berita.

2. DILARANG MENJAWAB TOPIK DI LUAR SKANEDA & WEBSITE INI:
   - Dilarang menjawab topik politik, berita/gosip luar, selebriti, coding umum di luar kurikulum SMK, ramalan, atau hal negatif/provokatif.

3. JIKA DITANYA HAL DI LUAR TOPIK ATAU HAL NEGATIF, JAWAB DENGAN SANGAT LEMBUT, RAMAH, DAN PENUH SENYUM:
   "Mohon maaf dengan senang hati, saya SADA asisten virtual yang khusus diprogram untuk berbagi informasi positif seputar **SMK Negeri 2 Kota Mojokerto (SKANEDA)** dan website ini 😊. Apakah ada informasi terkait jurusan kami (RPL, DKV, APHP, Tata Boga), fasilitas, kegiatan siswa, atau pendaftaran PPDB yang dapat saya bantu? ✨"

4. Gaya Bahasa: Selalu gunakan bahasa Indonesia yang santun, hangat, menginspirasi, positif, komunikatif, dan rapi menggunakan markdown (poin-poin, bold).
PROMPT;
    }

    /**
     * Call Google Gemini API.
     */
    protected function callGeminiApi(string $message, array $history, string $systemPrompt, string $apiKey): array
    {
        try {
            $model = config('chatbot.gemini.model', 'gemini-1.5-flash');
            $baseUrl = config('chatbot.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');
            $url = "{$baseUrl}/models/{$model}:generateContent?key={$apiKey}";

            $contents = [];

            // Add previous history if any
            foreach ($history as $item) {
                $role = ($item['role'] ?? 'user') === 'bot' || ($item['role'] ?? '') === 'model' || ($item['role'] ?? '') === 'assistant'
                    ? 'model'
                    : 'user';
                $text = (string) ($item['content'] ?? $item['text'] ?? '');
                if (trim($text) !== '') {
                    $contents[] = [
                        'role' => $role,
                        'parts' => [['text' => $text]],
                    ];
                }
            }

            // Add current message
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $message]],
            ];

            $payload = [
                'contents' => $contents,
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemPrompt],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => config('chatbot.temperature', 0.5),
                    'maxOutputTokens' => config('chatbot.max_tokens', 800),
                ],
            ];

            $response = Http::timeout(25)->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $reply = data_get($data, 'candidates.0.content.parts.0.text');

                if (!empty($reply)) {
                    return [
                        'status' => 'success',
                        'reply' => trim($reply),
                        'provider' => 'gemini',
                        'model' => $model,
                    ];
                }
            }

            Log::error('Gemini API Error: ' . $response->body());
            return $this->handleFallbackResponse($message, 'Gagal mendapatkan respon dari server Gemini AI (' . $response->status() . ').');
        } catch (Throwable $e) {
            Log::error('ChatbotService Gemini Exception: ' . $e->getMessage());
            return $this->handleFallbackResponse($message, 'Terjadi kendala koneksi ke server AI.');
        }
    }

    /**
     * Call OpenAI / Groq / OpenRouter API.
     */
    protected function callOpenAiApi(string $message, array $history, string $systemPrompt, string $apiKey): array
    {
        try {
            $model = config('chatbot.openai.model', 'gpt-4o-mini');
            $baseUrl = rtrim(config('chatbot.openai.base_url', 'https://api.openai.com/v1'), '/');
            $url = "{$baseUrl}/chat/completions";

            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
            ];

            foreach ($history as $item) {
                $role = ($item['role'] ?? 'user') === 'bot' || ($item['role'] ?? '') === 'model' || ($item['role'] ?? '') === 'assistant'
                    ? 'assistant'
                    : 'user';
                $text = (string) ($item['content'] ?? $item['text'] ?? '');
                if (trim($text) !== '') {
                    $messages[] = ['role' => $role, 'content' => $text];
                }
            }

            $messages[] = ['role' => 'user', 'content' => $message];

            $payload = [
                'model' => $model,
                'messages' => $messages,
                'temperature' => config('chatbot.temperature', 0.5),
                'max_tokens' => config('chatbot.max_tokens', 800),
            ];

            $response = Http::withToken($apiKey)->timeout(25)->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $reply = data_get($data, 'choices.0.message.content');

                if (!empty($reply)) {
                    return [
                        'status' => 'success',
                        'reply' => trim($reply),
                        'provider' => 'openai',
                        'model' => $model,
                    ];
                }
            }

            Log::error('OpenAI API Error: ' . $response->body());
            return $this->handleFallbackResponse($message, 'Gagal mendapatkan respon dari server OpenAI (' . $response->status() . ').');
        } catch (Throwable $e) {
            Log::error('ChatbotService OpenAI Exception: ' . $e->getMessage());
            return $this->handleFallbackResponse($message, 'Terjadi kendala koneksi ke server AI.');
        }
    }

    /**
     * Fallback response strictly customized for SMKN 2 Kota Mojokerto.
     */
    protected function handleFallbackResponse(string $message, string $reason = ''): array
    {
        $normalized = mb_strtolower(trim($message));
        $reply = '';

        if (str_contains($normalized, 'rpl') || str_contains($normalized, 'rekayasa perangkat lunak') || str_contains($normalized, 'coding') || str_contains($normalized, 'programmer')) {
            $reply = "💻 **Rekayasa Perangkat Lunak (RPL)**:\n\n"
                   . "Jurusan RPL mempelajari pembuatan aplikasi web, mobile app (Android/iOS), pengelolaan basis data, dan rekayasa software modern.\n\n"
                   . "• **Prospek Karir**: Software Engineer, Web/Mobile Developer, UI/UX Designer, IT Support.\n"
                   . "• **Fasilitas**: Lab Komputer RPL Spek Tinggi.\n\n"
                   . "[LIHAT_JURUSAN:jurusan-rpl:Rekayasa Perangkat Lunak]";
        } elseif (str_contains($normalized, 'dkv') || str_contains($normalized, 'desain') || str_contains($normalized, 'visual') || str_contains($normalized, 'grafis') || str_contains($normalized, 'animasi') || str_contains($normalized, 'video')) {
            $reply = "🎨 **Desain Komunikasi Visual (DKV)**:\n\n"
                   . "Jurusan DKV berfokus pada desain grafis, ilustrasi digital, videografi, fotografi studio, animasi 2D/3D, dan branding kreatif.\n\n"
                   . "• **Prospek Karir**: Graphic Designer, Video Editor, Content Creator, Animator, Fotografer.\n"
                   . "• **Fasilitas**: Studio Foto & Desain DKV Lengkap.\n\n"
                   . "[LIHAT_JURUSAN:jurusan-dkv:Desain Komunikasi Visual]";
        } elseif (str_contains($normalized, 'aphp') || str_contains($normalized, 'pertanian') || str_contains($normalized, 'pangan') || str_contains($normalized, 'agribisnis')) {
            $reply = "🌾 **Agribisnis Pengolahan Hasil Pertanian (APHP)**:\n\n"
                   . "Jurusan APHP mempelajari teknologi pengolahan hasil panen/tani menjadi produk pangan bernilai jual tinggi dengan standar uji mutu (HACCP).\n\n"
                   . "• **Prospek Karir**: Quality Control (QC) Pangan, Teknisi Pengolahan Hasil Panen, Wirausaha Pangan.\n"
                   . "• **Fasilitas**: Laboratorium Pengolahan Pangan & Uji Mutu.\n\n"
                   . "[LIHAT_JURUSAN:jurusan-aphp:Agribisnis Pengolahan Hasil Pertanian]";
        } elseif (str_contains($normalized, 'boga') || str_contains($normalized, 'kuliner') || str_contains($normalized, 'masak') || str_contains($normalized, 'chef') || str_contains($normalized, 'pastry') || str_contains($normalized, 'kue')) {
            $reply = "🍳 **Tata Boga (Kuliner)**:\n\n"
                   . "Jurusan Tata Boga mempelajari seni memasak masakan nusantara & internasional, pastry & bakery (kue/roti), serta manajemen restoran & tata hidang.\n\n"
                   . "• **Prospek Karir**: Chef / Cook Hotel & Resto, Pastry Chef, Barista, Pengusaha Kuliner.\n"
                   . "• **Fasilitas**: Kitchen Lab Standar Hotel & Ruang Simulasi Restoran.\n\n"
                   . "[LIHAT_JURUSAN:jurusan-boga:Tata Boga (Kuliner)]";
        } elseif (str_contains($normalized, 'jurusan') || str_contains($normalized, 'program') || str_contains($normalized, 'keahlian')) {
            $reply = "Berikut jurusan yang tersedia di SMKN 2 Mojokerto:\n\n"
                   . "- **Rekayasa Perangkat Lunak (RPL)**\n"
                   . "- **Desain Komunikasi Visual (DKV)**\n"
                   . "- **Agribisnis Pengolahan Hasil Pertanian (APHP)**\n"
                   . "- **Tata Boga (Kuliner)**\n\n"
                   . "Klik salah satu jurusan untuk melihat penjelasan ringkas atau langsung menuju bagian profil jurusan di website! 😊";
        } elseif (str_contains($normalized, 'visi') || str_contains($normalized, 'misi') || str_contains($normalized, 'tujuan') || str_contains($normalized, 'motto') || str_contains($normalized, 'tagline')) {
            $reply = "🎯 **Visi & Misi SMKN 2 Kota Mojokerto**:\n\n"
                   . "- **Visi**: Menjadi lembaga pendidikan dan pelatihan vokasi yang unggul, berkarakter, berwawasan lingkungan, dan berstandar internasional.\n"
                   . "- **Misi**: Menyelenggarakan pembelajaran berbasis proyek industri, membekali peserta didik dengan kompetensi abad ke-21, dan membangun kemitraan strategis dengan DUDI.\n"
                   . "- **Motto**: DISIPLIN • BERAKHLAK • BERPRESTASI ✨";
        } elseif (str_contains($normalized, 'ppdb') || str_contains($normalized, 'daftar') || str_contains($normalized, 'syarat') || str_contains($normalized, 'masuk')) {
            $reply = "📋 **Informasi PPDB SMKN 2 Kota Mojokerto**:\n\n"
                   . "Penerimaan Peserta Didik Baru (PPDB) membuka beberapa jalur masuk:\n"
                   . "1. Jalur Afirmasi\n"
                   . "2. Jalur Perpindahan Tugas Orang Tua\n"
                   . "3. Jalur Prestasi Hasil Lomba & Nilai Rapor\n"
                   . "4. Jalur Zonasi SMK\n\n"
                   . "Untuk pendaftaran resmi silakan kunjungi portal PPDB Jatim atau hubungi panitia PPDB SMKN 2 Mojokerto.";
        } elseif (str_contains($normalized, 'fasilitas') || str_contains($normalized, 'ruang') || str_contains($normalized, 'lab') || str_contains($normalized, 'bengkel') || str_contains($normalized, 'studio') || str_contains($normalized, 'dapur')) {
            $reply = "🏫 **Fasilitas di SMKN 2 Kota Mojokerto**:\n\n"
                   . "- Lab Komputer Software Development (RPL)\n"
                   . "- Studio Desain Grafis & Fotografi (DKV)\n"
                   . "- Lab Pengolahan Pangan & Uji Mutu (APHP)\n"
                   . "- Dapur Praktik Kuliner & Restoran (Tata Boga)\n"
                   . "- Perpustakaan Digital (E-Library)\n"
                   . "- Lapangan Olahraga, Aula Serbaguna, & Masjid Sekolah";
        } elseif (str_contains($normalized, 'alamat') || str_contains($normalized, 'lokasi') || str_contains($normalized, 'kontak') || str_contains($normalized, 'telepon') || str_contains($normalized, 'email')) {
            $reply = "📍 **Lokasi & Kontak SMKN 2 Kota Mojokerto**:\n\n"
                   . "- **Alamat**: Jl. Raya Ijen No. 9, Wates, Kec. Magersari, Kota Mojokerto, Jawa Timur 61317\n"
                   . "- **Email**: info@smkn2mojokertokota.sch.id";
        } elseif (str_contains($normalized, 'ekskul') || str_contains($normalized, 'ekstrakurikuler') || str_contains($normalized, 'kegiatan') || str_contains($normalized, 'osis') || str_contains($normalized, 'pramuka')) {
            $reply = "🏆 **Ekstrakurikuler SMKN 2 Kota Mojokerto**:\n\n"
                   . "Pramuka (Wajib), Paskibra, PMR, OSIS, Rohis, Futsal, Basket, Voli, Tari Tradisional, Paduan Suara, IT/Cyber Club, dan Jurnalistik.";
        } elseif (str_contains($normalized, 'halo') || str_contains($normalized, 'hai') || str_contains($normalized, 'assalamu') || str_contains($normalized, 'pagi') || str_contains($normalized, 'siang') || str_contains($normalized, 'sore') || str_contains($normalized, 'malam')) {
            $reply = "Halo! 👋\nSelamat datang di Roomchat SADA.\nAda yang bisa saya bantu hari ini seputar informasi positif dan fitur website SMKN 2 Mojokerto? 😊";
        } else {
            // Check if user is asking non-school / negative topics
            $reply = "Mohon maaf dengan senang hati, saya SADA asisten virtual yang khusus diprogram untuk berbagi informasi positif seputar **SMK Negeri 2 Kota Mojokerto** dan website ini 😊.\n\nApakah ada informasi terkait **Jurusan** (RPL, DKV, APHP, Tata Boga), **Fasilitas**, **Visi & Misi**, atau **PPDB** di SMKN 2 Mojokerto yang dapat saya bantu? ✨";
        }

        return [
            'status' => 'fallback',
            'reply' => $reply,
            'note' => $reason,
        ];
    }
}
