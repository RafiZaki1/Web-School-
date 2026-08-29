"use client";

import { useState, useEffect, useCallback } from "react";

export default function PpdbModal() {
  const [isOpen, setIsOpen] = useState(false);

  const openModal = useCallback(() => {
    setIsOpen(true);
    document.body.style.overflow = "hidden";
  }, []);

  const closeModal = useCallback(() => {
    setIsOpen(false);
    document.body.style.overflow = "";
    if (window.location.hash === "#ppdb") {
      history.pushState("", document.title, window.location.pathname + window.location.search);
    }
  }, []);

  useEffect(() => {
    const handleCustomOpen = () => openModal();
    window.addEventListener("open-ppdb-modal", handleCustomOpen);

    // Also open if URL has #ppdb
    if (window.location.hash === "#ppdb") {
      openModal();
    }

    const handleHashChange = () => {
      if (window.location.hash === "#ppdb") {
        openModal();
      }
    };
    window.addEventListener("hashchange", handleHashChange);

    const handleKeyDown = (e) => {
      if (e.key === "Escape") closeModal();
    };
    window.addEventListener("keydown", handleKeyDown);

    return () => {
      window.removeEventListener("open-ppdb-modal", handleCustomOpen);
      window.removeEventListener("hashchange", handleHashChange);
      window.removeEventListener("keydown", handleKeyDown);
      document.body.style.overflow = "";
    };
  }, [openModal, closeModal]);

  if (!isOpen) return null;

  const steps = [
    {
      step: "01",
      title: "Jalur Afirmasi & Prestasi",
      desc: "Bagi calon peserta didik dari keluarga pra-sejahtera, penyandang disabilitas, dan peraih kejuaraan lomba akademik / non-akademik.",
      badge: "Tahap 1",
    },
    {
      step: "02",
      title: "Jalur Prestasi Nilai Akademik",
      desc: "Seleksi berbasis gabungan rata-rata nilai rapor semester 1 s.d 5 dan nilai akreditasi sekolah asal SMP/MTs.",
      badge: "Tahap 2",
    },
    {
      step: "03",
      title: "Jalur Zonasi & Domisili",
      desc: "Diperuntukkan bagi calon peserta didik baru yang berdomisili di dalam atau sekitar wilayah zonasi sekolah.",
      badge: "Tahap 3",
    },
  ];

  const requirements = [
    "Ijazah / Surat Keterangan Lulus (SKL) SMP/MTs sederajat",
    "Kartu Keluarga (KK) & Akta Kelahiran",
    "Rapor SMP/MTs semester 1 sampai dengan 5",
    "Piagam kejuaraan (khusus jalur prestasi lomba)",
    "Surat Keterangan Sehat & tidak buta warna (untuk jurusan teknik)",
  ];

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
      {/* Backdrop */}
      <div
        className="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"
        onClick={closeModal}
      />

      {/* Modal Dialog Content */}
      <div className="relative w-full max-w-3xl rounded-3xl bg-gradient-to-br from-[#05529E] via-[#044382] to-[#022b54] p-6 sm:p-10 text-white shadow-2xl border border-white/20 z-10 my-auto animate-in fade-in zoom-in-95 duration-200">
        {/* Close Button */}
        <button
          onClick={closeModal}
          className="absolute right-5 top-5 flex h-9 w-9 items-center justify-center rounded-full bg-white/15 hover:bg-white/25 text-white transition border border-white/20"
          aria-label="Tutup modal PPDB"
        >
          <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path
              fillRule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clipRule="evenodd"
            />
          </svg>
        </button>

        {/* Header Content */}
        <div className="pr-10">
          <span className="inline-flex items-center gap-2 rounded-full bg-[#a3e635] text-slate-950 px-3.5 py-1 text-xs font-black tracking-wide shadow-md">
            <span>✦</span> INFORMASI RESMI PPDB
          </span>

          <h2 className="mt-3 text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
            Informasi PPDB
          </h2>

          <p className="mt-2 text-xs sm:text-sm text-sky-100/90 leading-relaxed font-normal">
            Penerimaan siswa baru SMK Negeri 2 Kota Mojokerto diselenggarakan secara terpadu melalui sistem PPDB Jawa Timur untuk 5 Program Keahlian unggulan.
          </p>
        </div>

        {/* Steps Grid */}
        <div className="mt-6 grid gap-3 sm:grid-cols-3">
          {steps.map((item, idx) => (
            <div
              key={idx}
              className="rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-4 hover:bg-white/15 transition duration-200"
            >
              <div className="flex items-center justify-between">
                <span className="text-lg font-black text-cyan-300">{item.step}</span>
                <span className="text-[9px] font-bold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded-full text-white">
                  {item.badge}
                </span>
              </div>
              <h3 className="mt-2 text-sm font-bold text-white leading-snug">{item.title}</h3>
              <p className="mt-1 text-[11px] text-sky-100/80 leading-relaxed">{item.desc}</p>
            </div>
          ))}
        </div>

        {/* Persyaratan Pendaftaran */}
        <div className="mt-6 rounded-2xl bg-white/5 border border-white/10 p-4">
          <h4 className="text-xs font-bold uppercase tracking-wider text-cyan-300 mb-2">
            Persyaratan Umum Berkas:
          </h4>
          <ul className="grid sm:grid-cols-2 gap-1.5 text-xs text-sky-100/90">
            {requirements.map((req, i) => (
              <li key={i} className="flex items-center gap-2">
                <span className="text-[#a3e635] text-xs">✓</span>
                <span>{req}</span>
              </li>
            ))}
          </ul>
        </div>

        {/* CTA Footer */}
        <div className="mt-6 pt-5 border-t border-white/15 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p className="text-xs text-sky-200 text-center sm:text-left">
            Pendaftaran online resmi via <span className="font-semibold text-white">ppdbjatim.net</span>
          </p>
          <div className="flex items-center gap-2.5">
            <a
              href="https://ppdbjatim.net"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-2 rounded-full bg-[#a3e635] hover:bg-[#bef264] px-5 py-2 text-xs font-black text-slate-950 shadow-md transition-all hover:scale-105"
            >
              <span>Buka Portal PPDB</span>
              <span>↗</span>
            </a>
            <button
              onClick={closeModal}
              className="rounded-full bg-white/15 hover:bg-white/25 px-4 py-2 text-xs font-bold text-white border border-white/20 transition"
            >
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
