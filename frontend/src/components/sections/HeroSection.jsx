import React from 'react';
import { ArrowRight, ChevronRight, Compass } from 'lucide-react';
import Skeleton from '../common/Skeleton';

export const HeroSection = ({ heroData, isLoading }) => {
  if (isLoading) {
    return (
      <section id="beranda" className="relative min-h-[85vh] flex items-center bg-slate-900 px-4 pt-28 pb-16">
        <div className="max-w-4xl mx-auto w-full space-y-4">
          <Skeleton className="h-6 w-40 !bg-slate-700" />
          <Skeleton className="h-12 w-3/4 !bg-slate-700" />
          <Skeleton className="h-20 w-2/3 !bg-slate-700" />
          <div className="flex gap-3 pt-4">
            <Skeleton className="h-11 w-36 !bg-slate-700" />
            <Skeleton className="h-11 w-36 !bg-slate-700" />
          </div>
        </div>
      </section>
    );
  }

  const title = heroData?.title || 'Membangun Generasi Unggul dan Berakhlak Mulia';
  const schoolName = heroData?.school_name || 'Jakarta Honors International College (JHIC)';
  const description = heroData?.description || 'Lembaga pendidikan kejuruan berstandar internasional yang berfokus pada penguasaan teknologi mutakhir, kompetensi industri terapan, dan integritas kepemimpinan.';
  const bgImage = heroData?.background_image || 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1920&auto=format&fit=crop';
  const buttonText = heroData?.button_text || 'Jelajahi Denah Kampus';
  const buttonUrl = heroData?.button_url || '#denah';

  return (
    <section id="beranda" className="relative min-h-[88vh] flex items-center justify-center overflow-hidden pt-32 pb-20 px-4 sm:px-6 lg:px-8">
      {/* Background Image & Overlay */}
      <div className="absolute inset-0 z-0">
        <img
          src={bgImage}
          alt={schoolName}
          className="w-full h-full object-cover object-center"
          onError={(e) => {
            e.target.src = 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1920&auto=format&fit=crop';
          }}
        />
        <div className="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-900/50" />
      </div>

      {/* Main Content */}
      <div className="relative z-10 max-w-4xl mx-auto w-full">
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-600/90 text-white text-xs font-semibold uppercase tracking-wider mb-5">
          <span>{schoolName}</span>
        </div>

        <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight mb-5">
          {title}
        </h1>

        <p className="text-sm sm:text-base md:text-lg text-slate-200 font-normal leading-relaxed max-w-2xl mb-8">
          {description}
        </p>

        <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
          <a
            href={buttonUrl}
            className="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-md transition-all cursor-pointer"
          >
            <Compass className="w-4 h-4" />
            <span>{buttonText}</span>
            <ArrowRight className="w-4 h-4" />
          </a>
          
          <a
            href="#profil"
            className="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-white/10 hover:bg-white/20 text-white font-medium text-sm border border-white/20 transition-all cursor-pointer"
          >
            <span>Profil Lengkap</span>
            <ChevronRight className="w-4 h-4" />
          </a>
        </div>
      </div>
    </section>
  );
};

export default HeroSection;
