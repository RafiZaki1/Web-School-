"use client";

import { useState } from "react";

export default function BeritaSection() {
  const [activeCategory, setActiveCategory] = useState("Semua");

  const categories = [
    "Semua",
    "Informasi umum",
    "Prestasi",
    "Agenda sekolah",
    "Pengumuman",
    "Karya siswa",
  ];

  const allArticles = [
    {
      id: 1,
      category: "Prestasi",
      badgeColor: "yellow", // yellow badge
      title:
        "Siswa jurusan pengembangan gim SMKN 2 Kota Mojokerto ciptakan game edukasi AR untuk kenalkan batik Malang kepada anak–anak",
      date: "19 Juli 2026",
      isFeatured: true,
    },
    {
      id: 2,
      category: "Agenda sekolah",
      badgeColor: "white", // white badge
      title: "Belajar teknologi dengan standar global di SMK Negeri 2 Kota Mojokerto",
      date: "6 Maret 2026",
      isFeatured: false,
    },
    {
      id: 3,
      category: "Informasi umum",
      badgeColor: "white",
      title: "Peningkatan kualitas sarana pembelajaran dan teaching factory berstandar industri",
      date: "6 Maret 2026",
      isFeatured: false,
    },
    {
      id: 4,
      category: "Pengumuman",
      badgeColor: "white",
      title: "Pelaksanaan Asesmen Sumatif Akhir Jenjang Tahun Ajaran 2025/2026",
      date: "1 Maret 2026",
      isFeatured: false,
    },
    {
      id: 5,
      category: "Karya siswa",
      badgeColor: "yellow",
      title: "Pameran Karya Kreatif dan Prototype IoT Siswa Rekayasa Perangkat Lunak",
      date: "25 Februari 2026",
      isFeatured: false,
    },
  ];

  const filtered =
    activeCategory === "Semua"
      ? allArticles
      : allArticles.filter((item) => item.category === activeCategory);

  const featured = filtered[0] || allArticles[0];
  const sideArticles = filtered.length > 1 ? filtered.slice(1, 3) : allArticles.slice(1, 3);

  return (
    <section id="informasi" className="border-t border-slate-200/80 bg-slate-50/60 py-16 sm:py-20 px-5 lg:px-8">
      <div className="mx-auto max-w-6xl">
        {/* Header Title & Subtitle */}
        <div className="text-center max-w-2xl mx-auto">
          <h2 className="text-2xl sm:text-4xl font-extrabold text-[#05529E] tracking-tight">
            Berita &amp; Artikel
          </h2>
          <p className="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
            Ikuti terus informasi dan berita-berita terbaru tentang SMK Negeri 2 Kota Mojokerto.
          </p>
        </div>

        {/* Category Filter Pills */}
        <div className="mt-8 flex flex-wrap items-center justify-center gap-2 sm:gap-2.5">
          {categories.map((cat) => {
            const isActive = activeCategory === cat;
            return (
              <button
                key={cat}
                type="button"
                onClick={() => setActiveCategory(cat)}
                className={`rounded-full px-5 py-2 text-xs sm:text-sm font-semibold transition-all duration-200 cursor-pointer shadow-xs ${
                  isActive
                    ? "bg-[#006ca8] text-white shadow-md scale-105"
                    : "bg-[#857b77] hover:bg-[#736a66] text-white"
                }`}
              >
                {cat}
              </button>
            );
          })}
        </div>

        {/* Bento Grid News Layout */}
        <div className="mt-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
          {/* Left Column: Big Featured Blue Card */}
          <div className="lg:col-span-7 flex">
            <div className="w-full rounded-[32px] bg-[#008be3] hover:bg-[#0083d6] p-8 sm:p-10 text-white flex flex-col justify-between shadow-lg hover:shadow-xl transition-all duration-300 group cursor-pointer">
              {/* Top Badge */}
              <div>
                <span
                  className={`inline-block rounded-full px-4 py-1 text-xs font-black shadow-xs ${
                    featured.badgeColor === "yellow" || featured.category === "Prestasi"
                      ? "bg-[#f59e0b] text-slate-950"
                      : "bg-white text-[#008be3]"
                  }`}
                >
                  {featured.category}
                </span>

                {/* Big Title */}
                <h3 className="mt-6 text-xl sm:text-2xl lg:text-[28px] font-extrabold text-white leading-snug tracking-tight group-hover:underline underline-offset-4 decoration-white/40">
                  {featured.title}
                </h3>
              </div>

              {/* Bottom Date */}
              <div className="mt-8 flex items-center gap-2 text-xs font-medium text-white/95">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  className="h-4 w-4 shrink-0 text-white"
                >
                  <path
                    fillRule="evenodd"
                    d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                    clipRule="evenodd"
                  />
                </svg>
                <span>{featured.date}</span>
              </div>
            </div>
          </div>

          {/* Right Column: 2 Stacked Blue Cards */}
          <div className="lg:col-span-5 flex flex-col gap-6">
            {sideArticles.map((article, idx) => (
              <div
                key={article.id || idx}
                className="w-full rounded-[32px] bg-[#008be3] hover:bg-[#0083d6] p-7 sm:p-8 text-white flex flex-col justify-between shadow-md hover:shadow-lg transition-all duration-300 group cursor-pointer flex-1"
              >
                <div>
                  {/* Badge */}
                  <span className="inline-block rounded-full bg-white text-[#008be3] px-3.5 py-1 text-xs font-black shadow-xs">
                    {article.category}
                  </span>

                  {/* Title */}
                  <h4 className="mt-4 text-base sm:text-lg font-bold text-white leading-snug tracking-tight group-hover:underline underline-offset-4 decoration-white/40">
                    {article.title}
                  </h4>
                </div>

                {/* Date */}
                <div className="mt-5 flex items-center gap-2 text-xs font-medium text-white/95">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    className="h-4 w-4 shrink-0 text-white"
                  >
                    <path
                      fillRule="evenodd"
                      d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                      clipRule="evenodd"
                    />
                  </svg>
                  <span>{article.date}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
