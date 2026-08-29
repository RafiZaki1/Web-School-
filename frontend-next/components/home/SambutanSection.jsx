"use client";

import { useState, useEffect, useRef } from "react";
import StatCounter from "./StatCounter";

export default function SambutanSection({ statistics = {} }) {
  const totalStudents = statistics?.total_students || 1850;
  const totalTeachers = statistics?.total_teachers || 120;
  const establishedYear = statistics?.established_year || 2013;
  const totalMajors = statistics?.total_majors || 5;
  const totalAlumni = statistics?.total_alumni || 1000;

  const fullQuote =
    "Pendidikan vokasi adalah kunci kemandirian bangsa. Kami mendidik dengan hati, mengasah kompetensi, dan mencetak generasi yang tangguh menghadapi tantangan global.";
  const fullName = "Bapak Iswahyudi, S.ST.";
  const fullRole = "Kepala SMKN 2 Mojokerto";

  const [displayedText, setDisplayedText] = useState("");
  const [displayedName, setDisplayedName] = useState("");
  const [displayedRole, setDisplayedRole] = useState("");

  const [isQuoteDone, setIsQuoteDone] = useState(false);
  const [isNameDone, setIsNameDone] = useState(false);
  const [isAllDone, setIsAllDone] = useState(false);
  const [hasStarted, setHasStarted] = useState(false);
  const sectionRef = useRef(null);

  // Trigger typing effect when section is in viewport
  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting && !hasStarted) {
          setHasStarted(true);
        }
      },
      { threshold: 0.2 }
    );

    const currentRef = sectionRef.current;
    if (currentRef) observer.observe(currentRef);

    return () => {
      if (currentRef) observer.unobserve(currentRef);
    };
  }, [hasStarted]);

  // Sequential typing effect
  useEffect(() => {
    if (!hasStarted) return;

    let quoteIdx = 0;
    let nameIdx = 0;
    let roleIdx = 0;
    const speed = 48; // ms per character

    // 1. Type Quote
    const quoteTimer = setInterval(() => {
      if (quoteIdx <= fullQuote.length) {
        setDisplayedText(fullQuote.slice(0, quoteIdx));
        quoteIdx++;
      } else {
        setIsQuoteDone(true);
        clearInterval(quoteTimer);

        // 2. Type Name
        const nameTimer = setInterval(() => {
          if (nameIdx <= fullName.length) {
            setDisplayedName(fullName.slice(0, nameIdx));
            nameIdx++;
          } else {
            setIsNameDone(true);
            clearInterval(nameTimer);

            // 3. Type Role
            const roleTimer = setInterval(() => {
              if (roleIdx <= fullRole.length) {
                setDisplayedRole(fullRole.slice(0, roleIdx));
                roleIdx++;
              } else {
                setIsAllDone(true);
                clearInterval(roleTimer);
              }
            }, speed - 10);
          }
        }, speed);
      }
    }, speed);

    return () => clearInterval(quoteTimer);
  }, [hasStarted, fullQuote, fullName, fullRole]);

  return (
    <section
      id="profil"
      ref={sectionRef}
      className="relative z-10 px-3 sm:px-6 lg:px-8 mt-[70px] sm:mt-[120px] mb-[60px] sm:mb-[90px]"
    >
      <div className="mx-auto w-full max-w-[1200px] min-h-[560px] sm:min-h-[675px] lg:h-[675px] overflow-hidden rounded-3xl sm:rounded-[36px] border border-white/20 bg-slate-900 shadow-2xl shadow-slate-950/40 relative flex flex-col justify-between">
        {/* Background Photo */}
        <img
          src="/images/sambutan-bg.jpg"
          alt="Kegiatan SMKN 2 Mojokerto"
          className="absolute inset-0 h-full w-full object-cover object-center"
        />
        {/* Soft Vignette Overlay */}
        <div className="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/60 to-transparent pointer-events-none" />

        {/* Main Content Layer */}
        <div className="relative z-20 flex-1 flex flex-col justify-between p-5 sm:p-10 lg:p-12">
          {/* Top Badge: Terakreditasi "A" */}
          <div className="flex items-center">
            <span className="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-amber-400 text-amber-950 px-3.5 sm:px-4 py-1 sm:py-1.5 text-[11px] sm:text-sm font-black shadow-md tracking-wider">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-3.5 w-3.5 sm:h-4 sm:w-4 text-amber-950">
                <path
                  fillRule="evenodd"
                  d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                  clipRule="evenodd"
                />
              </svg>
              TERAKREDITASI &quot;A&quot;
            </span>
          </div>

          {/* Center Content: Glassmorphic Quote Card with Live Typewriter Effect */}
          <div className="my-auto py-4 sm:py-6 grid grid-cols-1 lg:grid-cols-[1fr_auto] items-center">
            <div className="max-w-[560px] rounded-2xl sm:rounded-3xl bg-slate-950/75 sm:bg-slate-950/50 backdrop-blur-md border border-white/20 p-5 sm:p-8 text-white shadow-2xl">
              <div className="min-h-[100px] sm:min-h-[125px]">
                <p className="text-sm sm:text-lg lg:text-[19px] font-semibold leading-relaxed text-white drop-shadow-sm">
                  &ldquo;{displayedText}&rdquo;
                  {/* Blinking Typing Cursor on Quote */}
                  {!isQuoteDone && (
                    <span className="inline-block w-[3px] h-[1.15em] bg-lime-400 align-middle ml-1 rounded-xs animate-ping" />
                  )}
                </p>
              </div>

              {/* Principal Signature with Typewriter Effect */}
              <div className="mt-4 sm:mt-5 pt-3 border-t border-white/10">
                <p className="text-sm sm:text-lg font-bold text-lime-400 tracking-wide flex items-center min-h-[1.5em]">
                  <span>{displayedName}</span>
                  {isQuoteDone && !isNameDone && (
                    <span className="inline-block w-[3px] h-[1.1em] bg-lime-400 align-middle ml-1 rounded-xs animate-ping" />
                  )}
                </p>
                <p className="text-[11px] sm:text-sm font-medium text-slate-200/90 mt-0.5 flex items-center min-h-[1.3em]">
                  <span>{displayedRole}</span>
                  {isNameDone && !isAllDone && (
                    <span className="inline-block w-[2.5px] h-[1em] bg-slate-300 align-middle ml-1 rounded-xs animate-ping" />
                  )}
                  {isAllDone && (
                    <span className="inline-block w-[2.5px] h-[1em] bg-lime-400/80 align-middle ml-1 rounded-xs animate-pulse opacity-60" />
                  )}
                </p>
              </div>
            </div>
          </div>

          <div />
        </div>

        {/* Cutout Foto Kepala Sekolah */}
        <img
          src="/images/kepala-sekolah.png"
          alt="Bapak Iswahyudi, S.ST."
          className="absolute bottom-0 right-1 sm:right-6 lg:right-10 w-[190px] sm:w-[380px] lg:w-[466px] max-h-[440px] sm:max-h-[604px] object-contain object-bottom pointer-events-none drop-shadow-2xl z-10 sm:z-20 opacity-70 sm:opacity-100"
        />

        {/* Bottom Stats Bar */}
        <div className="relative z-30 bg-[#0c2f4a]/95 backdrop-blur-md border-t border-white/10 px-4 sm:px-10 lg:px-12 py-3.5 sm:py-5">
          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6 divide-y sm:divide-y-0 divide-white/5">
            {/* 1. Siswa Aktif */}
            <StatCounter
              target={totalStudents}
              duration={2400}
              suffix="+"
              formatThousands={true}
              label="Siswa Aktif"
              iconBg="bg-sky-500/20 text-sky-400 border-sky-400/30"
              icon={
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0-.41 1.412A9.957 9.957 0 0 0 10 18a9.959 9.959 0 0 0 6.945-2.095 1.229 1.229 0 0 0-.41-1.412A9.99 9.99 0 0 0 10 12a9.99 9.99 0 0 0-6.535 2.493Z" />
                </svg>
              }
            />

            {/* 2. Tenaga Pendidik */}
            <StatCounter
              target={totalTeachers}
              duration={2400}
              suffix="+"
              formatThousands={true}
              label="Tenaga Pendidik"
              iconBg="bg-emerald-500/20 text-emerald-400 border-emerald-400/30"
              icon={
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path fillRule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.5 7.25c0-2.9 3.5-4.75 5.5-4.75 1.05 0 2.42.51 3.55 1.36a4.5 4.5 0 0 0-.05 4.64c-1 .3-2.2.5-3.5.5-2.9 0-5.5-.85-5.5-1.75ZM17.03 12.03a.75.75 0 0 0-1.06-1.06l-2.72 2.72-1.22-1.22a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.06 0l3.25-3.25Z" clipRule="evenodd" />
                </svg>
              }
            />

            {/* 3. Tahun Berdiri */}
            <StatCounter
              target={establishedYear}
              duration={2400}
              suffix=""
              formatThousands={false}
              label="Tahun Berdiri"
              iconBg="bg-sky-600/20 text-sky-300 border-sky-400/30"
              icon={
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path fillRule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clipRule="evenodd" />
                </svg>
              }
            />

            {/* 4. Program Keahlian */}
            <StatCounter
              target={totalMajors}
              duration={2400}
              suffix=""
              formatThousands={true}
              label="Program Keahlian"
              iconBg="bg-amber-500/20 text-amber-400 border-amber-400/30"
              icon={
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path fillRule="evenodd" d="M7.5 5.5A2.5 2.5 0 0 1 10 3h0a2.5 2.5 0 0 1 2.5 2.5V6h3A1.5 1.5 0 0 1 17 7.5v7A1.5 1.5 0 0 1 15.5 16h-11A1.5 1.5 0 0 1 3 14.5v-7A1.5 1.5 0 0 1 4.5 6h3v-.5ZM9 6h2v-.5a1 1 0 0 0-1-1h0a1 1 0 0 0-1 1V6Z" clipRule="evenodd" />
                </svg>
              }
            />

            {/* 5. Alumni Kerja */}
            <StatCounter
              target={totalAlumni}
              duration={2400}
              suffix="+"
              formatThousands={true}
              label="Alumni Kerja"
              iconBg="bg-emerald-500/20 text-emerald-400 border-emerald-400/30"
              icon={
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="h-5 w-5">
                  <path fillRule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clipRule="evenodd" />
                </svg>
              }
            />
          </div>
        </div>
      </div>
    </section>
  );
}
