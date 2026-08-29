"use client";

import { useState, useEffect, useRef, useCallback } from "react";

export default function JurusanSection() {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [visibleCount, setVisibleCount] = useState(3);
  const [selectedJurusan, setSelectedJurusan] = useState(null);

  const touchStartX = useRef(0);
  const touchEndX = useRef(0);

  const jurusanList = [
    {
      id: "aphp",
      code: "APHP",
      fullName: "Agribisnis Pengolahan Hasil Pertanian",
      image: "/aphp.jpeg",
      tag: "Teknologi & Industri Pangan",
      akreditasi: "A (Unggul)",
      desc: "Agribisnis Pengolahan Hasil Pertanian (APHP) membekali siswa dengan keterampilan mengolah hasil pertanian menjadi produk berkualitas, dari proses produksi, pengemasan, hingga pemasaran.",
      fullOverview:
        "Program Keahlian APHP mendidik peserta didik agar mampu mengolah komoditas hasil pertanian nabati dan hewani menjadi produk olahan pangan yang bernilai ekonomis tinggi, higienis, dan sesuai standar keamanan pangan industri (GMP & HACCP).",
      kompetensi: [
        "Pengolahan Hasil Nabati (Buah, Sayur, Umbi-umbian)",
        "Pengolahan Hasil Hewani (Daging, Susu, Ikan)",
        "Teknologi Roti, Kue & Pastry (Bakery TEFA)",
        "Pengendalian Mutu & Keamanan Pangan (Quality Control)",
        "Pengemasan & Penyimpanan Produk Pertanian",
        "Kewirausahaan Produk Pangan Kreatif",
      ],
      karir: [
        "Quality Control / QA Industri Makanan & Minuman",
        "Operator / Teknisi Pengolahan Pangan",
        "Wirausaha Mandiri Produk Olahan Pangan (Foodpreneur)",
        "Laboran Pengujian Mutu Pangan",
        "Staf R&D Produk Pangan",
      ],
      fasilitas: "Lab Kimia Pangan, Lab Sensoris, Workshop Pengolahan Nabati & Hewani, Unit Produksi TEFA Bakery.",
      labTarget: "laboratorium-aphp",
    },
    {
      id: "lps",
      code: "LPS",
      fullName: "Layanan Perbankan Syariah",
      image: "/lps.jpeg",
      tag: "Bisnis & Keuangan Syariah",
      akreditasi: "A (Unggul)",
      desc: "Layanan Perbankan Syariah (LPS) membekali siswa dengan keterampilan pelayanan dan administrasi perbankan berdasarkan prinsip syariah sebagai persiapan memasuki dunia kerja.",
      fullOverview:
        "Program Keahlian LPS menyiapkan tenaga profesional tingkat menengah yang terampil dalam operasional perbankan syariah, akuntansi keuangan, customer service, teller perbankan, dan administrasi pembiayaan syariah.",
      kompetensi: [
        "Prinsip Dasar Ekonomi & Fiqih Muamalah Syariah",
        "Operasional Teller & Customer Service Perbankan",
        "Akuntansi Perbankan Syariah & Komputer Akuntansi",
        "Administrasi Pembiayaan & Pengelolaan Dana Tabungan",
        "Pelayanan Prima (Service Excellence) & Public Speaking",
        "Pengoperasian Mini Bank Digital",
      ],
      karir: [
        "Frontliner (Teller & Customer Service) Bank Syariah / Konvensional",
        "Staff Administrasi Keuangan di Lembaga Keuangan Mikro / BMT / Koperasi",
        "Staf Back Office & Kliring Perbankan",
        "Staf Pembukuan & Akuntansi Perusahaan",
        "Pengelola Unit Usaha Jasa Keuangan",
      ],
      fasilitas: "Laboratorium Mini Bank Syariah berstandar industri, Software Core Banking, Ruang Simulasi Front Office.",
      labTarget: "ruang-mini-bank",
    },
    {
      id: "rpl",
      code: "RPL",
      fullName: "Rekayasa Perangkat Lunak",
      image: "/rpl.jpeg",
      tag: "Teknologi Informasi & Komputer",
      akreditasi: "A (Unggul)",
      desc: "Rekayasa Perangkat Lunak (RPL) membekali siswa dengan keahlian komputasi, pemrograman aplikasi web dan mobile, perancangan database, dan rekayasa software modern.",
      fullOverview:
        "Program Keahlian RPL membekali siswa dengan keahlian komprehensif dalam siklus pengembangan perangkat lunak modern (SDLC), mulai dari perancangan arsitektur, koding Fullstack Web & Mobile, manajemen database relasional/NoSQL, UI/UX design, hingga Internet of Things (IoT).",
      kompetensi: [
        "Pemrograman Web Modern (React, Next.js, Laravel, Tailwind)",
        "Mobile Application Development (Flutter / Android)",
        "Database Design & SQL Architecture (MySQL, PostgreSQL)",
        "Pemrograman Berorientasi Objek (OOP) & Algoritma",
        "UI/UX Design & Prototyping (Figma)",
        "Version Control (Git/GitHub) & CI/CD Deployment",
      ],
      karir: [
        "Junior Web Developer (Frontend / Backend)",
        "Mobile App Developer (Android/iOS)",
        "UI/UX Designer & Product Prototyper",
        "Database Administrator & IT Technical Support",
        "Software QA & Automation Tester",
      ],
      fasilitas: "3 Laboratorium Komputer RPL ber-AC dengan koneksi Gigabit LAN, Server Cloud Lokal, Smart Display Interaktif.",
      labTarget: "laboratorium-rpl",
    },
    {
      id: "dkv",
      code: "DKV",
      fullName: "Desain Komunikasi Visual",
      image: "/dkv.jpeg",
      tag: "Seni Kreatif & Multimedia",
      akreditasi: "A (Unggul)",
      desc: "Desain Komunikasi Visual (DKV) mengembangkan kreativitas siswa dalam desain grafis, ilustrasi digital, videografi, fotografi studio, animasi, dan perancangan identitas visual kreatif.",
      fullOverview:
        "Program Keahlian DKV mengembangkan daya kreasi visual siswa dalam merancang pesan komunikasi persuasif melalui media cetak, digital, motion graphic, fotografi studio, dan produksi videografi komersial.",
      kompetensi: [
        "Desain Grafis Periklanan & Branding (Adobe Photoshop, Illustrator)",
        "Fotografi Studio & Penataan Cahaya Profesional",
        "Videografi, Sinematografi & Editing Video (Premiere Pro, After Effects)",
        "Ilustrasi Digital & Vector Art",
        "Animasi 2D / 3D & Motion Graphic",
        "Teknologi Percetakan & Finishing Produk Grafika",
      ],
      karir: [
        "Graphic Designer & Brand Identity Designer",
        "Fotografer Studio & Commercial Videographer",
        "Video Editor & Motion Graphic Artist",
        "Content Creator & Social Media Visual Strategist",
        "Illustrator & 2D Animator",
      ],
      fasilitas: "Studio Fotografi Profesional, Studio Podcast/Audio, Lab Multimedia Mac/PC High-End, Workshop Percetakan.",
      labTarget: "laboratorium-dkv",
    },
    {
      id: "boga",
      code: "Tata Boga",
      fullName: "Kuliner & Tata Hidang",
      image: "/kuliner.jpeg",
      tag: "Pariwisata & Hospitaliti",
      akreditasi: "A (Unggul)",
      desc: "Tata Boga (Kuliner) membekali siswa dengan keahlian seni memasak masakan nusantara dan kontinental, pastry & bakery, table setup, hingga manajemen operasional restoran dan kuliner.",
      fullOverview:
        "Program Keahlian Tata Boga (Kuliner) melatih siswa menguasai teknik pengolahan makanan nusantara, kontinental, oriental, seni dekorasi pastry & bakery, tata hidang restoran bintang, serta higienitas sanitasi makanan dan kewirausahaan kuliner.",
      kompetensi: [
        "Pengolahan Makanan Nusantara & Tradisional",
        "Pengolahan Masakan Kontinental (Western Cuisine)",
        "Pastry, Bakery, Cake Decorating & Confectionery",
        "Pelayanan Makanan & Minuman (Food & Beverage Service)",
        "Hygiene, Sanitasi & Keselamatan Kerja Dapur (HACCP)",
        "Cost Control & Manajemen Operasional Restoran",
      ],
      karir: [
        "Commis Chef / Cook di Hotel & Restoran Berbintang",
        "Pastry & Bakery Chef Profesional",
        "Food & Beverage Server / Barista",
        "Wirausaha Kuliner & Catering Service",
        "Food Stylist & Kitchen Operations Staff",
      ],
      fasilitas: "Dapur Standar Hotel Bintang, Ruang Praktik Restoran & Tata Hidang, Bakery Workshop, Lab Barista.",
      labTarget: "laboratorium-kuliner",
    },
  ];

  const total = jurusanList.length;

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth >= 1024) {
        setVisibleCount(3);
      } else if (window.innerWidth >= 640) {
        setVisibleCount(2);
      } else {
        setVisibleCount(1);
      }
    };

    handleResize();
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const maxIndex = Math.max(0, total - visibleCount);

  const next = useCallback(() => {
    setCurrentIndex((prev) => (prev < maxIndex ? prev + 1 : 0));
  }, [maxIndex]);

  const prev = useCallback(() => {
    setCurrentIndex((prev) => (prev > 0 ? prev - 1 : maxIndex));
  }, [maxIndex]);

  // Touch Swipe Handlers for Mobile
  const handleTouchStart = (e) => {
    touchStartX.current = e.targetTouches[0].clientX;
  };

  const handleTouchMove = (e) => {
    touchEndX.current = e.targetTouches[0].clientX;
  };

  const handleTouchEnd = () => {
    const diff = touchStartX.current - touchEndX.current;
    if (Math.abs(diff) > 50) {
      if (diff > 0) {
        next();
      } else {
        prev();
      }
    }
  };

  // Close modal on Escape key
  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === "Escape") setSelectedJurusan(null);
    };
    window.addEventListener("keydown", handleKeyDown);
    return () => window.removeEventListener("keydown", handleKeyDown);
  }, []);

  return (
    <section id="jurusan" className="border-t border-slate-200/80 bg-[#f8fafc] py-16 sm:py-20 px-5 lg:px-8">
      <div className="mx-auto max-w-6xl">
        {/* Header matching mockup */}
        <div className="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
          <h2 className="text-2xl sm:text-3xl font-black text-[#05529E] tracking-wide uppercase">
            JURUSAN
          </h2>
          <p className="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
            Kisah sukses para alumni yang telah berkiprah di dunia industri dan perguruan tinggi ternama.
          </p>
        </div>

        {/* Carousel Slider Container */}
        <div
          className="relative overflow-hidden pb-4"
          onTouchStart={handleTouchStart}
          onTouchMove={handleTouchMove}
          onTouchEnd={handleTouchEnd}
        >
          <div
            className="flex transition-transform duration-500 ease-out gap-6"
            style={{
              transform: `translateX(calc(-${currentIndex} * (100% + 1.5rem) / ${visibleCount}))`,
            }}
          >
            {jurusanList.map((item, idx) => (
              <div
                key={idx}
                className="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] shrink-0 flex"
              >
                <div
                  id={`jurusan-${item.id}`}
                  className="w-full flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center group"
                >
                  <div>
                    {/* Photo Container */}
                    <div
                      onClick={() => setSelectedJurusan(item)}
                      className="rounded-2xl overflow-hidden mb-5 aspect-[3/3.8] bg-slate-50 border border-slate-100 shadow-inner cursor-pointer relative group-hover:opacity-95 transition"
                    >
                      <img
                        src={item.image}
                        alt={`Jurusan ${item.code} SMKN 2 Mojokerto`}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      />
                      <div className="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/20 transition-all flex items-center justify-center">
                        <span className="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 backdrop-blur-md text-[#05529E] text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                          Klik untuk Detail
                        </span>
                      </div>
                    </div>

                    {/* Major Title (Clickable) */}
                    <h3
                      onClick={() => setSelectedJurusan(item)}
                      className="text-xl font-extrabold text-slate-900 hover:text-[#05529E] cursor-pointer transition inline-block"
                    >
                      {item.code}
                    </h3>
                    <p className="text-xs font-bold text-sky-600 mt-1">{item.fullName}</p>
                    <p className="mt-3 text-xs leading-relaxed text-slate-600 font-normal italic text-left">
                      {item.desc}
                    </p>
                  </div>

                  {/* Action Link to Modal */}
                  <div className="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <button
                      type="button"
                      onClick={() => setSelectedJurusan(item)}
                      className="text-xs font-bold text-[#05529E] hover:text-[#0284c7] inline-flex items-center gap-1 transition cursor-pointer"
                    >
                      <span>Lihat Detail Program</span>
                      <span>→</span>
                    </button>
                    <span className="text-[11px] font-semibold text-slate-400">Akreditasi A</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Bottom Navigation Arrows */}
        <div className="mt-8 flex items-center justify-center gap-3">
          <button
            type="button"
            onClick={prev}
            aria-label="Jurusan Sebelumnya"
            className="h-10 w-10 rounded-full border border-slate-200 bg-white text-slate-700 flex items-center justify-center hover:bg-slate-100 transition shadow-2xs cursor-pointer active:scale-95"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button
            type="button"
            onClick={next}
            aria-label="Jurusan Berikutnya"
            className="h-10 w-10 rounded-full bg-[#05529E] text-white flex items-center justify-center hover:bg-[#0766c6] transition shadow-sm cursor-pointer active:scale-95"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

      {/* ================= DETAIL JURUSAN MODAL ================= */}
      {selectedJurusan && (
        <div
          id="jurusan-detail-modal"
          className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/70 backdrop-blur-sm animate-fade-in"
          onClick={() => setSelectedJurusan(null)}
        >
          <div
            className="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white shadow-2xl border border-slate-200/90 text-slate-900 scrollbar-none"
            onClick={(e) => e.stopPropagation()}
          >
            {/* Modal Header Image */}
            <div className="relative h-48 sm:h-56 bg-slate-900 overflow-hidden">
              <img
                src={selectedJurusan.image}
                alt={selectedJurusan.fullName}
                className="w-full h-full object-cover"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent" />

              {/* Close Button */}
              <button
                type="button"
                onClick={() => setSelectedJurusan(null)}
                aria-label="Tutup"
                className="absolute top-4 right-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-md transition cursor-pointer"
              >
                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>

              {/* Title & Badge on Image */}
              <div className="absolute bottom-4 left-5 right-5 text-white">
                <div className="flex items-center gap-2">
                  <span className="rounded-full bg-sky-500 px-3 py-0.5 text-xs font-black uppercase text-white shadow-xs">
                    {selectedJurusan.code}
                  </span>
                  <span className="rounded-full bg-emerald-500/90 px-3 py-0.5 text-xs font-bold text-white shadow-xs">
                    {selectedJurusan.akreditasi}
                  </span>
                </div>
                <h3 className="mt-1.5 text-xl sm:text-2xl font-black text-white leading-tight drop-shadow-sm">
                  {selectedJurusan.fullName}
                </h3>
              </div>
            </div>

            {/* Modal Body Content */}
            <div className="p-5 sm:p-7 space-y-6">
              {/* Overview */}
              <div>
                <h4 className="text-xs font-extrabold uppercase tracking-wider text-[#05529E] mb-1.5">
                  Profil Program Keahlian
                </h4>
                <p className="text-xs sm:text-sm leading-relaxed text-slate-700 font-normal">
                  {selectedJurusan.fullOverview}
                </p>
              </div>

              {/* Kompetensi */}
              <div>
                <h4 className="text-xs font-extrabold uppercase tracking-wider text-[#05529E] mb-2">
                  Kompetensi Keahlian &amp; Materi Pembelajaran
                </h4>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                  {selectedJurusan.kompetensi.map((komp, kIdx) => (
                    <div
                      key={kIdx}
                      className="flex items-start gap-2 rounded-xl bg-slate-50 p-2.5 border border-slate-100 text-xs font-medium text-slate-800"
                    >
                      <span className="text-sky-600 font-bold shrink-0">✓</span>
                      <span>{komp}</span>
                    </div>
                  ))}
                </div>
              </div>

              {/* Prospek Karir */}
              <div>
                <h4 className="text-xs font-extrabold uppercase tracking-wider text-[#05529E] mb-2">
                  Peluang Karir &amp; Prospek Kerja Lulusan
                </h4>
                <div className="flex flex-wrap gap-2">
                  {selectedJurusan.karir.map((kr, cIdx) => (
                    <span
                      key={cIdx}
                      className="rounded-full bg-sky-50 border border-sky-200/80 px-3.5 py-1 text-xs font-semibold text-sky-800"
                    >
                      💼 {kr}
                    </span>
                  ))}
                </div>
              </div>

              {/* Fasilitas */}
              <div className="rounded-2xl bg-amber-50/70 p-4 border border-amber-200/60">
                <h4 className="text-xs font-extrabold uppercase tracking-wider text-amber-900 mb-1">
                  🏛️ Fasilitas Praktik &amp; Laboratorium
                </h4>
                <p className="text-xs text-amber-950/80 font-normal leading-relaxed">
                  {selectedJurusan.fasilitas}
                </p>
              </div>

              {/* Action Buttons */}
              <div className="pt-2 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100">
                <a
                  href="#denah"
                  onClick={() => setSelectedJurusan(null)}
                  className="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-[#05529E] hover:bg-[#033b74] px-5 py-2.5 text-xs font-bold text-white shadow-md transition cursor-pointer"
                >
                  <span>📍 Lihat Lokasi Laboratorium di Denah</span>
                </a>
                <button
                  type="button"
                  onClick={() => setSelectedJurusan(null)}
                  className="w-full sm:w-auto rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                >
                  Tutup
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
