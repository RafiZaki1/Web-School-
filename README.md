# Web-School-

Backend Laravel dengan frontend Blade untuk Landing Page dan REST API untuk manajemen sekolah.

## Tech Stack
- Laravel / PHP 8.3+
- Laravel Blade + Vite + Tailwind CSS
- MySQL Database
- RESTful API Architecture (JSON Response Standard)

## Features & Modules
- **feat: Hero banner management**: Pengelolaan banner landing page sekolah beserta status aktif.
- **feat: School profile management**: Pengelolaan visi, misi, akreditasi, dan identitas profil sekolah.
- **feat: Gallery and album management**: Manajemen galeri kegiatan dan album foto sekolah.
- **feat: Room and facility management**: Manajemen data ruangan sekolah beserta fasilitas di setiap ruangan.
- **feat: Landing page aggregation and statistics**: Agregasi data landing page dan statistik ringkasan sekolah.

## Routing Overview
- `GET /` - Landing page Blade, menggunakan data service Laravel secara langsung.
- `GET /api/v1/public/home` - Agregasi data landing page dalam JSON.
- `GET /api/v1/public/statistics` - Statistik sekolah.
- `GET /api/v1/public/school-profile` - Profil sekolah.
- `GET /api/v1/public/heroes` - Daftar hero aktif.
- `GET /api/v1/public/galleries` - Galeri sekolah.
- `GET /api/v1/public/rooms` - Daftar ruangan aktif.
- `GET /api/v1/public/rooms/{id}` - Detail ruangan dan fasilitas.
- `/api/v1/admin/*` - Endpoint CRUD admin, dilindungi middleware `auth`.
