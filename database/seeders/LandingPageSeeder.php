<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Hero;
use App\Models\SchoolProfile;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Hero Landing Page
        Hero::firstOrCreate(
            ['title' => 'Membangun Generasi Unggul dan Berakhlak Mulia'],
            [
                'school_name' => 'Jakarta Honors International College (JHIC)',
                'description' => 'Mewujudkan pendidikan berstandar internasional dengan fondasi karakter kepemimpinan yang tangguh, adaptif, dan berwawasan global.',
                'background_image' => null,
                'button_text' => 'Daftar Sekarang',
                'button_url' => 'https://jhic.sch.id/pendaftaran',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // 2. Galeri Foto
        $galleries = [
            [
                'title' => 'Kegiatan Pembelajaran Berbasis Proyek (PjBL)',
                'image' => 'galleries/sample-activity-1.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Juara 1 Olimpiade Sains Nasional Tingkat Provinsi',
                'image' => 'galleries/sample-achievement-1.jpg',
                'category' => 'Prestasi',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Laboratorium Komputer & Multimedia Modern',
                'image' => 'galleries/sample-facility-1.jpg',
                'category' => 'Fasilitas',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Ekstrakurikuler Robotik dan Coding',
                'image' => 'galleries/sample-activity-2.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::firstOrCreate(
                ['title' => $gallery['title']],
                $gallery
            );
        }

        // 3. Profil Sekolah & Sambutan Kepala Sekolah
        SchoolProfile::updateOrCreate(
            ['id' => 1],
            [
                'school_name' => 'Jakarta Honors International College (JHIC)',
                'school_logo' => null,
                'principal_name' => 'Dr. H. Muhammad Arifin, M.Pd.',
                'principal_position' => 'Kepala Sekolah',
                'principal_photo' => null,
                'welcome_message' => 'Selamat datang di website resmi Jakarta Honors International College (JHIC). Kami berkomitmen memberikan pengalaman belajar terbaik yang memadukan keunggulan akademik, teknologi modern, dan penanaman nilai budi pekerti luhur bagi seluruh peserta didik kami.',
                'background_image' => null,
                'established_year' => 2014,
            ]
        );
    }
}
