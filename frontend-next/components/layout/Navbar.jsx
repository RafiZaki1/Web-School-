"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import Image from "next/image";

export default function Navbar({ variant = "transparent", schoolName = "SMK NEGERI 2 KOTA MOJOKERTO" }) {
  const [isScrolled, setIsScrolled] = useState(false);
  const [infoDropdownOpen, setInfoDropdownOpen] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    if (variant === "solid") {
      setIsScrolled(true);
      return;
    }

    const handleScroll = () => {
      if (window.scrollY > 30) {
        setIsScrolled(true);
      } else {
        setIsScrolled(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, [variant]);

  const navBackgroundClass =
    variant === "solid"
      ? "bg-[#05529E] text-white shadow-md"
      : isScrolled
      ? "bg-slate-950/85 backdrop-blur-md border-b border-white/10 text-white shadow-lg"
      : "bg-transparent text-white";

  return (
    <header
      id="main-header"
      className={`fixed inset-x-0 top-0 z-40 transition-all duration-300 ${navBackgroundClass}`}
    >
      <nav className="mx-auto flex w-full max-w-[1280px] items-center justify-between px-6 lg:px-8 py-3.5 sm:py-4">
        {/* Left: School Brand Logo */}
        <Link href="/" className="flex items-center transition hover:opacity-90">
          <img
            src="/smk2.png"
            alt={schoolName}
            className="h-9 sm:h-11 w-auto max-w-[220px] sm:max-w-[280px] object-contain drop-shadow-md"
          />
        </Link>

        {/* Center: Desktop Navigation Links */}
        <div className="hidden items-center gap-6 lg:gap-10 text-xs sm:text-[13px] font-bold tracking-widest text-white md:flex">
          <Link href="/#beranda" className="transition hover:text-cyan-300 uppercase">
            HOME
          </Link>
          <Link href="/#profil" className="transition hover:text-cyan-300 uppercase">
            PROFIL
          </Link>
          <Link href="/#jurusan" className="transition hover:text-cyan-300 uppercase">
            JURUSAN
          </Link>

          {/* Dropdown Menu: INFORMASI */}
          <div
            className="relative flex items-center py-2 select-none"
            onMouseEnter={() => setInfoDropdownOpen(true)}
            onMouseLeave={() => setInfoDropdownOpen(false)}
          >
            <button
              type="button"
              onClick={() => setInfoDropdownOpen(!infoDropdownOpen)}
              className={`flex items-center gap-1.5 uppercase font-bold tracking-widest transition cursor-pointer focus:outline-none ${
                infoDropdownOpen ? "text-cyan-300" : "text-white hover:text-cyan-300"
              }`}
            >
              <span>INFORMASI</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                className={`h-4 w-4 transition duration-200 pointer-events-none ${
                  infoDropdownOpen ? "rotate-180" : ""
                }`}
              >
                <path
                  fillRule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clipRule="evenodd"
                />
              </svg>
            </button>

            {infoDropdownOpen && (
              <div className="absolute left-1/2 -translate-x-1/2 top-full pt-2 min-w-[210px] z-50">
                <div className="rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-slate-900/10 text-slate-800 tracking-normal normal-case font-medium">
                  <Link
                    href="/#informasi"
                    onClick={() => setInfoDropdownOpen(false)}
                    className="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-blue-700 transition"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-4 w-4 text-blue-600 shrink-0"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth="2"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                      />
                    </svg>
                    <span>Berita & Informasi</span>
                  </Link>
                  <Link
                    href="/#denah"
                    onClick={() => setInfoDropdownOpen(false)}
                    className="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-blue-700 transition"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-4 w-4 text-emerald-600 shrink-0"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth="2"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                      />
                    </svg>
                    <span>Denah Interaktif</span>
                  </Link>
                </div>
              </div>
            )}
          </div>

          <Link href="/#kesiswaan" className="transition hover:text-cyan-300 uppercase">
            KESISWAAN
          </Link>
        </div>

        {/* Right: Informasi PPDB Button */}
        <div className="hidden sm:flex items-center gap-3">
          <button
            type="button"
            onClick={() => window.dispatchEvent(new CustomEvent("open-ppdb-modal"))}
            className="group inline-flex items-center gap-2.5 rounded-full bg-[#a3e635] hover:bg-[#bef264] py-1.5 pl-4 pr-1.5 text-xs font-black text-slate-950 shadow-lg shadow-lime-400/20 transition-all hover:scale-105 cursor-pointer"
          >
            <span>Informasi PPDB</span>
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-white transition group-hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5">
                <path
                  fillRule="evenodd"
                  d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z"
                  clipRule="evenodd"
                />
              </svg>
            </span>
          </button>
        </div>

        {/* Mobile Menu Hamburger Button */}
        <button
          type="button"
          onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          className="md:hidden flex items-center justify-center p-2 rounded-xl text-white hover:bg-white/10"
          aria-label="Menu"
        >
          <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {mobileMenuOpen ? (
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
            ) : (
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
            )}
          </svg>
        </button>
      </nav>

      {/* Mobile Drawer Menu */}
      {mobileMenuOpen && (
        <div className="md:hidden bg-slate-950/95 backdrop-blur-xl border-b border-white/10 px-6 py-4 space-y-3 text-white">
          <Link
            href="/#beranda"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider hover:text-cyan-300"
          >
            HOME
          </Link>
          <Link
            href="/#profil"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider hover:text-cyan-300"
          >
            PROFIL
          </Link>
          <Link
            href="/#jurusan"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider hover:text-cyan-300"
          >
            JURUSAN
          </Link>
          <Link
            href="/#denah"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider text-cyan-300 hover:text-white"
          >
            DENAH INTERAKTIF
          </Link>
          <Link
            href="/#informasi"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider hover:text-cyan-300"
          >
            BERITA & INFORMASI
          </Link>
          <Link
            href="/#kesiswaan"
            onClick={() => setMobileMenuOpen(false)}
            className="block py-2 text-sm font-bold tracking-wider hover:text-cyan-300"
          >
            KESISWAAN
          </Link>
          <div className="pt-2">
            <button
              type="button"
              onClick={() => {
                setMobileMenuOpen(false);
                window.dispatchEvent(new CustomEvent("open-ppdb-modal"));
              }}
              className="inline-flex items-center gap-2 rounded-full bg-[#a3e635] text-slate-950 px-5 py-2 text-xs font-black w-full justify-center shadow-md cursor-pointer"
            >
              <span>INFORMASI PPDB</span>
              <span>↗</span>
            </button>
          </div>
        </div>
      )}
    </header>
  );
}
