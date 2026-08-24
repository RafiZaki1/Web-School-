<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomsData = [
            [
                'name' => 'Laboratorium RPL',
                'slug' => 'laboratorium-rpl',
                'building_name' => 'Gedung RPL Lantai 2',
                'description' => 'Laboratorium praktik modern untuk siswa jurusan Rekayasa Perangkat Lunak dengan perangkat komputer berspesifikasi tinggi.',
                'image' => 'rooms/laboratorium-rpl.jpg',
                'open_hours' => '07:00 - 16:00 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Komputer Praktik Core i7', 'icon' => 'computer', 'quantity' => 36, 'description' => 'Komputer spesifikasi tinggi untuk programming dan development'],
                    ['name' => 'Proyektor & Smart Screen', 'icon' => 'projector', 'quantity' => 1, 'description' => 'Untuk presentasi dan demonstrasi materi'],
                    ['name' => 'AC Split Inverter', 'icon' => 'air-conditioner', 'quantity' => 2, 'description' => 'Pendingin ruangan untuk kenyamanan belajar'],
                    ['name' => 'High Speed WiFi 100 Mbps', 'icon' => 'wifi', 'quantity' => 1, 'description' => 'Akses internet cepat untuk riset dan coding'],
                    ['name' => 'Meja Komputer Praktik', 'icon' => 'table', 'quantity' => 36, 'description' => 'Meja khusus laboratorium komputer'],
                    ['name' => 'Kursi Ergonomis', 'icon' => 'chair', 'quantity' => 36, 'description' => 'Kursi nyaman untuk sesi coding panjang'],
                ],
            ],
            [
                'name' => 'Perpustakaan Digital',
                'slug' => 'perpustakaan-digital',
                'building_name' => 'Gedung Utama Lantai 1',
                'description' => 'Pusat literasi dengan ribuan koleksi buku fisik dan e-book serta area baca yang tenang dan nyaman.',
                'image' => 'rooms/perpustakaan.jpg',
                'open_hours' => '07:30 - 16:30 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Rak Buku Utama', 'icon' => 'bookshelf', 'quantity' => 15, 'description' => 'Menampung lebih dari 5.000 judul buku'],
                    ['name' => 'Meja Baca Bersama', 'icon' => 'table', 'quantity' => 10, 'description' => 'Meja luas untuk kelompok belajar'],
                    ['name' => 'Kursi Baca', 'icon' => 'chair', 'quantity' => 40, 'description' => 'Tempat duduk nyaman untuk membaca'],
                    ['name' => 'Komputer Katalog (OPAC)', 'icon' => 'computer', 'quantity' => 4, 'description' => 'Pencarian buku secara elektronik'],
                    ['name' => 'WiFi Area Literasi', 'icon' => 'wifi', 'quantity' => 1, 'description' => 'Akses e-library dan jurnal digital'],
                ],
            ],
            [
                'name' => 'Kantin Sehat',
                'slug' => 'kantin-sehat',
                'building_name' => 'Area Belakang Kampus',
                'description' => 'Pusat kuliner sekolah yang menyediakan makanan dan minuman bergizi, higienis, dan terjangkau.',
                'image' => 'rooms/kantin.jpg',
                'open_hours' => '07:00 - 15:30 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Meja Makan Food Court', 'icon' => 'table', 'quantity' => 20, 'description' => 'Meja makan bersih berbahan stainless'],
                    ['name' => 'Kursi Kantin', 'icon' => 'chair', 'quantity' => 80, 'description' => 'Kursi makan fleksibel dan kokoh'],
                    ['name' => 'Wastafel & Hand Sanitizer', 'icon' => 'sink', 'quantity' => 4, 'description' => 'Fasilitas cuci tangan dengan sabun cair'],
                    ['name' => 'Tempat Sampah Terpilah', 'icon' => 'trash', 'quantity' => 6, 'description' => 'Organik, anorganik, dan B3'],
                ],
            ],
            [
                'name' => 'Lapangan Olahraga Multifungsi',
                'slug' => 'lapangan-olahraga',
                'building_name' => 'Outdoor Plaza',
                'description' => 'Lapangan outdoor serbaguna untuk olahraga basket, voli, futsal, serta kegiatan upacara dan apel.',
                'image' => 'rooms/lapangan.jpg',
                'open_hours' => '06:30 - 17:30 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Lapangan Basket Standar', 'icon' => 'basketball', 'quantity' => 1, 'description' => 'Lantai interlock dengan garis standar'],
                    ['name' => 'Lapangan Futsal / Voli', 'icon' => 'volleyball', 'quantity' => 1, 'description' => 'Dapat difungsikan untuk futsal dan voli'],
                    ['name' => 'Tribun Penonton', 'icon' => 'stairs', 'quantity' => 2, 'description' => 'Kapasitas hingga 200 penonton'],
                ],
            ],
            [
                'name' => 'Mushola Al-Kautsar',
                'slug' => 'mushola-al-kautsar',
                'building_name' => 'Gedung B Lantai 1',
                'description' => 'Tempat ibadah yang bersih dan sejuk untuk sholat berjamaah dan pembinaan rohani Islam.',
                'image' => 'rooms/mushola.jpg',
                'open_hours' => '04:30 - 18:30 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Area Wudhu Pria & Wanita', 'icon' => 'water', 'quantity' => 2, 'description' => 'Area terpisah dengan kran memadai'],
                    ['name' => 'Karpet Sajadah Tebal', 'icon' => 'rug', 'quantity' => 10, 'description' => 'Karpet wangi dan higienis'],
                    ['name' => 'Sound System & Mic Wireless', 'icon' => 'speaker', 'quantity' => 1, 'description' => 'Pengeras suara untuk adzan dan ceramah'],
                    ['name' => 'AC Pendingin Ruangan', 'icon' => 'air-conditioner', 'quantity' => 4, 'description' => 'Membuat suasana ibadah lebih khusyuk'],
                ],
            ],
            [
                'name' => 'Unit Kesehatan Sekolah (UKS)',
                'slug' => 'uks',
                'building_name' => 'Gedung Utama Lantai 1',
                'description' => 'Fasilitas penanganan pertama kesehatan siswa dan guru dengan tenaga medis yang siaga.',
                'image' => 'rooms/uks.jpg',
                'open_hours' => '07:30 - 15:30 WIB',
                'is_active' => true,
                'facilities' => [
                    ['name' => 'Tempat Tidur Medis', 'icon' => 'bed', 'quantity' => 3, 'description' => 'Tempat tidur pasien lengkap dengan sekat tirai'],
                    ['name' => 'Lemari Obat & P3K', 'icon' => 'first-aid', 'quantity' => 2, 'description' => 'Obat-obatan esensial dan perlengkapan darurat'],
                    ['name' => 'Timbangan & Pengukur Tinggi', 'icon' => 'scale', 'quantity' => 1, 'description' => 'Alat ukur parameter tubuh digital'],
                    ['name' => 'Tabung Oksigen & Regulator', 'icon' => 'oxygen', 'quantity' => 1, 'description' => 'Untuk bantuan pernapasan darurat'],
                ],
            ],
        ];

        foreach ($roomsData as $roomItem) {
            $facilities = $roomItem['facilities'] ?? [];
            unset($roomItem['facilities']);

            $room = Room::updateOrCreate(
                ['slug' => $roomItem['slug']],
                $roomItem
            );

            foreach ($facilities as $facility) {
                Facility::firstOrCreate(
                    [
                        'room_id' => $room->id,
                        'name' => $facility['name'],
                    ],
                    $facility
                );
            }
        }
    }
}
