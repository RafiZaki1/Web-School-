"use client";

import Link from "next/link";

export default function PrestasiSection() {
  const timelineItems = [
    {
      date: "JUNI 2026",
      title: "Duta Koperasi",
      subtitle: "Juara 1 Putri · Vania Garnetta Putri XII LPS 2",
    },
    {
      date: "JUNI 2026",
      title: "Turnamen Futsal Tunas Cup 2026",
      subtitle: "Juara 3 · Tim Futsal SMKN 2 MOJOKERTO",
    },
    {
      date: "MEI 2026",
      title: "Kejuaraan Provinsi (Kejurprov) Dayung 2026",
      subtitle: "Medali Perunggu · Ayu Pinky Salsabila",
    },
    {
      date: "APRIL 2026",
      title: "Graphic Design Technology",
      subtitle: "Juara 3 · Tim Karya Siswa XII DKV",
    },
  ];

  return (
    <section id="prestasi" className="border-t border-slate-200/80 bg-white py-16 sm:py-20 px-5 lg:px-8">
      <div className="mx-auto max-w-6xl">
        {/* Section Header */}
        <div className="text-center max-w-2xl mx-auto">
          <h2 className="text-2xl sm:text-4xl font-extrabold text-[#05529E] tracking-tight">
            Prestasi yang terus tumbuh
          </h2>
          <p className="mt-3 text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
            Deretan penghargaan siswa SMKN 2 Kota Mojokerto di ajang lokal, nasional,
            <br className="hidden sm:inline" /> hingga internasional.
          </p>
        </div>

        {/* 2-Column Content Layout */}
        <div className="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          {/* Left Feature Card (Photo with Gradient & Award) */}
          <div className="lg:col-span-6">
            <div className="relative rounded-[32px] overflow-hidden shadow-xl border border-slate-200/80 bg-slate-900 group aspect-[4/3] sm:aspect-[16/11]">
              {/* Photo */}
              <img
                src="/prestasi-utama.png"
                alt="Lomba Menulis Surat Untuk Gubernur Memperingati Hari Pendidikan"
                className="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
              />

              {/* Thin Sleek Bottom Gradient Behind Text Only */}
              <div className="absolute inset-x-0 bottom-0 h-32 sm:h-36 bg-gradient-to-t from-[#021f3d]/85 via-[#021f3d]/30 to-transparent pointer-events-none" />

              {/* Top-Left Juara 1 Badge */}
              <div className="absolute top-5 left-5 z-10">
                <span className="inline-flex items-center gap-1.5 rounded-full bg-[#f59e0b] px-3.5 py-1.5 text-xs font-black text-slate-950 shadow-md">
                  <span>🏆</span>
                  <span>Juara 1</span>
                </span>
              </div>

              {/* Bottom Caption Inside Card */}
              <div className="absolute bottom-6 left-6 right-6 z-10 text-white">
                <h3 className="text-lg sm:text-2xl font-black text-white leading-snug drop-shadow-sm">
                  Lomba Menulis Surat Untuk Gurbernur Memperingati Hari Pendidikan
                </h3>
                <p className="mt-2 text-xs sm:text-sm text-sky-100/90 font-medium">
                  Carla Nur Parawansa · Kelas XII LPS 2
                </p>
              </div>
            </div>
          </div>

          {/* Right Column: Vertical Timeline */}
          <div className="lg:col-span-6 pl-2 sm:pl-4">
            <div className="relative pl-7 sm:pl-8 before:absolute before:left-2.5 sm:before:left-3 before:top-2 before:bottom-2 before:w-[2px] before:bg-sky-300/80 space-y-6 sm:space-y-7">
              {timelineItems.map((item, idx) => (
                <div key={idx} className="relative group">
                  {/* Timeline Circular Beacon */}
                  <div className="absolute -left-7 sm:-left-8 top-1 flex h-5 w-5 sm:h-6 sm:w-6 items-center justify-center rounded-full bg-[#0099ff] ring-4 ring-white shadow-xs">
                    <span className="h-2 w-2 rounded-full bg-[#022b54]" />
                  </div>

                  {/* Content */}
                  <div className="space-y-0.5">
                    <span className="text-[11px] font-extrabold uppercase tracking-wider text-slate-900 block">
                      {item.date}
                    </span>
                    <h4 className="text-base sm:text-xl font-bold text-[#0099ff] group-hover:text-[#05529E] transition-colors leading-tight">
                      {item.title}
                    </h4>
                    <p className="text-xs sm:text-sm text-slate-700 font-normal leading-relaxed pt-0.5">
                      {item.subtitle}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Bottom Center Link */}
        <div className="mt-12 text-center">
          <Link
            href="/#informasi"
            className="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[#0099ff] hover:text-[#05529E] transition group"
          >
            <span>Lihat semua prestasi</span>
            <span className="transition-transform duration-200 group-hover:translate-x-1">→</span>
          </Link>
        </div>
      </div>
    </section>
  );
}
