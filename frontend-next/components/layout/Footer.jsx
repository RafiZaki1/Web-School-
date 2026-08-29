"use client";

import Link from "next/link";

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer id="kontak" className="bg-gradient-to-b from-[#05529E] via-[#03315F] to-[#021D37] text-white">
      <div className="mx-auto w-full max-w-[1280px] px-6 lg:px-8 pt-14 pb-8 flex flex-col justify-between">
        {/* Main Footer Columns */}
        <div className="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-12 lg:gap-8 items-start w-full">
          {/* Column 1: School Card & Motto */}
          <div className="lg:col-span-4 space-y-4">
            <div className="inline-flex rounded-2xl bg-white px-5 py-3 shadow-xl">
              <img
                src="/smk2-footer.png"
                alt="Logo SMK Negeri 2 Kota Mojokerto"
                className="h-10 sm:h-11 w-auto object-contain"
              />
            </div>
            <p className="text-xs sm:text-[13px] text-white/90 leading-relaxed max-w-sm font-medium">
              Kami Siap Melayani Masyarakat Pendidikan Dan Pembelajaran Berbasis Budaya Kerja, Disiplin Dan Berprestasi.
            </p>
          </div>

          {/* Column 2: MENU UTAMA */}
          <div className="lg:col-span-2 space-y-4">
            <div>
              <h4 className="text-xs font-black uppercase tracking-widest text-white">MENU UTAMA</h4>
              <div className="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
            </div>
            <ul className="space-y-2.5 text-xs sm:text-[13px] text-white font-medium">
              <li>
                <Link href="/#beranda" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Beranda</span>
                </Link>
              </li>
              <li>
                <Link href="/#profil" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Tentang Kami</span>
                </Link>
              </li>
              <li>
                <Link href="/#jurusan" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Profil Jurusan</span>
                </Link>
              </li>
              <li>
                <Link href="/#denah" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Denah Interaktif</span>
                </Link>
              </li>
              <li>
                <Link href="/#mitra" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Mitra Industri</span>
                </Link>
              </li>
              <li>
                <Link href="/#ekstrakurikuler" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Ekstrakurikuler</span>
                </Link>
              </li>
              <li>
                <Link href="/#prestasi" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Prestasi</span>
                </Link>
              </li>
              <li>
                <Link href="/#informasi" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group">
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Berita</span>
                </Link>
              </li>
              <li>
                <button
                  type="button"
                  onClick={() => window.dispatchEvent(new CustomEvent("open-ppdb-modal"))}
                  className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition group cursor-pointer text-left"
                >
                  <span className="h-1.5 w-1.5 rounded-full bg-white group-hover:scale-125 transition"></span>
                  <span>Informasi PPDB</span>
                </button>
              </li>
            </ul>
          </div>

          {/* Column 3: SOSMED KAMI */}
          <div className="lg:col-span-2 space-y-4">
            <div>
              <h4 className="text-xs font-black uppercase tracking-widest text-white">SOSMED KAMI</h4>
              <div className="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
            </div>
            <div className="flex items-center gap-3 text-white">
              {/* Facebook */}
              <a
                href="https://facebook.com/smkn2kotamojokerto"
                target="_blank"
                rel="noopener noreferrer"
                className="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm"
                title="Facebook SMKN 2 Kota Mojokerto"
              >
                <svg className="h-4 w-4 fill-current" viewBox="0 0 24 24">
                  <path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.7 5H18V0h-3.808C10.597 0 9 1.583 9 4.615V8z" />
                </svg>
              </a>
              {/* Instagram */}
              <a
                href="https://www.instagram.com/smkn2kotamojokerto"
                target="_blank"
                rel="noopener noreferrer"
                className="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm"
                title="Instagram @smkn2kotamojokerto"
              >
                <svg className="h-4 w-4 fill-current" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
              {/* TikTok */}
              <a
                href="https://tiktok.com/@smkn2kotamojokerto"
                target="_blank"
                rel="noopener noreferrer"
                className="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white hover:text-[#05529E] transition-all hover:scale-110 shadow-sm"
                title="TikTok SMKN 2 Kota Mojokerto"
              >
                <svg className="h-4 w-4 fill-current" viewBox="0 0 24 24">
                  <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                </svg>
              </a>
            </div>
          </div>

          {/* Column 4: LOKASI & ALAMAT */}
          <div className="lg:col-span-4 space-y-4">
            <div>
              <h4 className="text-xs font-black uppercase tracking-widest text-white">LOKASI &amp; ALAMAT</h4>
              <div className="mt-1.5 h-0.5 w-7 bg-white/80 rounded-full"></div>
            </div>
            <div className="overflow-hidden rounded-2xl border border-white/15 bg-[#03315F] shadow-xl">
              {/* Map Embed */}
              <div className="relative h-28 w-full bg-slate-200">
                <iframe
                  src="https://maps.google.com/maps?q=SMK+Negeri+2+Kota+Mojokerto,+Jl.+Raya+Pulorejo,+Kota+Mojokerto&t=&z=16&ie=UTF8&iwloc=&output=embed"
                  width="100%"
                  height="100%"
                  style={{ border: 0 }}
                  allowFullScreen=""
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  className="h-full w-full object-cover"
                ></iframe>
              </div>
              {/* Map Bottom Bar */}
              <div className="flex items-start gap-2.5 p-3 bg-[#021D37]">
                <span className="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/20 text-white shadow-md mt-0.5">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5">
                    <path
                      fillRule="evenodd"
                      d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.77 11.77 0 0 0 1.039.573l.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"
                      clipRule="evenodd"
                    />
                  </svg>
                </span>
                <div>
                  <p className="text-[11px] leading-snug text-white font-medium">
                    Jl. Raya Pulorejo, Mergelo, Pulorejo, Kec. Prajurit Kulon, Kota Mojokerto, Jawa Timur 61325
                  </p>
                  <p className="text-[10px] text-white/80 font-bold mt-0.5">Plus Code: GCPF+6HJ</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Sub-Footer Bar */}
        <div className="mt-10 pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/90">
          <p className="text-white/90 text-center sm:text-left">
            &copy; {currentYear} SMK Negeri 2 Mojokerto. Hak Cipta Dilindungi.
          </p>
          <div className="flex flex-wrap items-center justify-center gap-6 font-medium text-white">
            <a href="tel:0321387356" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5 text-white">
                <path
                  fillRule="evenodd"
                  d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z"
                  clipRule="evenodd"
                />
              </svg>
              <span>0321 387356</span>
            </a>
            <a href="mailto:smkn2mr@gmail.com" className="inline-flex items-center gap-2 text-white hover:text-cyan-300 transition">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5 text-white">
                <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
              </svg>
              <span>smkn2mr@gmail.com</span>
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
}
