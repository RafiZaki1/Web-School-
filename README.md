# Web-School-

Backend REST API untuk Landing Page dan Manajemen Sekolah.

## Tech Stack
- PHP (PHP Murni / Native PHP 8.3+)
- MySQL Database
- RESTful API Architecture (JSON Response Standard)

## Features & Modules
- **feat: Hero banner management**: Pengelolaan banner landing page sekolah beserta status aktif.
- **feat: School profile management**: Pengelolaan visi, misi, akreditasi, dan identitas profil sekolah.
- **feat: Gallery and album management**: Manajemen galeri kegiatan dan album foto sekolah.
- **feat: Room and facility management**: Manajemen data ruangan sekolah beserta fasilitas di setiap ruangan.
- **feat: Landing page aggregation and statistics**: Agregasi data landing page dan statistik ringkasan sekolah.

## API Endpoints Overview
- `GET /api/home` - Agregasi data landing page
- `GET /api/statistics` - Statistik dan ringkasan data sekolah
- `GET /api/school-profile` - Informasi profil sekolah
- `GET /api/heroes` - Daftar hero banner aktif
- `GET /api/galleries` - Galeri dan album foto sekolah
- `GET /api/rooms` - Daftar fasilitas dan ruangan sekolah
- `GET /api/rooms/{id}` - Detail ruangan dan daftar fasilitas di dalamnya
