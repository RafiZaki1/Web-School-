import Link from "next/link";
import ArcCarousel from "./ArcCarousel";

export default function HeroSection({ hero, schoolProfile }) {
  const schoolName =
    schoolProfile?.school_name || hero?.school_name || "SMK NEGERI 2 KOTA MOJOKERTO";

  return (
    <section
      id="beranda"
      className="relative overflow-hidden min-h-[720px] sm:min-h-[780px] lg:h-[840px] flex flex-col justify-between pt-24 sm:pt-28 pb-6 sm:pb-8 text-white bg-[#05529E]"
    >
      {/* Background School Image */}
      <img
        src="/hero-bg.jpg"
        alt={schoolName}
        className="absolute inset-0 h-full w-full object-cover object-center opacity-100"
      />

      {/* High Contrast 3-Stop Gradient Overlay */}
      <div
        className="absolute inset-0 pointer-events-none"
        style={{
          background:
            "linear-gradient(180deg, rgba(2, 33, 64, 0.84) 0%, rgba(5, 82, 158, 0.72) 45%, rgba(8, 110, 180, 0.60) 100%)",
        }}
      />

      {/* Center Hero Content */}
      <div className="relative mx-auto mt-2 sm:mt-4 mb-2 max-w-[1280px] w-full px-4 sm:px-6 text-center z-10">
        <p className="text-[11px] sm:text-xs font-extrabold uppercase tracking-[0.18em] text-sky-200/90 drop-shadow-xs">
          DISIPLIN • BERAKHLAK • BERPRESTASI
        </p>

        <h1 className="mt-2 text-2xl sm:text-5xl lg:text-6xl font-black uppercase tracking-tight text-white leading-[1.2] sm:leading-tight drop-shadow-md">
          SELAMAT DATANG DI<br />
          <span>SMK NEGERI 2 MOJOKERTO</span>
        </h1>

        <p className="mx-auto mt-2.5 max-w-xl text-xs sm:text-sm leading-relaxed text-sky-100/95 font-normal drop-shadow-xs px-2">
          Temukan lingkungan belajar yang aktif, kreatif, dan relevan dengan dunia industri. Belajar dari praktik, berkembang lewat karya, dan siap melangkah lebih jauh.
        </p>

        <Link
          href="/#aspirasi"
          className="mt-4 inline-flex items-center gap-2.5 rounded-full bg-[#a3e635] hover:bg-[#bef264] active:scale-95 px-5 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm font-black text-slate-950 shadow-xl shadow-lime-400/25 transition-all duration-150"
        >
          <span>KOTAK ASPIRASI</span>
          <span className="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-white transition group-hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5">
              <path
                fillRule="evenodd"
                d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z"
                clipRule="evenodd"
              />
            </svg>
          </span>
        </Link>
      </div>

      {/* Arc Carousel */}
      <ArcCarousel />
    </section>
  );
}
