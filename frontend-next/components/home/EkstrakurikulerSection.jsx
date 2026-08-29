"use client";

import { useState } from "react";
import Link from "next/link";

export default function EkstrakurikulerSection() {
  const [activeId, setActiveId] = useState("paskibra");

  const items = [
    {
      id: "paskibra",
      name: "Paskibra",
      subtitle: "Disiplin & kepemimpinan",
      image: "/paskib.png",
      desc: "Membentuk karakter disiplin, tanggung jawab, dan jiwa kepemimpinan melalui latihan baris-berbaris serta kegiatan upacara.",
      iconActive: "/icon-paskib-active.png",
      iconInactive: "/icon-paskib-inactive.png",
    },
    {
      id: "futsal",
      name: "Futsal",
      subtitle: "Kerja sama & sportivitas",
      image: "/futsal.png",
      desc: "Mengasah keterampilan fisik, kelincahan teknik, strategi tim, dan menjunjung tinggi sportivitas dalam olahraga futsal.",
      iconActive: "/icon-futsal-active.png",
      iconInactive: "/icon-futsal-inactive.png",
    },
    {
      id: "tari",
      name: "Tari",
      subtitle: "Seni & budaya",
      image: "/Tari.png",
      desc: "Wadah ekspresi seni tari tradisional dan modern untuk melestarikan kekayaan budaya serta melatih keindahan gerak.",
      iconActive: "/icon-tari-active.png",
      iconInactive: "/icon-tari-inactive.png",
    },
    {
      id: "pikr",
      name: "Pikr-r",
      subtitle: "Kerja sama & sportivitas",
      image: "/Pik-r.jpeg",
      desc: "Pusat informasi dan konseling remaja sebaya untuk membentuk generasi muda yang cerdas, peduli, sehat, dan berencana.",
      iconActive: "/icon-pikr-active.png",
      iconInactive: "/icon-pikr-inactive.png",
    },
  ];

  const current = items.find((i) => i.id === activeId) || items[0];

  return (
    <section
      id="kesiswaan"
      className="border-t border-slate-200/80 bg-[#f0f6fc] py-16 sm:py-20 px-5 lg:px-8 scroll-mt-16"
    >
      <div id="ekstrakurikuler" className="scroll-mt-16" />
      <div className="mx-auto max-w-7xl">
        {/* Section Title & Subtitle */}
        <div className="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
          <h2 className="text-2xl sm:text-4xl font-extrabold text-[#0a4870] tracking-tight">
            Esktrakulikuler
          </h2>
          <p className="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
            Temukan minat, kembangkan bakat, dan raih prestasi bersama berbagai kegiatan pilihan di sekolah.
          </p>
        </div>

        {/* Main Card Container */}
        <div className="rounded-[32px] bg-white p-5 sm:p-8 lg:p-10 shadow-sm border border-slate-100">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
            {/* Left Column: Tabs List (4 cols) */}
            <div className="lg:col-span-4 flex flex-col gap-3 sm:gap-4">
              {items.map((item) => {
                const isActive = activeId === item.id;
                return (
                  <button
                    key={item.id}
                    type="button"
                    onClick={() => setActiveId(item.id)}
                    className={`w-full flex items-center gap-4 rounded-2xl p-4 sm:p-4.5 text-left transition-all duration-300 cursor-pointer ${
                      isActive
                        ? "bg-white shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-slate-100 ring-1 ring-slate-100/80 scale-[1.01]"
                        : "bg-transparent hover:bg-slate-50/80 border border-transparent"
                    }`}
                  >
                    {/* Icon Image Badge */}
                    <div className="h-12 w-12 rounded-xl flex items-center justify-center shrink-0 overflow-hidden transition-transform duration-300">
                      <img
                        src={isActive ? item.iconActive : item.iconInactive}
                        alt={item.name}
                        className="h-full w-full object-contain select-none"
                      />
                    </div>

                    {/* Text Info */}
                    <div>
                      <p
                        className={`text-base font-extrabold leading-snug transition-colors ${
                          isActive ? "text-slate-900" : "text-slate-700"
                        }`}
                      >
                        {item.name}
                      </p>
                      <p className="text-xs text-slate-500 font-medium mt-0.5">
                        {item.subtitle}
                      </p>
                    </div>
                  </button>
                );
              })}
            </div>

            {/* Right Column: Photo Container */}
            <div className="lg:col-span-8 flex justify-center">
              <div className="relative w-full max-w-[835px] aspect-[834.75/578.25] max-h-[578.25px] rounded-[28px] overflow-hidden shadow-xl bg-slate-950 flex flex-col justify-end">
                {/* Dynamic Background Image */}
                <img
                  src={current.image}
                  alt={current.name}
                  className="absolute inset-0 h-full w-full object-cover object-center transition-all duration-500 transform scale-100 hover:scale-105"
                />

                {/* Dark Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/45 to-transparent pointer-events-none" />

                {/* Overlay Content */}
                <div className="relative z-10 p-6 sm:p-8 lg:p-10 text-white">
                  <div className="flex items-center gap-2">
                    <h3 className="text-2xl sm:text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
                      {current.name}
                    </h3>
                    <span className="h-2.5 w-2.5 rounded-full bg-white/90 shadow-sm mt-1" />
                  </div>

                  <p className="mt-3 text-xs sm:text-sm text-slate-200 leading-relaxed max-w-xl drop-shadow-sm font-normal">
                    {current.desc}
                  </p>

                  <div className="mt-5 sm:mt-6">
                    <Link
                      href="/#informasi"
                      className="inline-flex items-center gap-2.5 px-5 sm:px-6 py-2.5 sm:py-3 rounded-full bg-[#0284c7] hover:bg-[#0369a1] text-white text-xs sm:text-sm font-bold shadow-lg shadow-sky-950/30 transition-all duration-200 hover:gap-3 cursor-pointer"
                    >
                      <span>Selengkapnya</span>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-4 w-4">
                        <path
                          fillRule="evenodd"
                          d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z"
                          clipRule="evenodd"
                        />
                      </svg>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
